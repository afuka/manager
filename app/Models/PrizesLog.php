<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrizesLog extends Model
{
    protected $casts = [
        'leaving_capital' => 'json',
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
     * 归属奖品
     *
     * @return void
     */
    public function prize()
    {
        return $this->belongsTo('App\Models\Prize', 'prize_id');
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

    /**
     * 归属人
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
