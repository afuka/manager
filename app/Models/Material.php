<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $casts = [
        'imgs' => 'json',
        'ext_info' => 'json',
    ];
}
