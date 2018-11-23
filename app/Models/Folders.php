<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'mime_type', 'size',
    ];
}
