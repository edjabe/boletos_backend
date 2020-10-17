<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

La aplicación para esta prueba ha sido creada en Laravel, es una api rest que nos permite realizar el registro de compradores, validar la disponibilidad de boletas y la reserva de las mismas.

## 1. DESPLIEGUE

``` bash
# Primero clonamos el repositorio
$ git clone https://github.com/edjabe/boletos_backend.git boletos_backend

# Ingresamos al proyecto
$ cd boletos_backend

# Se debe copiar y confiagurar el archivo .env y .env.testing (En caso de que este incluido saltarse este paso)
$ cp .env.example .env
```
Una vez creado el archivo .env se configura lo siguiente:

```
APP_URL=http://localhost //Url de la aplicacion

DB_HOST=127.0.0.1 //Host del servidor de DB
DB_PORT=3306 //Puerto del servicio de DB
DB_DATABASE=psicol //Nombre de la DB
DB_USERNAME=root //Usuario de la DB
DB_PASSWORD= //Password de la DB

```
Una vez creado el archivo .env.testing se configura lo siguiente:

```
APP_URL=http://localhost //Url de la aplicacion

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=psicol_test
DB_USERNAME=root
DB_PASSWORD=


```

Una vez configurado el archivo .env, procedemos ingresar a la carpeta de boletos_backende instalamos los paquete de composer que se requieren:

```
composer install
```

Una vez instalados los paquete, dentro de la carpeta de boletos_backend, ejecutamos los siguientes comandos:

```
php artisan key:gererate
php artisan jwt:secret
```
Posteriormente, ejecutamos la migración y llenado de la base de datos por permedio de los siguientes comandos, recuerde que debe tener creada una base creada con anterioridad:

```
php artisan migrate //Crea cada una de las tablas utilizadas en la aplicación.
php artisan db:seed //Llena las tablas con datos configurados mediantes el factory y seed.
```
Para terminar ejecutamos los test correspodientes para validar que las funcionalidades del aplicativo se cumplan:

```
vendor\bin\phpunit //Ejecutas los tests creados y la respectiva base de pruebas para realizarlos
```

## 2.  DOCUMENTACIÓN API

```
1. Route::post('login', 'AuthController@login'); //POST
```
Encargada del inicio de sesión del aplicativo, si esta correcta nos retorna el token de autenticación.

Recibe:

```
{
    "email": "prueba@prueba.com",
    "password": "psicol2020"
}
```
Retorna
```
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYwMjk1NDY1MywiZXhwIjoxNjAyOTU4MjUzLCJuYmYiOjE2MDI5NTQ2NTMsImp0aSI6IktUdjlYWTNjUUEwOXc1amIiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.Y4vE1ItdB6QzaxzM2uum2rlrByFS0OL-gl09KLmr2Pk",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Usuario",
        "last_name": "Prueba",
        "address": "Direccion 1",
        "phone_number": "2343434343",
        "email": "prueba@prueba.com",
        "email_verified_at": "2020-10-17T14:13:44.000000Z",
        "created_at": "2020-10-17T14:13:44.000000Z",
        "updated_at": "2020-10-17T14:13:44.000000Z",
        "deleted_at": null
    }
}
```

```

2. Route::post('register', 'AuthController@register'); //POST
```
Encargada del registro de los nuevos compradores.

Recibe:

```
{
    "name": "Prueba",
    "last_name": "Documentacion",
    "address": "Direccion prueba",
    "phone_number": "45443434",
    "email": "prueba32s@prueba.com",
    "password": "psicol2020",
    "password_confirmation": "psicol2020"
}
```

Retorna:

```
{
    "message": "Usuario registrado satisfactoriamente",
    "user": {
        "name": "Nueva 3",
        "last_name": "Prueba 3",
        "address": "Direccion 3",
        "email": "prueba3@prueba",
        "updated_at": "2020-10-17T15:36:24.000000Z",
        "created_at": "2020-10-17T15:36:24.000000Z",
        "id": 6
    }
}
```
Las siguientes api requieren de una previa autenticación ya que se validan con el Token que se genera al iniciar sesión. Igualmente se pueden ver en su correspondiente orden y prefijo dentro del archivo routes/api.php
```
3. Route::post('user/refresh', 'AuthController@refresh'); //POST
```
Refresca la sesión y nos otorga un nuevo token para el comprador logueado.

Recibe: el token de la sesión actual

Retorna:

```
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC91c2VyXC9yZWZyZXNoIiwiaWF0IjoxNjAyOTU2Mjg0LCJleHAiOjE2MDI5NTk5MTksIm5iZiI6MTYwMjk1NjMxOSwianRpIjoiZnN0S0FMTnR5N1hLR1hWaiIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.OuTquZ1oVgDxNL4GJL_wgYKhGLxzcmk4B3esId_RsXU",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Usuario",
        "last_name": "Prueba",
        "address": "Direccion 1",
        "phone_number": "2343434343",
        "email": "prueba@prueba.com",
        "email_verified_at": "2020-10-17T14:13:44.000000Z",
        "created_at": "2020-10-17T14:13:44.000000Z",
        "updated_at": "2020-10-17T14:13:44.000000Z",
        "deleted_at": null
    }
}

```
```
4. Route::post('user/logout', 'AuthController@logout');
```
Cierra la sesión actual del comprador logueado

