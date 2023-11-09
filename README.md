# Descripción
Proyecto de la prueba de acceso de la parte Backend a la Hackathon de Jump2Digital que consiste en realizar una API que permite a los usuarios consultar, adquirir, modificar y eliminar skins de un videojuego. Para ello, se ha implementado un sistema de login y un sistema de roles para el acceso de rutas mediante un patrón MVC con capa de servicio para funciones externas. Además, como parte del requisito de la prueba, incluye una función que transfiere los datos de un JSON a la base de datos SQL (SkinJSONSeeder).

# Uso del deploy
Para hacer uso del deploy, ir a la siguiente API: https://j2d-albertlnz.onrender.com/api <br>
Puede hacer uso del usuario administrador, que le permite acceder a todas las rutas del proyecto: <br>
    **email:** ```
	admin@example.com
	```
 <br>
    **password:** ```
	admin
	```
<br><br>
También le facilito los usuarios (email / contraseña) de role cliente implementados en la base de datos:
 - hattie.beatty@example.org / password
 - alek43@example.com / password
 - vfisher@example.org / password
 - lindsay.hessel@example.com / password
 - brekke.shayne@example.org / password
 - sawayn.benjamin@example.com / password
 - zborer@example.net / password
 - kovacek.madisyn@example.org / password
 - cordelia78@example.org / password

## Rutas de logeo
LOGIN (POST): https://j2d-albertlnz.onrender.com/api/login <br>
REGISTER (POST): https://j2d-albertlnz.onrender.com/api/register <br>
*If you try to access these routes through your browser, you will see a 405 error because they are POST routes and not GET! You can prove it in Postman!!*

## Rutas requiridas para la prueba
1. SKINS DISPONIBLES PARA COMPRAR (GET): https://j2d-albertlnz.onrender.com/api/skins/available
2. USUARIO COMPRAR SKIN (POST): https://j2d-albertlnz.onrender.com/api/skins/buy/{skin_id} ***(login necesario)***
3. SKINS DEL USUARIO (GET): https://j2d-albertlnz.onrender.com/api/skins/myskins ***(login necesario)***
4. CAMBIAR EL COLOR DE UNA SKIN DEL USUARIO (PUT): https://j2d-albertlnz.onrender.com/api/skins/color ***(login necesario)***
5. ELIMINAR UNA SKIN DEL USUARIO (DELETE): https://j2d-albertlnz.onrender.com/api/skins/delete/{skin_id} ***(login necesario)***
6. DEVUELVE UNA DETERMINADA SKIN (GET): https://j2d-albertlnz.onrender.com/api/skin/getskin/{skin_id} ***(login necesario)***

## Rutas extras (SKIN CRUD con diferentes niveles de seguridad a través de roles {Spatie})
7. MOSTRAR TODAS LAS SKINS (GET): https://j2d-albertlnz.onrender.com/api/skins ***(login de admin necesario)***
8. CREAR UNA SKIN (POST): https://j2d-albertlnz.onrender.com/api/skins ***(login de admin necesario)***
9. EDITAR UNA SKIN (PUT): https://j2d-albertlnz.onrender.com/api/skins/{$skin_id} ***(login de admin necesario)***
10. ELIMINAR UNA SKIN (DELETE): https://j2d-albertlnz.onrender.com/api/skins/{$skin_id}

## Resumen de las rutas:
![image](https://github.com/AlbertLnz/Jump2Digital-Back-AlbertLnz/assets/120119395/3e9e62cc-8d62-4fc6-80ba-21e87072f42a)


# Instalación en local
Para hacer una instalación correcta de este proyecto de manera local, siga los siguientes pasos: <br>

0. Antes de empezar, asegurese de tener instalado PHP, Laravel y Composer
    
1. Clonese el repositorio
    ```
	git clone https://github.com/AlbertLnz/dice-API.git
	```
2. Entre dentro de la carpeta del proyecto
    ```
	cd .\Jump2Digital-Back-AlbertLnz\
	```
    
3. Edite el archivo **.env.example** y conviertalo en un archivo llamado **.env** para así poder hacer la migración a su servidor SQL (haga la configuración necesaria para vincularlo a su servidor SQL):
    ```
	DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=jump2digital_back_albertlnz
    DB_USERNAME=root
    DB_PASSWORD=
	```

4. Haga la instalación de las dependencias con el siguiente comando en la terminal (asegurése de estar dentro del proyecto [paso nº 2])
    ```
	composer install
	```
   
5. Ahora ejecute el comando el siguiente comando personalizado para: <br>
    · Realizar la migración <br>
    · Realizar la subida de datos a través del archivo **skins.json** a la base de datos <br>
    · Instalar las Laravel Passport para que las rutas que necesitan autentificación funcionen correctamente <br>
    · Generar la key del proyecto <br>
    ```
	php artisan start-project
    ```

6. Y ahora ya puede inicializar el proyecto con el comando:
    ```
	php artisan serve
	```

    *Para ver el ruteo del proyecto, puede hacer uso del comando: **php artisan route:list***


# Proyecto realizado con
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

