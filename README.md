### Red Social de preguntas con socialite (facebook/google)
Este proyecto esta creado en laravel 8.0, tiene dependencias npm por lo que se tienen que instalar los siguientes comandos para poder utilizarlo:
*composer install
npm install
npm run dev*

Contiene la authenticación de laravel, registro de usuarios, login y recuperación de contraseñas solo para usuarios registrados en la aplicación.

La recuperación de las contraseñas de los usuarios registrados se realiza a través del envio de un correo electrónico al correo registrado en la aplicación, para poder configurar el envio de los mensajes se tiene que configurar una cuenta google:

cuenta>acceso y seguridad> como acceder a google, permitir el acceso a aplicaciones no seguras> se debe realizar la verificación en 2 pasos y se genera la aplicación, el sistema te mostrará una contraseña y debes agregarla al archivo .env

MAIL_MAILER=smtp
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu username
MAIL_PASSWORD=tu password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu correo
MAIL_FROM_NAME="${APP_NAME}"

ó también se puede seguir este tutorial que esta bien explicado: [enlace](https://programacionymas.com/blog/como-enviar-mails-correos-desde-laravelp:// "enlace")

Para la authenticación con facebook y google se utiliza el paquete socialite que se instala con los comandos:

*composer require laravel/socialite*

Para el inicio de sesión con Facebook se debe crear api en [facebook](https://developers.facebook.com/ "facebook") para poder realizar el inicio de sesión.
En google [google](https://console.developers.google.com/ "google") se tiene que crear un proyecto, se configura y se copian las credenciales generadas al archivo .env al igual que las de facebook.

FACEBOOK_CLIENT_ID= 
FACEBOOK_CLIENT_SECRET= 
FACEBOOK_REDIRECT_URL=dominio/publicaciones/public/login/facebook/callback

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL=dominio/publicaciones/public/login/google/callback

Y por ultimo asignar un nombre a la base de datos 

DB_DATABASE=nombre de la base de datos
y ejecutar las migraciones con el comando

php artisan migrate

#### Descripción General
El sistema permite el acceso para consulta de información a usuarios no authenticados, por lo que existen rutas sin protección, estas rutas son las de consulta para preguntas, comentarios y subcommentarios, en caso de que se quiera comentar, alguna pregunta o hacer clic en los botones de "me gusta" o "no me gusta", el sistema redireccionará al usuario al login de la aplicación.
y una vez que estén logueados, el sistema permitirá su uso en un 100%, lo que permitirá realizar publicaciones, realizar comentarios y responder comentarios, además de poder dar "me gusta" o "no me gusta" en las preguntas, comentarios y respuestas a comentarios.
Además el sistema incluye un editor (richtext.js) para realizar las preguntas más descriptivas.