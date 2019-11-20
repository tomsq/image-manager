<?php

namespace Tomsq\ImageManager\Traits;

use Tomsq\ImageManager\Models\Images\Image;

trait HasImages
{
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function createImage()
    {
        return $this->images()->create([
            'file_name' => 'test',
            'file_extension' => 'png',
            'file_size' => 1024
        ]);
    }

    public function createImages()
    { }
}
