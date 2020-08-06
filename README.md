# Prueba con Laravel y MySQL
Esta aplicación está hecha con Laravel 7.x y MySQL por [Adrián Pelayo](https://www.github.com/bigbae18). Está escrita en **Inglés**. Cumple las necesidades de:
- Registrar usuarios.
- Autentificar usuarios.
- Insertar y actualizar `IBAN`, DNI | `Identity Document`, Dirección de Facturación | `Billing Address`
- Validación de formularios.
### Requerimientos
Necesitarás tener instalado para instalar las dependencias y crear la conexión para configurarla en el archivo `.env`
* [PHP](https://www.php.net/) >= 7.*
* [Composer](https://getcomposer.org/)
* [XAMPP para MySQL](https://www.apachefriends.org/es/index.html)
#### Setup
**Primero de todo necesitarás clonar este repositorio**
```
git clone https://github.com/bigbae18/laravel-mysql-test.git mi-directorio
```
**Cambiamos a nuestro directorio**
```
cd mi-directorio
```
**Instalamos las dependencias del proyecto**
```
composer install
```
**Una vez instaladas las dependencias**, debemos copiar todo el contenido de `.env.example` dentro de un nuevo fichero `.env` y asegurarnos que tenemos una base de datos llamada "adribank". 

En caso de tener un puerto distinto en tu conexión de MySQL que el por defecto, querer usar una base de datos propia (con otro nombre, o otras credenciales de usuario), deberemos editar las siguientes variables en el fichero `.env`
```
DB_PORT=<puerto de conexión>
DB_DATABASE=<nombre de base de datos>
DB_USER=<usuario>
DB_PASSWORD=<contraseña>
```
**Para crear las tablas en nuestra base de datos**, existen 2 migraciones en `..\database\migrations\` con las tablas y los campos hechos. Si nuestros datos de conexión están bien en `.env`, y nuestra conexión a MySQL abierta, debemos introducir
```
php artisan migrate
```
**Aunque os recomiendo utilizar las migraciones con el UserSeeder, que genera usuarios con datos aleatorios pero encajando nuestro patrón de validación**, y no te preocupes si has generado las migraciones ya, vuelve a tu terminal y escribe
```
php artisan migrate:fresh --seed
```
Si todo ha ido bien, al introducir el comando `php artisan serve` veremos un mensaje conforme nuestro servidor ha sido abierto con enlace `http://localhost:8000/`

### Uso de la Aplicación

**En esta parte de la explicación, os desglosaré los diferentes directorios importantes**
##### UserSeeder
Ruta:
```
..\database\seeds\UserSeeder.php
```
Este Seeder es una funcionalidad que brinda Laravel para poder generar datos aleatorios en una base de datos con el modelo que tenemos ya establecido (`..\app\User.php`). Comando: `php artisan migrate:fresh --seed` (Resetea la base de datos e introduce los usuarios generados por el Seeder). Estos usuarios se crean por defecto con la contraseña `password`. 
Así que para hacer login con uno de estos usuarios, debemos acceder a `localhost/phpMyAdmin`, copiar el correo y usarlo como credencial junto a la palabra `password` como contraseña para que pueda hacer la comprobación el controlador.

##### Controladores
Ruta:
```
..\app\Http\Controllers
```
> RegisterController.php

| Método | Explicación | Ruta |
| ------ | ------ | ------ |
| **index()** | Se encarga de devolver la vista del formulario para que el usuario se registre. | `GET` **/register** |
| **store(Request $request)** | Se encarga de procesar la solicitud y validar los datos introducidos por el usuario, devolver los errores pertinentes o registrar a dicho usuario si todo ha salido bien. | `POST` **/register** |
> LoginController.php

| Método | Explicación | Ruta |
| ------ | ------ | ------ |
| **index()** | Se encarga de devolver la vista del formulario para que el usuario pueda validar sus credenciales. | `GET` **/login** |
| **store(Request $request)** | Se encarga de procesar la solicitud, hacer las comprobaciones necesarias contra la base de datos, devolver errores pertinentes o acabar autentificando al usuario. | `POST` **/login** |
> UserController.php

| Método | Explicación | Ruta |
| ------ | ------ | ------ |
| **index($id)** | Se encarga de devolver la vista del usuario por id. Valida si el usuario que están pidiendo es el que está autentificado, y hace dos consultas a base de datos para obtener al User y su UserInfo. | `GET` **/users/{id}/** |
| **create($id)** | Se encarga de devolver la vista del formulario para meter los datos `IBAN`, `Identity Document` y `Billing Address`. Validación de usuario autentificado y consultas para User y UserInfo. | `GET` **/users/{id}/create** |
| **store(Request $request, $id)** | Se encarga de procesar la solicitud y validar los datos introducidos por el usuario con los validadores. Utiliza `..\app\Rules\Iban` como validador personalizado. Devuelve errores si hay, sino inserta los datos en base de datos. | `POST` **/users/{id}/store** |
| **edit($id)** | Se encarga de devolver la vista del formulario para actualizar los datos del usuario. Validación de usuario y consultas para User y UserInfo | `GET` **/users/{id}/edit** |
| **update(Request $request, $id)** | Se encarga de actualizar usuarios. Se encarga de validar los datos introducidos por el usuario, y las peticiones a base de datos correspondientes. | `PUT` **/users/{id}/update** |

##### Vistas

Ruta para las vistas
```
..\resources\views
```
> \home.blade.php como invitado

![Home Guest](https://bigbae18.github.io/test_images/home_guest.PNG)
> \home.blade.php como autentificado

![Home Authentified](https://bigbae18.github.io/test_images/home_login.PNG)
> \login\index.blade.php

![Login Index](https://bigbae18.github.io/test_images/login_get.PNG)

**Dejo un ejemplo sobre como sería el login de un usuario generado con UserSeeder**

![UserSeeder Example](https://bigbae18.github.io/test_images/userseeder_login_example.PNG)
> \register\index.blade.php

![Register Index](https://bigbae18.github.io/test_images/register_get.PNG)
> \user\index.blade.php sin datos de usuario

![User Index Without Data](https://bigbae18.github.io/test_images/users_index.PNG)
> \user\index.blade.php con datos de usuario

![User Index With Data](https://bigbae18.github.io/test_images/users_index_with_data.PNG)
> \user\create.blade.php

![User Create](https://bigbae18.github.io/test_images/users_create.PNG)
> \user\edit.blade.php

![User Edit Missing Data](https://bigbae18.github.io/test_images/users_edit_missing_data.PNG)
##### Rutas

Rutas de la web
```
..\routes\web.php
```
Ahí podemos ver las rutas que están especificadas para cada uno de los métodos de los [controladores](#controladores)
##### Regla de Validación `IBAN`
Ruta del fichero
```
..\app\Rules\Iban.php
```
**La validación de** `IBAN` consta de una expresion regular que contiene el patrón de IBAN de España.

