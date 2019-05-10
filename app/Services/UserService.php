<?php
namespace App\Services;

use App\Http\Model\Goods;
use App\Http\Model\Orders;
use App\Http\Model\Users;
use App\Jobs\order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Ixudra\Curl\Facades\Curl;

class UserService{

    private $users;
    private $orders;
    private $goods;
    function __construct(Users $users,Orders $orders,Goods $goods)
    {
        $this->users = $users;
        $this->orders = $orders;
        $this->goods = $goods;
    }
    function add($all){
        return $this->goods->add($all['gname'],$all['gdesc'],$all['stock_num'],$all['price']);

    }
    function login($name,$pwd){
       $res = $this->users::where('username',$name)->where('userpass',$pwd)->first();
       if($res){
           Redis::set('id',$res->id);
           Redis::set('username',$res->username);
           return true;
       }
      return false;
    }
    function Order($goods){
        foreach($goods as $k){
            $arr = $k;
        }
        if($arr->stock_num >0){
            $uid = Redis::get('id');
            $price = $arr->price;
            $gid = $arr->id;
            $order_code = rand(1000,10000)."QAZ";
            if($this->orders->setOrders($uid,$price,$gid,$order_code)){
                $oid = DB::getPdo()->lastInsertId();
                $arr = [
                  'oid'=>$oid,
                  'gid'=>$gid
                ];
                return $arr;
            }
        }
    }
}