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

    protected $bus;

    protected $request;

    protected $fields;

    protected $command;

    protected $handler;

    protected $middlewares;

    protected $dispatcher;

    public function __construct(CommandBusInterface $bus, EventDispatcher $dispatcher, Request $request)
    {
        $this->bus = $bus;
        $this->request = $request;
        $this->dispatcher = $dispatcher;

        \Log::info($request);
    }

    public function __invoke()
    {
        $this->setup();

        $this->getBus()->addHandler(
            $this->getCommand(),
            $this->getHandler()
        );

        return $this->getBus()->dispatch(
            $this->getCommand(),
            $this->getData(),
            $this->getMiddlewares()
        );
    }

    public function getBus():CommandBusInterface
    {
        return $this->bus;
    }

    public function getCommand():string
    {
        return $this->command;
    }

    public function getHandler():string
    {
        return $this->handler;
    }

    public function getMiddlewares():array
    {
        return $this->middlewares;
    }

    public function getData():array
    {
        return $this->request->only($this->fields);
    }

    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    abstract public function setup();
}
