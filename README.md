## Como ejecutar este proyecto?
Para inicializar este proyecto solo debes ejecutar los siguientes comandos:
```
composer install
```

```
php artisan migrate
```

```
php artisan db:seed
```

```
npm install
```

```
npm run dev
```

```
php artisan serve
```

### Emails
Para realizar pruebas con Emails se recomienda configurar Mailtrap en el archivo de variables de entorno (.env).

### Usuarios para pruebas
Despues de ejecutar el comando 'php artisan db:seed' se crean dos roles y dos usuarios por defecto con los que se podran realizar pruebas.

#### Administrador
* Email: admin@app.com
* Password: 12345678

#### Usuario simple
* Email: simple@app.com
* Password: 12345678

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
