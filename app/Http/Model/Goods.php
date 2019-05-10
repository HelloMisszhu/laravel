<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Goods extends Model{
    static function find($gid){
        return DB::select("select id,gname,gdesc,stock_num,price from goods where id=$gid");
    }
    static function add($gname,$gdesc,$stock_num,$price){
        return DB::insert("insert into goods(gname,gdesc,stock_num,price) value('$gname','$gdesc',$stock_num,$price)");
    }
}