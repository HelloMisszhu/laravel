<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Orders extends Model
{
    function setOrders($uid,$price,$gid,$order_code){
        return DB::insert("insert into orders(order_code,user_id,goods_id,price) value('$order_code',$uid,$gid,$price)");
    }
}
