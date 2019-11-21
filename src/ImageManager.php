<?php

namespace Tomsq\ImageManager;

use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;
use Tomsq\ImageManager\Models\Images\Image;

class ImageManager
{
    public static function handleImage($file, $options = [])
    {
        // dd(config('image-manager.images'));
        $imageTypesConfigs = config('image-manager.images');
        $pathBase = uniqid() . '/';
        foreach($imageTypesConfigs as $imageTypeName => $config)
        {
            $img = self::makeImage($file, $config);
            $filePath = self::makeFilePath($pathBase, $imageTypeName, $config);
            self::saveImage($filePath, $img);
            self::createModel($filePath, $imageTypeName, $config);
        }
    }

    private static function makeImage($file, $config)
    {
        return InterventionImage::make($file)->resize(
            $config['width'],
            $config['height'],
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->stream(
                $config['file_extension'],
                $config['compression']
            );
    }

    private static function createModel($filePath, $imageTypeName, $fileSize, $config)
    {
        Image::create([
            'file_name' => $filePath,
            'file_extension' => $config['file_extension'],
            'type' => $imageTypeName,
            // 'created_by' => array_key_exists('created_by', $data) ? $data['created_by'] : null,
            // 'short_description' => array_key_exists('short_description', $data) ? $data['short_description'] : null,
            // 'description' => array_key_exists('description', $data) ? $data['description'] : null,
            // 'name' => array_key_exists('short_description', $data) ? $data['name'] : null
        ]);
    }

    private static function saveImage($imagePath, $image)
    {
        Storage::disk('public')->put($imagePath, $image);
    }

    private static function makeFilePath($pathBase, $typeName, $config)
    {
        return $pathBase . $typeName . '.' . $config['file_extension'];
    }
}
