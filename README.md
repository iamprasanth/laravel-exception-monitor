# SPT Exception Monitor for Laravel

## About

The `Exception monitor` package allows you to view detailed reports of all exceptions occured in your laravel project and also notify via E-mail whenever an exception occurs.

## Installation

You can install the package via Composer:

```bash
composer require spt/exception-monitor
```

## Usage

To use the package, add the `ExceptionHandlerServiceProvider` Application Service Provider to the `providers`  array in  `app/config/app.php`:

```php
'providers' => [
    // ...
    Spt\ExceptionHandling\ExceptionHandlerServiceProvider::class
];
```

And in `app/app/Exceptions/Handler.php`, change the header statement from

```php
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
```
to
```php
use Spt\ExceptionHandling\Exceptions\EmailHandler as ExceptionHandler
```

## Configuration

The defaults are set in `config/sptexception.php`. Publish the config to copy the file to your own config:
```sh
php artisan vendor:publish --provider="Spt\ExceptionHandling\ExceptionHandlerServiceProvider"
```

This will publish config, views and translation files 

#### Recieving E-mail notifiaction for exceptions

Set the `enable_email` value to true to get email notifiaction.
use an array of to address to send multiple emails in toEmailAddress

```php
    'ErrorEmail' => [
        'enable_email' => true,
        'toEmailAddress' => [],
        'toBccEmailAddress' => [],
        'fromEmailAddress' => " ",
        'emailSubject' => " "
    ];
```

#### Customising Views

After publishing, the default view files will be copied to resources/view/spt-views
If needed you can edit the email and dashbord views to your custom needs.

## License

This SPT Exception Handling for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
