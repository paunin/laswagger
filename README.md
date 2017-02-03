# paunin/laswagger

This package is a wrapper for [Swagger-php](https://github.com/zircote/swagger-php) and makes it easy to integrate with Lumen/Larvarel.

## Usage

### Installation
Via Composer

Add information about new package in your `composer.json`
```json
    "require": {
    ...
        "paunin/laswagger": ">=1.0.0"
    ...
    }
```

After the composer install finishes, register the service provider:

 * Lumen Application:

```php
$app->register(Laswagger\Providers\LumeSwaggerServiceProvider::class);
```

 * Laravel Application: not supports yet.

Now you can wo with laswagger:
* Run `php artisan swagger:generate file_name [base_host]`: to generate swagger api docs.

* Go to `/swagger/api-docs` (default routing config) to see swagger api docs in JSON format

### Default configuration
```php
<?php
return [
    'routes' => [
        'prefix' => 'swagger',
        'cors'   => false
    ],
    'api' => [
        'directories' => [base_path('app')],
        'excludes' => [],
        'host' => null
    ]
];
```

### Customize configuration
In order to change default config you can copy the configuration template in `config/laswagger.php` to your application's `config` directory and modify according to your needs.
For more information see the [Configuration Files](http://lumen.laravel.com/docs/configuration#configuration-files) section in the Lumen documentation.

## Tests
```sh
./vendor/phpunit/phpunit/phpunit
```
See test result at `./build`
