<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    /**
     * 归属的奖品组
     *
     * @return void
     */
    public function group()
    {
        return $this->belongsTo('App\Models\PrizesGroup');
    }

    /**
     * 归属物料
     *
     * @return void
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
