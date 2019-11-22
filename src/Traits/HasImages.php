<?php

namespace Tomsq\ImageManager\Traits;

use Tomsq\ImageManager\Models\Images\Image;
use Tomsq\ImageManager\ImageManager;
trait HasImages
{
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    /**
     *  @param string $file - encoded file
     *  @param array $data - additional image information
     *  @param array options
     *
     *  @return Tomsq\ImageManager\Models\Images\Image
     */
    public function createImage($file, array $data, array $options = [])
    {
        ImageManager::handleImage($file, $this, $data, $options);
    }
}
