<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = ['mime', 'storage_path', 'thumbnail_path', 'filename', 'size', 'disk'];

    public static function boot()
    {
        parent::boot();

    }
}
