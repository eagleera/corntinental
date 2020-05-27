# Corntinental - Examen Final - Programación web 2
Aplicación creada con Laravel y Vue para llevar la puntuación del juego [https://es.wikipedia.org/wiki/Continental_(juego)](Continental)

#### Nota: Esta aplicación usa como base de datos PostgreSQL

## ¿Como inicializar el proyecto?
Para inicializar el proyecto es necesario hacerlo de la misma manera en que se configura un proyecto de laravel.
Es necesario comprobar los requisitos oficiales de laravel antes de comenzar.

### Clonar el repositorio
```
git clone git@github.com:eagleera/corntinental.git
```
### Cambiar a la carpeta del repo clonado
```
cd corntinental
```
### Instalar todas las dependencias con composer
```
composer install
```
### Correr los migration y seeder  de la app
Es necesario indicar la conexión a la base de datos en el .env antes de correr el comando
```
php artisan migrate:refresh --seed
```
### Inicializar el servidor local
```
php artisan serve
```
### .env de ejemplo
** = misma que la configuración inicial de laravel
```
APP_NAME=Corntinental
APP_ENV=**
APP_KEY=**
APP_DEBUG=**
APP_URL=**
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres

######
Los siguientes datos de pusher son obtenidos al crear una cuenta y ligar las credenciales de pusher desde https://pusher.com/
#####
PUSHER_APP_ID=_id_pusher
PUSHER_APP_KEY=_key_pusher
PUSHER_APP_SECRET=_secret_pusher
PUSHER_APP_CLUSTER=us3
BROADCAST_DRIVER=pushe
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
#
JWT secret es generada al correr el comando $ php artisan jwt:secret
#
JWT_SECRET= _resultado_de_phpartisanjwt:secret
#
Configuración para los correos
#
MAIL_MAILER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=cuenta_de_correo_gmail
MAIL_PASSWORD=contraseña_correo_gmail
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=cuenta_de_correo_gmail
MAIL_FROM_NAME="${APP_NAME}"
```