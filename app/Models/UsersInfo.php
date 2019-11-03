<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    protected $casts = [
        'ext_info' => 'json',
    ];
}
