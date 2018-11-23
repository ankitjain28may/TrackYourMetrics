<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'folder_id', 'path', 'mime_type', 'size',
    ];
}
