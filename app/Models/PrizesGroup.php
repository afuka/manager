<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrizesGroup extends Model
{
    /**
     * 获取奖品组的奖品
     *
     * @return void
     */
    public function prizes()
    {
        return $this->hasMany('App\Models\Prize');
    }

}
