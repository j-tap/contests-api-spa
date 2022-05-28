<?php

namespace App\Services\LandingTemplate;

use App\Services\BaseControllerService;
use App\Models\LandingTemplate;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Helper\Convertation;

class LandingTemplateService extends BaseControllerService
{
    /**
     * Получение шаблонов
     *
     * @return Collection | LandingTemplate
     */
    public function get(int $id = null): Collection | LandingTemplate
    {
        if (is_int($id)) {
            $result = LandingTemplate::findOrFail($id);
        }
        else {
            $result = LandingTemplate::get();
        }
        return $result;
    }

    /**
     * Создание нового шаблона
     *
     * @param  object $request
     * @return LandingTemplate
     */
    public function create(object $request): LandingTemplate
    {
        $landingTemplate = new LandingTemplate;

        $landingTemplate->key = Convertation::stringToSnakeCase($request->name);
        $landingTemplate->name = $request->name;

        $landingTemplate->save();

        return $landingTemplate;
    }

    /**
     * Обновление шаблона
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $landingTemplate = LandingTemplate::findOrFail($id);
        $landingTemplate->update($request->toArray());

        return $landingTemplate;
    }

    /**
     * Удаление шаблона
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return LandingTemplate::destroy($id);
    }
}
