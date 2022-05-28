<?php

namespace App\Services\Tg;

use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\Exception;
use danog\MadelineProto\API as MadelineProtoAPI;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Settings as ClientSettings;
use danog\MadelineProto\Settings\Serialization;
use danog\MadelineProto\Settings\RPC;

class TgApi
{
    private $api = null;
    private $sessionDir = null;
    private $sessionFile = 'session.madeline';

    /**
     * __construct
     *
     * Чтобы не создавались лишние экземпляры есть singletone в AppServiceProvider
     *
     * @return void
     */
    public function __construct()
    {
        if (!boolval(config('app.tg.api_id')) || !boolval(config('app.tg.api_hash')))
        {
            throw new \Exception('api_id и api_hash не установлены в env');
        }

        $this->sessionDir =  storage_path() .'/madeline';
        $sessionPath = $this->sessionDir .'/'. $this->sessionFile;

        if (!is_dir($this->sessionDir))
        {
            mkdir($this->sessionDir);
        }

        $settings = new ClientSettings();
        $appInfo = new AppInfo();
        // $serialization = new Serialization();
        $rpc = new RPC();

        $appInfo->setApiId(intval(config('app.tg.api_id')));
        $appInfo->setApiHash(config('app.tg.api_hash'));

        // $serialization->setInterval(60);

        $rpc->setRpcTimeout(60 * 5);
        $rpc->setFloodTimeout(60 * 5);
        $rpc->setLimitCallQueue(10);

        $settings->setAppInfo($appInfo);
        // $settings->setSerialization($serialization);
        $settings->setRpc($rpc);

        $this->api = new MadelineProtoAPI($sessionPath, $settings);

        $me = $this->api->getSelf();
        $this->api->logger($me);
    }

    /**
     * Только авторизованным
     *
     * @return
     */
    public function canLoggedIn()
    {
        if (!$this->isLoggedIn())
        {
            throw new \Exception('Авторзация в Telegram обязательна для этого действия');
        }
        return true;
    }

    /**
     * Проверка авторизации
     *
     * @return
     */
    public function isLoggedIn()
    {
        $self = $this->api->getSelf();
        return boolval($self);
    }

    /**
     * Получение юзера по username или id
     *
     * @param  string|int $username
     * @return
     */
    public function getUser(string|int $username)
    {
        $user = $this->api->getInfo($username);
        return $user['User'];
    }

    /**
     * Проверка существования username
     *
     * @param  string $username
     * @return bool
     */
    public function existUser(string $userName): bool
    {
        if ($this->canLoggedIn())
        {
            $user = $this->getUser($userName);
            return !empty($user);
        }
        return false;
    }

    /**
     * Список участников канала
     *
     * @param  string $channel
     * @param  string $field [id, name]
     * @return array
     */
    public function getIdsMembersChannel(string $channel, string $field = 'id'): array
    {
        $id = $this->getChannelIdByName($channel);
        $chatId = $id;
        $result = [];

        if (!preg_match('/-100\d*/', $id))
        {
            $chatId = intval('-100'. $id);
        }

        $channelInfo = $this->api->getPwrChat($chatId);

        /* Экстракция id участников канала */
        foreach ($channelInfo['participants'] as $k => $item)
        {
            $user = $item['user'];

            if ($user['type'] === 'user') // $item['role'] === 'user' &&
            {
                if (array_key_exists($field, $user))
                {
                    $result[] = $user[$field];
                }
            }
        }

        return $result;
    }

    /**
     * ID канала по name
     *
     * @param  string $channelName
     * @return int
     */
    public function getChannelIdByName(string $channelName): int
	{
		$channel = $this->getChannel($channelName);
		return intval($channel['full_chat']['id']);
    }

    /**
     * Информация о канале
     *
     * @param  string $channel
     * @return mixed
     */
    public function getChannel(string $channelName): mixed
	{
        return $this->api->channels->getFullChannel(['channel' => $channelName]);
	}

    /**
     * Отправка проверочного кода авторизации по номеру телефона
     *
     * @param  string $phone
     * @return mixed
     */
    public function sendVerificationCode(string $phone): mixed
    {
        return $this->api->phoneLogin($phone);
    }

    /**
     * Проверка проверочного кода
     *
     * @param  int $code
     * @return mixed
     */
    public function checkVerificationCode(int $code): mixed
    {
        return $this->api->completePhoneLogin($code);
    }

    /**
     * Logout
     *
     * @return bool
     */
    public function logout(): bool
    {
        $sessionPath = $this->sessionDir .'/'. $this->sessionFile;
        array_map('unlink', glob("$sessionPath*"));
        rmdir($this->sessionDir);
        $this->api->logout();
        return true;
    }

}
