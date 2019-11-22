<?php

namespace Tomsq\ImageManager;

use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;

class ImageManager
{
    public static function handleImage($file, $model, $imageData, $options = [])
    {
        $dirName = uniqid();
        $mainImageModel = self::handleMainImage($file, $dirName, $model, $imageData, $options);
        self::handleThumbImage($file, $dirName, $model, $imageData, $mainImageModel->id, $options);
    }

    private static function handleMainImage($file, $dirName, $model, $imageData, $options = [])
    {
        $img = self::makeMainImage($file, $options);
        $path = new FilePath($dirName, 'main', 'jpg');
        self::saveImage($path->getFullPath(), $img);
        return self::createModel($model, $imageData, $path);
    }

    private static function handleThumbImage($file, $dirName, $model, $imageData, $mainImageModelId, $options = [])
    {
        $img = self::makeThumbImage($file, $options);
        $path = new FilePath($dirName, 'thumb', 'jpg');
        self::saveImage($path->getFullPath(), $img);
        self::createModel($model, $imageData, $path, $mainImageModelId);
    }

    private static function makeMainImage($file, $options)
    {
        return InterventionImage::make($file)->resize(
            1080,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        )->stream(
            'jpg',
            90
        );
    }

    private static function makeThumbImage($file, $options)
    {
        return InterventionImage::make($file)->resize(
            400,
            null,
            function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        )->stream(
            'jpg',
            85
        );
    }

    private static function createModel($model, $imageData, FilePath $path, $parentId = null)
    {
        return $model->images()->create([
            'name' => array_key_exists('short_description', $imageData) ? $imageData['name'] : null,
            'description' => array_key_exists('description', $imageData) ? $imageData['description'] : null,
            'short_description' => array_key_exists('short_description', $imageData) ? $imageData['short_description'] : null,
            'created_by' => array_key_exists('created_by', $imageData) ? $imageData['created_by'] : null,
            'file_name' => $path->getFileName(),
            'file_extension' => $path->getExtension(),
            'file_size' => Storage::size('public/' . $path->getFullPath()),
            'parent_id' => $parentId,
            'type' => $path->getImageType()
        ]);
    }

    private static function saveImage($imagePath, $image)
    {
        Storage::disk('public')->put($imagePath, $image);
    }
}
