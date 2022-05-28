<?php

namespace App\Services\User;

use App\Services\BaseControllerService;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Invite;
use App\Models\Contest;
use App\Models\UserMeta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Services\Contest\ContestService;
use App\Services\Helper\RoleCheck;

class UserService extends BaseControllerService
{
    /**
     * Получение списка пользователей
     *
     * @return Collection | User
     */
    public function get(int $id = null): Collection | User
    {
        /* Отдавать юзеров выше или равно текущего по роле */
        $roleCurrent = Auth::user()->role->id;
        $roleUser = RoleCheck::ROLES['user'];

        if (is_int($id))
        {
            $result = User::where('role_id', '<', $roleUser)
                ->where('role_id', '>=', $roleCurrent)
                ->findOrFail($id);
        }
        else {
            $result = User::where('role_id', '<', $roleUser)
                ->where('role_id', '>=', $roleCurrent)
                ->get();
        }
        return $result;
    }

    /**
     * Создание нового пользователя
     *
     * @param  object $request
     * @return User
     */
    public function create(object $request): User
    {
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->role_id = isset($request->role_id) ? $request->role_id : Role::DEFAULT;

        $user->save();

        /* Привязка пользователя к компаниям */
        $companies = Company::findMany($request->companies);
        $user->companies()->attach($companies);

        return $user;
    }

    /**
     * Обновление данных пользователя
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $user = User::findOrFail($id);
        $user->update($request->toArray());

        if ($request->companies)
        {
            $companies = Company::findMany($request->companies);
            $user->companies()->sync($companies);
        }

        return $user;
    }

    /**
     * Удаление пользователя
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return User::destroy($id);
    }

    /**
     * Установка участника победителем
     *
     * @param int   $id
     * @return void
     */
    public function setWinner(int $id)
    {
        $user = User::findOrFail($id);
        $userInvite = $user->invite;

        if ($userInvite)
        {
            $idContest = $userInvite->contest_id;
            $contest = Contest::findOrFail($idContest);
            $userIds = $contest->users->pluck('id')->toArray();

            /* счётчик победителей */
            $countWinners = UserMeta::whereIn('user_id', $userIds)
                ->where('order_winner', '>', 0)
                ->count();
            $order = $countWinners + 1;

            $userMeta = UserMeta::firstWhere('user_id', $id);

            if (!$userMeta->winner)
            {
                $updateData = [
                    'winner' => true,
                    'order_winner' => $order,
                ];
                $userMeta->update($updateData);
            }
        }

        return $user;
    }

    /**
     * Обновление участника
     *
     * @param object    $request
     * @param int       $id
     * @return void
     */
    public function participantUpdate (int $id, object $request)
    {
        $user = User::findOrFail($id);
        $userMeta = UserMeta::firstWhere('user_id', $user->id);
        $userMeta->update($request->toArray());
        return $user;
    }

}
