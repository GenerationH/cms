<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name', 'description', 'additional_params'];
    /**
     * 类型转换。
     *
     * @var array
     */
    protected $casts = [
        'additional_params' => 'array',
    ];
}
