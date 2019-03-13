<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = ['filename', 'original_filename', 'mime', 'size', 'disk'];

    public static function boot()
    {
        parent::boot();

    }
}
