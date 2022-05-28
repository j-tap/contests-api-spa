<?php

namespace App\Services\Contest;

use App\Models\Contest;
use App\Models\Company;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Contest\RegistrationRequest;
use App\Http\Requests\Contest\ContestQrRequest;
use App\Http\Resources\Career\CareerCollection;
use App\Services\User\UserService;
use App\Services\Invite\InviteService;
use App\Services\Career\CareerService;
use App\Services\Contest\Participant;
use App\Services\Contest\Setting;
use App\Services\Tg\TgApi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContestService
{
    private $userService;
    private $inviteService;
    private $careerService;

    /**
     * @param  UserService $userService
     * @param  InviteService $inviteService
     * @param  CareerService $careerService
     */
    public function __construct(UserService $userService, InviteService $inviteService, CareerService $careerService)
    {
        $this->userService = $userService;
        $this->inviteService = $inviteService;
        $this->careerService = $careerService;
    }

    /**
     * Получение списка розыгрышей
     *
     * @return Collection | Contest
     */
    public function get(int $id = null): Collection | Contest
    {
        if (is_int($id))
        {
            $contest = Contest::findOrFail($id);
            $contest->participants = Participant::toParticipants($contest);
            $result = $contest;
        }
        else {
            $result = Contest::get();
        }
        return $result;
    }

    /**
     * Создание нового розыгрыша
     *
     * @param  object $request
     * @return Contest
     */
    public function create(object $request): Contest
    {
        $contest = new Contest;

        $contest->name = $request->name;
        $contest->company_id = $request->company_id;
        $contest->landing_template_id = $request->landing_template_id;
        $contest->status_id = $request->status_id || 1;

        if (isset($request->active)) $contest->active = $request->active;
        if (isset($request->status_id)) $contest->status_id = $request->status_id;
        if (isset($request->date_from)) $contest->date_from = $request->date_from;
        if (isset($request->date_to)) $contest->date_to = $request->date_to;

        $contest->save();

        Setting::createSettings($contest->company_id, $contest->id);

        return $contest;
    }

    /**
     * Обновление розыгрыша
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $contest = Contest::findOrFail($id);
        $extra = [];
        if ($request->status_id !== 1) /* status 1 - в работе */
        {
            $extra['active'] = 0;
        }
        $result = array_merge($request->toArray(), $extra);
        $contest->update($result);

        return $contest;
    }

    /**
     * Удаление розыгрыша
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Contest::destroy($id);
    }

    /**
     * Регистрация нового участника
     *
     * @param  RegistrationRequest $request
     * @return User
     */
    public function registrationUser(RegistrationRequest $request): User
    {
        $passwordParticipant = "password-participant";
        $username = str_replace('@', '', $request->telegram);
        $telegramId = null;

        $request->password = $passwordParticipant;

        $tgApi = app(TgApi::class);
        /* Разрешает записать в базу участника без telegram_id,
           нужно для теста, с валидацией телеграм всё равно необходим */
        try {
            $tgUser = $tgApi->getUser($username);
            $telegramId = $tgUser['id'];
        }
        catch (\Exception $e)
        {
            $msg = $e->getMessage();
            Log::warning("Error in `ContestService` in the method `registrationUser()` during the execution of `tgApi->getUser()`: $msg");
        }

        DB::beginTransaction();

        $user = $this->userService->create($request, true);

        $uniqCode = Participant::generateUniqueCode($user->id);
        $request->code = $uniqCode;

        $invite = $this->inviteService->getByHash($request->hash);
        $invite->user_id = $user->id;
        $invite->active = false;

        // TODO: сделать через сервис (в других подобных местах тоже)
        $meta = new UserMeta;
        $meta->code = $request->code;
        $meta->telegram = $request->telegram;
        $meta->telegram_id = $telegramId;
        $meta->career = $request->career;

        $meta->user()->associate($user);
        $user->contests()->attach($invite->contest_id);

        $meta->save();
        $invite->save();
        $user->save();

        DB::commit();

        return $user;
    }

    /**
     * Получение QR кода
     *
     * @param ContestQrRequest $contestId
     * @return array
     */
    public function qrCode(ContestQrRequest $request): array
    {
        // $this->get($request->id);

        $managerId = auth()->user()->id;
        // $host = request()->getSchemeAndHttpHost();

        $invite = Participant::createInvite($managerId, $request->id);

        $contest = Contest::findOrFail($invite->contest_id);
        $company = Company::findOrFail($contest->company_id);

        /* Получение настроек из текущей компании */
        $companySettings = $company->settings();
        $settingCompanyColors = $companySettings->firstWhere('key', 'company_colors');
        $companyColors = $settingCompanyColors->value;
        $companyColorsArr = explode(',', preg_replace('/\s+/', ' ', $companyColors));

        /* Получение настроек из текущего розыгрыша */
        $contestSettings = $contest->settings();
        $settingLandingUrl = $contestSettings->firstWhere('key', 'landing_url');
        $urlContestForm = $settingLandingUrl->value;

        /* Ссылка-пришлашение, для qr */
        $link = "$urlContestForm?hash=$invite->hash";

        /* Номер цветовой схемы для ротации */
        $numberColor = intval($request->number_color);

        $qrCode = Participant::getQrCode($link, $numberColor, $companyColorsArr);

        return [
            'link' => $link,
            'qr' => $qrCode->qr,
            'bg' => $qrCode->bg,
            'theme' => $qrCode->theme,
            'number_color' => $qrCode->number_color,
        ];
    }

    /**
     * Получение информации по хешу
     *
     * @param string $hash
     * @return
     */
    public function infoByHash(string $hash)
    {
        $invite = $this->inviteService->getByHash($hash);
        /* Дополнительно передача списка видов деятельности */
        $careers = $this->careerService->get();

        if ($invite)
        {
            $result = (object) [
                'invite' => $invite,
                'contest' => $invite->contest,
                'careers' => new CareerCollection($careers),
            ];
            return $result;
        }
        throw new NotFoundHttpException();
    }

    /**
     * Получение кодов и id участников
     *
     * @param int $id
     * @return
     */
    public function getParticipants(int $idContest)
    {
        $contest = $this->get($idContest);
        $users = collect(Participant::toParticipants($contest));
        /* Только участники канала */
        $result = $users->filter(function ($item, $key) {
            return $item->meta->participant_telegram === 1;
        });
        return $result;
    }
}
