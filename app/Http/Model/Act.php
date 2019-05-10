<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Act extends Model
{
   static function create($data){
        return DB::insert("insert into act(title,content) value(?,?)",[$data['title'],$data['content']]);
    }
    static function get(){
       return DB::select("select * from act");
    }
}
