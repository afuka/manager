<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models as Models;

class SelectorController extends Controller
{
    public function prizeGroups()
    {
        // 搜索出当前可用的
        $groups = Models\PrizesGroup::where('status', '1')->get();
 
        $result = [];
        foreach($groups as $item) {
            $result[] = [
                'id' => $item->id,
                'text' => $item->title,
            ];
        }
        
        return $result;
    }
}
