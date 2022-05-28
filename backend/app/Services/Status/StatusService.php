<?php

namespace App\Services\Status;

use App\Services\BaseControllerService;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class StatusService extends BaseControllerService
{
    /**
     * Получение статусов
     *
     * @return Collection | Status
     */
    public function get(int $id = null): Collection | Status
    {
        if (is_int($id)) {
            $result = Status::findOrFail($id);
        }
        else {
            $result = Status::get();
        }
        return $result;
    }

    /**
     * Создание нового статуса
     *
     * @param  object $request
     * @return Status
     */
    public function create(object $request): Status
    {
        $status = new Status;
        $status->name = $request->name;

        $status->save();

        return $status;
    }

    /**
     * Обновление статуса
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $status = Status::findOrFail($id);
        $status->update($request->toArray());

        return $status;
    }

    /**
     * Удаление статуса
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Status::destroy($id);
    }
}
