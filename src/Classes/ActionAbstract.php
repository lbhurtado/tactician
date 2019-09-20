<?php

namespace LBHurtado\Tactician\Classes;

use Illuminate\Http\Request;
use Opis\Events\EventDispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LBHurtado\Tactician\Contracts\ActionInterface;
use Joselfonseca\LaravelTactician\CommandBusInterface;

abstract class ActionAbstract implements ActionInterface
{
    use DispatchesJobs;

    /** @var CommandBusInterface  */
    protected $bus;

    /** @var Request  */
    protected $request;

    /** @var string */
    protected $command;

    /** @var string */
    protected $handler;

    /** @var array */
    protected $middlewares;

    /** @var EventDispatcher  */
    protected $dispatcher;

    /** @var array */
    protected $arguments;

    public function __construct(CommandBusInterface $bus, EventDispatcher $dispatcher, Request $request)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->dispatcher = $dispatcher;
    }

    public function __invoke(...$arguments)
    {
        $this->arguments = $arguments;

        if (method_exists($this, 'setup'))
            $this->setup();

        $this->getBus()->addHandler(
            $this->getCommand(),
            $this->getHandler()
        );

        return $this->dispatch();
    }

    public function getBus(): CommandBusInterface
    {
        return $this->bus;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getMiddlewares():array
    {
        return $this->middlewares;
    }

    public function getData():array
    {
        return $this->request->only($this->getFields());
    }

    public function getDispatcher(): EventDispatcher
    {
        return $this->dispatcher;
    }

    public function getFields(): array
    {
        return array_keys(config('tactician.fields', []));
    }

    /**
     * @return mixed
     */
    protected function dispatch(): mixed
    {
        return $this->getBus()->dispatch(
            $this->getCommand(),
            $this->getData(),
            $this->getMiddlewares()
        );
    }
}
