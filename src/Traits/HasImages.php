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
        $interventionImage = ImageManager::createImage($file, $options);
        $storedData = ImageManager::saveImage($interventionImage, $options);

        return $this->images()->create([
            'file_name' => $storedData['file_name'],
            'file_extension' => $storedData['file_extension'],
            'file_size' => $storedData['file_size'],
            'created_by' => array_key_exists('created_by', $data) ? $data['created_by'] : null,
            'short_description' => array_key_exists('short_description', $data) ? $data['short_description'] : null,
            'description' => array_key_exists('description', $data) ? $data['description'] : null,
            'name' => array_key_exists('short_description', $data) ? $data['name'] : null
        ]);
    }

    public function createImages()
    { }
}
