<?php

namespace Tomsq\ImageManager;

use Illuminate\Support\Facades\Facade;

class ImageManagerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ImageManager';
    }
}
