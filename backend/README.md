# Contest api
Сервис для сбора участников и последующего розыгрыша для группы компаний

### Используемое в проекте
- [Laravel](https://github.com/laravel/laravel)
- [Simple QrCode](https://github.com/SimpleSoftwareIO/simple-qrcode)
- [MadelineProto](https://github.com/danog/MadelineProto)

### Установка
- настройка переменных окружения
- `composer install`
- `docker-compose build`
- `docker-compose up -d`
- `php artisan migrate`
- `php artisan db:seed`
- `npm i`
- `npm run prod`
- `php artisan madeline-proto:login`

### Помощь

[Postman коллекция](https://www.getpostman.com/collections/a6058373326598c0c284)
#### Настройка
Получить [app_id и api_hash](https://my.telegram.org/apps)
В файле .env нужно прописать:
```
# Данные для входа администратора
ADMIN_EMAIL="example@example.com"
ADMIN_PASSWORD="examplepassword"
# Данные для работы системы с Telegram
# Телефон администратора для авторизации, нигде больше не используется
TELEGRAM_PHONE="+00000000000"
# app_id и api_hash для работы с telegram
TELEGRAM_API_ID="000000000"
TELEGRAM_API_HASH="a0a0a0a0a0a0a0a0a0a0a0a0a0a0a0a0a0a0a"
```

###### Для запуска и работы
- `php artisan manager:add` добавить нового менеджера
- `php artisan db:seed --class=NameSeeder` выполнить один сид
- `php artisan migrate:fresh` очистка и миграции
- `php artisan db:seed` заполение основными данными
- `php artisan optimize:clear` очистка всех кешей
- `php artisan route:cache` очистка кешей роутов
- `php artisan madeline-proto:login` авторизация в tg
- `php artisan migrate --path=/database/migrations/FILE` конкретная миграция
- `php artisan route:list` показать список роутов

###### Structure
- `php artisan make:controller NameController --api` создать ресурсный [контроллер](https://laravel.com/docs/8.x/controllers)
- `php artisan make:model Name -m` создать модель с миграцией
- `php artisan make:resource Name` создать ресурс
- `php artisan make:request NameRequest` создать реквестный файл
- `php artisan make:seeder NameSeeder` создать сидер
- `php artisan make:rule NameRule` создать правило валидации
- `php artisan make:migration create_name_table` создать миграцию
- `php artisan make:middleware Name` создать middleware

###### Dev
`npx kill-port 8000` остановка сервера если не отвечает
