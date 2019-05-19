# lbhurtado/tactician

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lbhurtado/tactician.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/tactician)
[![Build Status](https://img.shields.io/travis/lbhurtado/tactician/master.svg?style=flat-square)](https://travis-ci.org/lbhurtado/tactician)
[![Quality Score](https://img.shields.io/scrutinizer/g/lbhurtado/tactician.svg?style=flat-square)](https://scrutinizer-ci.com/g/lbhurtado/tactician)
[![Total Downloads](https://img.shields.io/packagist/dt/lbhurtado/tactician.svg?style=flat-square)](https://packagist.org/packages/lbhurtado/tactician)

This is just an extension of joselfonseca/laravel-tactician package implementing the ActionAbstract class.

## Installation

You can install the package via composer:

```bash
composer require lbhurtado/tactician
```

## Usage

``` php
use LBHurtado\Tactician\Classes\ActionAbstract;
use LBHurtado\Tactician\Contracts\ActionInterface;

class CreateSMSAction extends ActionAbstract implements ActionInterface
{
    protected $fields = ['from', 'to', 'message'];

    protected $command = CreateSMSCommand::class;

    protected $handler = CreateSMSHandler::class;

    protected $middlewares = [
        CreateSMSValidator::class,
        CreateSMSResponder::class,
    ];

    public function setup()
    {
        // TODO: Implement setup() method.
    }
}
```

``` php
use LBHurtado\Tactician\Contracts\CommandInterface;

class CreateSMSCommand implements CommandInterface
{
    public $from;

    public $to;

    public $message;

    public function __construct($from, $to, $message)
    {
        $this->from = $from;
        $this->to = $to;
        $this->message = $message;
    }

    public function getProperties():array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->message,
        ];
    }
}
```

``` php
use LBHurtado\Tactician\Contracts\CommandInterface;
use LBHurtado\Tactician\Contracts\HandlerInterface;

class CreateSMSHandler implements HandlerInterface
{
    protected $smss;

    public function __construct(SMSRepository $smss)
    {
        $this->smss = $smss;
    }

    public function handle(CommandInterface $command)
    {
        $this->smss->create([
            'from' => $command->from,
            'to' => $command->to,
            'message' => $command->message,
        ]);
    }
}
```

``` php
use League\Tactician\Middleware;

class CreateSMSResponder implements Middleware
{
    public function execute($command, callable $next)
    {
        $next($command);

        return (new CreateSMSResource($command))
            ->response()
            ->setStatusCode(200)
            ;
    }
}
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email lester@hurtado.ph instead of using the issue tracker.

## Credits

- [Lester Hurtado](https://github.com/lbhurtado)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
