<?php

namespace LBHurtado\Tactician;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LBHurtado\Tactician\Skeleton\SkeletonClass
 */
class TacticianFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tactician';
    }
}
