<?php

namespace Tomsq\ImageManager;

use Intervention\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;


class ImageManager
{
    public static function createImage($file, $options = [])
    {
        return InterventionImage::make($file)->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->stream(
            'jpg',
            array_key_exists("compresion", $options) ? $options["compresion"] : 90
        );
    }

    public static function saveImage(InterventionImage $image)
    {
        dd($image);
    }
}
