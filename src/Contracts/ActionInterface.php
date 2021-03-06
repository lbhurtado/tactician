<?php

namespace LBHurtado\Tactician\Contracts;

use Joselfonseca\LaravelTactician\CommandBusInterface;

interface ActionInterface
{
    function getBus():CommandBusInterface;

    function getCommand():string;

    function getHandler():string;

    function getMiddlewares():array;

    function getData():array;
}
