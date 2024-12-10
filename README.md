## Тестовое задание Иван Михайлов Securitm

### Установка и настройка проекта. 

1. Скачать проект из репозитория.
2. Перейти в папку с проектом. `cd ~/Securitm`
3. В папке запустить сборку докера `docker compose up -d --build`
4. После успешной установки, проверить что контейнеры поднялись  `docker-compose ps`. Должны подняться 4 контейра.

|NAME                |STATUS  |COMMAND                  |SERVICE  |  
|--------------------|--------|-------------------------|---------|
|securitm-db-1       |running |"docker-entrypoint.s…"   |db       |            
|securitm-nginx-1    |running |"/docker-entrypoint.…"   |nginx    |            
|securitm-php-1      |running |"docker-php-entrypoi…"   |php      |           
|securitm-redis-1    |running |"docker-entrypoint.s…"   |redis    |

5. Зайти в контейнер PHP `docker compose exec php bash`
6. В нем выполнить команды для разрешения доступов. 

    `chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache`

    `chmod -R 775 /var/www/storage /var/www/bootstrap/cache`
7. запустить сборку проекта через композер `composer setup`

Когда все собралось можно открыть http://localhost/. Появится стандартная страница Laravel.

Может возникнуть ситуация когда порты заняты (docker настроен на дефолтные порты 80). 
Нужно потушить сервисы, которые мешают и запустить сборку заново. 

### REST API

#### Реализовано сидирование таблицы Users. 

Чтобы запустить сиды нужно выполнить команду `php artisan db:seed --class=UserSeeder` 

или пересобрать миграции и засидировать `php artisan migrate:fresh --seed --seeder=UserSeeder` 

так как таблица была расширена 2 полями `ip` и `comments`

#### Реализован CRUD для модели Users. 

Доступные роуты.

| Method    | URL           | Controller                                 |
|-----------|---------------|--------------------------------------------|
| GET/HEAD  |v1/users       | users.index › Api\UserController@index     |
| POST      |v1/users       | users.store › Api\UserController@store     |
| GET/HEAD  |v1/users/{user} | users.show › Api\UserController@show       |
| PUT/PATCH |v1/users/{user} | users.update › Api\UserController@update   |
| DELETE    |v1/users/{user} | users.destroy › Api\UserController@destroy |

Роут `users.index` поддерживает сортировку и фильтрацию по полю `name` 
Запрос будет выглядеть вот так `/v1/users?name=ie&sort=-name`. 

Роут `users.store` Создание пользователя. Данные передаются в body в формате json
Обязательные поля `name`,`email`,`ip`,`comment`,`password`. Что-то не указали, валидация не пропустит. 
Так же стоит учесть, то что `email`, должен быть уникален и `ip` формата `ipv4`. 

Пример

```json
{
    "name": "MR red",
    "email" : "ivasn44@ian.com",
    "password" : "Test123!",
    "ip" : "111.196.100.14",
    "comment" : "blblblb lbblbb bl"
}
```

Роут `users.update` Обновление пользователя. 
Данные передаются в body в формате json. 
Поля доступные для обновления, такие же как и в `store`, но есть возможность обновлять частично.

Пример
```json
{
    "name": "my awesome name"
}
```


