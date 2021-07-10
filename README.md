# Ester AS
el proyecto esta realizado en:
* `Laravel`
* `vue.js`
*`Inertia.js`
    
## Requerimientos
installar los siguientes paquetes:
* `apache` 
* `php`
* `mysql`
* `composer`
* `node.js`

## Instalar
Ejecutar los siguientes comandos en el proyecto:
* `composer install`
* `npm install`
* `php -r "file_exists('.env') || copy('.env.example', '.env');"`
* `php artisan key:generate --ansi`
para correr el proyecto
* `php artisan serve`
* `npm run watch`

## Configuraciones
solo se modifica el archivo .env del proyecto

DB_CONNECTION=`mysql`
DB_HOST=`127.0.0.1`
DB_PORT=`3306`

DB_DATABASE=`_nombre_BD_`
DB_USERNAME=`_usuario_BD_`
DB_PASSWORD=`_contraseña_BD_`

## Migrate
para crear, editar o eliminar tablas se usa migrate (https://laravel.com/docs/8.x/migrations)
* `php artisan migrate`

para llenar el primer dato de la tabla users
* `php artisan db:seed --class=UserSeeder`

##Documentacion
* https://laravel.com/docs/8.x/
* https://vuejs.org/v2/guide/
* https://inertiajs.com/
* https://bootstrap-vue.org/docs
