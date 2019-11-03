<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $casts = [
        'imgs' => 'json',
        'date_config' => 'json',
    ];

    /**
     * 归属的奖品组
     *
     * @return void
     */
    public function group()
    {
        return $this->belongsTo('App\Models\PrizesGroup', 'prizes_group_id');
    }

    /**
     * 归属物料
     *
     * @return void
     */
    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'material_id');
    }

}
