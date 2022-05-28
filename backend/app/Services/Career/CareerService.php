<?php

namespace App\Services\Career;

use App\Services\BaseControllerService;
use App\Models\Career;
use Illuminate\Database\Eloquent\Collection;

class CareerService extends BaseControllerService
{
    /**
     * Получение списка видов деятельности
     *
     * @return Collection | Career
     */
    public function get(int $id = null): Collection | Career
    {
        if (is_int($id)) {
            $result = Career::findOrFail($id);
        }
        else {
            $result = Career::get();
        }
        return $result;
    }

    /**
     * Создание нового вида деятельности
     *
     * @param  object $request
     * @return Career
     */
    public function create(object $request): Career
    {
        $career = new Career;

        $career->name = $request->name;

        $career->save();

        return $career;
    }

    /**
     * Обновление вида деятельности
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $career = Career::findOrFail($id);
        $career->update($request->toArray());

        return $career;
    }

    /**
     * Удаление вида деятельности
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Career::destroy($id);
    }
}
