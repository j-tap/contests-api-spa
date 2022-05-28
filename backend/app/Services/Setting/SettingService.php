<?php

namespace App\Services\Setting;

use App\Services\BaseControllerService;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SettingService extends BaseControllerService
{
    /**
     * Получение списка настроек
     *
     * @return Collection | Setting
     */
    public function get(int $id = null): Collection | Setting
    {
        if (is_int($id)) {
            $result = Setting::findOrFail($id);
        }
        else {
            $result = Setting::get();
        }
        return $result;
    }

    /**
     * Создание новой настройки
     *
     * @param  object $request
     * @return Setting
     */
    public function create(object $request): Setting
    {
        $setting = new Setting;

        $setting->key = $request->key;
        $setting->setting_type_id = $request->setting_type_id;
        $setting->name = $request->name;

        if (isset($request->description)) $setting->description = $request->description;
        if (isset($request->value)) $setting->value = $request->value;
        if (isset($request->company_id)) $setting->company_id = $request->company_id;

        if (isset($request->contest_id))
        {
            $setting->contest_id = $request->contest_id;
            $setting->company_id = null;
        }

        $setting->save();

        return $setting;
    }

    /**
     * Обновление настройки
     *
     * @param int   $id
     * @param object $request
     * @return void
     */
    public function update(int $id, object $request)
    {
        $setting = Setting::findOrFail($id);
        $setting->update($request->toArray());

        return $setting;
    }

    /**
     * Удаление настройки
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Setting::destroy($id);
    }

    /**
     * Обновление массива настроек
     *
     * @param object $request
     * @return void
     */
    public function updateMultiple(object $request)
    {
        // $settings = DB::table('settings')->upsert($request->list, ['id', 'key'], ['value']);
        $settings = collect([]);
        foreach ($request->list as $data)
        {
            $setting = Setting::findOrFail($data['id']);
            $setting->update(['value' => $data['value']]);
            $settings->push($setting);
        }
        return $settings;
    }

}
