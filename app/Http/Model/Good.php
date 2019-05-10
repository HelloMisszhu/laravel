<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Good extends Model
{
    function add($name,$gdesc,$price){
        return DB::insert("insert into good(gname,gdesc,price) value('$name','$gdesc',$price)");
    }
    function upda($name,$gdesc,$price,$id){
        return DB::update("update good set gname='$name',gdesc='$gdesc',price=$price where id=$id");
    }
    function searchr($name){
        return DB::select("select id,gname,gdesc,price from good where gname like '%$name%'");
    }
    function del($id){
        return DB::delete("delete from good where id=$id");
    }
}
