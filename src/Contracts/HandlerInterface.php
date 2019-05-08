<?php

namespace LBHurtado\Tactician\Contracts;

interface HandlerInterface
{
    function handle(CommandInterface $command);
}
