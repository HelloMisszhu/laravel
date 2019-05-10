<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class StudentController extends Controller
{
    public $result = [
        'code'=>'',
        'message'=>'',
        'data'=>''
    ];
    function search(Request $request){
        $gdesc = $request->get('gdesc');
        $page = $request->get('page');
        $size = $request->get('size');
       /* $arr = [
            'query'=>[
                'wildcard'=>[
                    'gdesc'=>"*$gdesc*",
                ]
            ],
            'highlight'=>[
                'pre_tags'=>["<font color='red'>"],
                'post_tags'=>["</font>"],
                'fields'=>[
                    'gdesc'=>new \stdClass()
                ]
            ]
        ];*/
        $arr = [
           'query'=>[
               'wildcard'=>[
                   'gdesc'=>"*$gdesc*",
               ]
           ],
            'from'=>$page-1,
            'size'=>$size,

           'highlight'=>[
               'pre_tags'=>["<font color='red'>"],
               'post_tags'=>["</font>"],
               'fields'=>[
                   'gdesc'=>new \stdClass()
               ]
           ]
       ];
       $res =  Curl::to("http://127.0.0.1:9200/order/order/_search")->withData(json_encode($arr))->withContentType("application/json")->post();
        $this->result['code'] = 5000;
        $this->result['message'] = json_decode($res);
        print_r($this->result);
    }
}