Recibe: el token de la sesión actual

Retorna:

```
{
    "message": "Usuario deslogueado"
}
```
```
5. Route::get('user/user-profile', 'AuthController@logout');
```
Consulta la información del usuario logueado actualmente

Recibe: el token de la sesión actual

Retorna:

```
{
    "id": 1,
    "name": "Usuario",
    "last_name": "Prueba",
    "address": "Direccion 1",
    "phone_number": "2343434343",
    "email": "prueba@prueba.com",
    "email_verified_at": "2020-10-17T14:13:44.000000Z",
    "created_at": "2020-10-17T14:13:44.000000Z",
    "updated_at": "2020-10-17T14:13:44.000000Z",
    "deleted_at": null
}
```

```
6. Route::get('reservations/', 'ReservationController@index');
```
Consulta todas las reservaciones de boletas guardadas en la base de datos

Recibe: el token de la sesión actual

Retorna:

```
{
    "results": 1,
    "reservations": [
        {
            "id": 1,
            "user_id": 1,
            "ticket_id": 3,
            "created_at": "2020-10-17T14:13:44.000000Z",
            "updated_at": "2020-10-17T14:13:44.000000Z",
            "deleted_at": null,
            "user": {
                "id": 1,
                "name": "Usuario",
                "last_name": "Prueba",
                "address": "Direccion 1",
                "phone_number": "2343434343",
                "email": "prueba@prueba.com",
                "email_verified_at": "2020-10-17T14:13:44.000000Z",
                "created_at": "2020-10-17T14:13:44.000000Z",
                "updated_at": "2020-10-17T14:13:44.000000Z",
                "deleted_at": null
            },
            "ticket": {
                "id": 3,
                "day": "2020-11-20",
                "event_name": "Spencer Inc",
                "quantity": 94,
                "start_time": "2020-11-20 08:00:00",
                "finish_time": "2020-11-20 10:00:00",
                "description": null,
                "created_at": "2020-10-17T14:13:44.000000Z",
                "updated_at": "2020-10-17T14:13:44.000000Z",
                "deleted_at": null
            }
        }
    ]
}
```


```
7. Route::get('reservations/{user_id}', 'ReservationController@userReservation');
```
Consulta todas las reservaciones de boletas realizadas por un comprador.

Recibe: el token de la sesión actual y el id del comprador a consultar

Retorna:

```
{
    "results": 1,
    "reservations": [
        {
            "id": 2,
            "user_id": 3,
            "ticket_id": 7,
            "created_at": "2020-10-17T14:13:44.000000Z",
            "updated_at": "2020-10-17T14:13:44.000000Z",
            "deleted_at": null,
            "user": {
                "id": 3,
                "name": "Edward",
                "last_name": "Kunze",
                "address": "415 Eichmann Center\nHegmannbury, OK 13625-8170",
                "phone_number": "351-758-7241 x65479",
                "email": "demario57@example.net",
                "email_verified_at": "2020-10-17T14:13:44.000000Z",
                "created_at": "2020-10-17T14:13:44.000000Z",
                "updated_at": "2020-10-17T14:13:44.000000Z",
                "deleted_at": null
            },
            "ticket": {
                "id": 7,
                "day": "2020-12-27",
                "event_name": "Jacobs and Sons",
                "quantity": 32,
                "start_time": "2020-12-27 08:00:00",
                "finish_time": "2020-12-27 11:00:00",
                "description": null,
                "created_at": "2020-10-17T14:13:44.000000Z",
                "updated_at": "2020-10-17T14:13:44.000000Z",
                "deleted_at": null
            }
        }
    ]
}
```

```
8. Route::post('reservations/register', 'ReservationController@register');
```
Realiza la asignación de una boleta a un comprador en especifico.

Recibe: el token de la sesión actual y los datos correspondientes.

```
{
    "user_id" : 1,
    "ticket_id" : 2
}
```

Retorna:

```
{
    "message": "Su boleta a sido reservada correctamente.",
    "reservation": {
        "user_id": 1,
        "ticket_id": 2,
        "updated_at": "2020-10-17T18:01:44.000000Z",
        "created_at": "2020-10-17T18:01:44.000000Z",
        "id": 9
    }
}
```

```
9. Route::get('tickets/', 'TicketController@index');
```
Consulta la disponibilidad de boletas existentes en el sistema las cuales el comprador puede adquirir.

Recibe: el token de la sesión actual.


Retorna:

```
{
    "results": 2,
    "tickets": [
        {
            "id": 1,
            "day": "2020-10-31",
            "event_name": "Considine, Heller and Corkery",
            "quantity": 37,
            "start_time": "2020-10-31 08:00:00",
            "finish_time": "2020-10-31 18:00:00",
            "description": null,
            "created_at": "2020-10-17T14:13:44.000000Z",
            "updated_at": "2020-10-17T14:13:44.000000Z",
            "deleted_at": null
        },
        {
            "id": 2,
            "day": "2020-11-17",
            "event_name": "Predovic PLC",
            "quantity": 86,
            "start_time": "2020-11-17 08:00:00",
            "finish_time": "2020-11-17 12:00:00",
            "description": null,
            "created_at": "2020-10-17T14:13:44.000000Z",
            "updated_at": "2020-10-17T18:01:44.000000Z",
            "deleted_at": null
        }
    ]
}
```
