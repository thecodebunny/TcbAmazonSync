<?php

namespace Thecodebunny\AmzMwsApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Thecodebunny\AmzMwsApi\Skeleton\SkeletonClass
 */
class AmzMwsApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'amz-mws-api';
    }
}
