<?php

namespace App\Services\SettingType;

use App\Services\BaseControllerService;
use App\Models\SettingType;
use Illuminate\Database\Eloquent\Collection;

class SettingTypeService extends BaseControllerService
{
    /**
     * Получение списка настроек
     *
     * @return Collection | SettingType
     */
    public function get(int $id = null): Collection | SettingType
    {
        if (is_int($id)) {
            $result = SettingType::findOrFail($id);
        }
        else {
            $result = SettingType::get();
        }
        return $result;
    }

    /**
     * Создание новой настройки
     *
     * @param  object $request
     * @return SettingType
     */
    public function create(object $request): SettingType
    {
        $settingType = new SettingType;

        $settingType->name = $request->name;

        if (isset($request->description)) $settingType->description = $request->description;

        $settingType->save();

        return $settingType;
    }

    /**
     * Обновление настройки
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $settingType = SettingType::findOrFail($id);
        $settingType->update($request->toArray());

        return $settingType;
    }

    /**
     * Удаление настройки
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return SettingType::destroy($id);
    }
}
