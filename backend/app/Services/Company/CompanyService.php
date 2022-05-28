<?php

namespace App\Services\Company;

use App\Services\BaseControllerService;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Services\Setting\SettingService;
use App\Services\Company\Setting;

class CompanyService extends BaseControllerService
{
    private $settingsService;

    /**
     * @param  SettingService $settingsService
     */
    public function __construct(SettingService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Получение списка пользователей
     *
     * @return Collection | Company
     */
    public function get(int $id = null): Collection | Company
    {
        /* Отдавать компании админу все, остальным - только их */
        $userCurrent = Auth::user();
        $roleCurrent = $userCurrent->role->id;
        $companiesCurrent = $userCurrent->companies
            ->pluck('id')
            ->toArray();

        if (is_int($id))
        {
            if ($roleCurrent === Role::ADMIN || in_array($id, $companiesCurrent))
            {
                $result = Company::findOrFail($id);
            }
            else {
                throw new AccessDeniedHttpException();
            }
        }
        else {
            if ($roleCurrent === Role::ADMIN)
            {
                $result = Company::get();
            }
            else {
                $result = Company::whereIn('id', $companiesCurrent)->get();
            }
        }
        return $result;
    }

    /**
     * create
     *
     * @param  object $request
     * @return Company
     */
    public function create(object $request): Company
    {
        $company = new Company;

        $company->name = $request->name;

        $company->save();

        Setting::createSettings($company->id);

        return $company;
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
        $company = Company::findOrFail($id);
        $company->update($request->toArray());

        return $company;
    }

    /**
     * Удаление пользователя
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Company::destroy($id);
    }

}
