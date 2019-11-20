<?php

namespace Tomsq\ImageManager\Models\Images;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'created_by',
        'file_name',
        'file_extension',
        'file_size',
        'model_id',
        'model_type',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
