<?php

namespace Tomsq\ImageManager;

class FilePath
{
    protected $extension;
    protected $dirName;
    protected $imageType;

    function __construct($dirName, $imageType, $extension)
    {
        $this->dirName = $dirName;
        $this->imageType = $imageType;
        $this->extension = $extension;
    }

    public function getFullPath()
    {
        return $this->dirName . '/' . $this->imageType . '.' . $this->extension;
    }

    public function getFileName()
    {
        return $this->dirName;
    }

    public function getDirName()
    {
        return $this->dirName;
    }

    public function getImageType()
    {
        return $this->imageType;
    }

    public function getExtension()
    {
        return $this->extension;
    }
}
