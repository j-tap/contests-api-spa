<?php

namespace App\Services\Invite;

use App\Services\BaseControllerService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Invite;

class InviteService extends BaseControllerService
{
    /**
     * Получение инвайта
     *
     * @return Collection | Invite
     */
    public function get(int $id = null): Collection | Invite
    {
        if (is_int($id)) {
            $result = Invite::findOrFail($id);
        }
        else {
            $result = Invite::get();
        }
        return $result;
    }

    /**
     * Создание нового инвайта
     *
     * @param  object $request
     * @return Invite
     */
    public function create(object $request): Invite
    {
        $invite = new Invite;

        $invite->hash = $request->hash;
        $invite->contest_id = $request->contest_id;
        $invite->manager_id = $request->manager_id;
        if (isset($request->active)) $invite->active = $request->active;
        if (isset($request->user_id)) $invite->user_id = $request->user_id;

        $invite->save();

        return $invite;
    }

    /**
     * Обновление данных инвайта
     *
     * @param int   $id
     * @param array $data
     * @return void
     */
    public function update(int $id, object $request)
    {
        $invite = Invite::findOrFail($id);
        $invite->update($request->toArray());
        return $invite;
    }

    /**
     * Удаление инвайта
     *
     * @param int | array  $id
     * @return void
     */
    public function destroy(int | array $id)
    {
        return Invite::destroy($id);
    }

    /**
     * Получение инвайта по хешу
     *
     * @param string|null $hash
     * @return Invite
     */
    public function getByHash(string|null $hash = null): Invite | bool
    {
        $invites = Invite::where('hash', $hash);

        if ($invites->exists())
        {
            return $invites->first();
        }
        return false;
    }

}
