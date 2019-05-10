<?php

namespace App\Http\Controllers;

use App\Http\Model\Act;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;


class TestController extends Controller
{

    public $result = [
        'code'=>'',
        'message'=>'',
        'data'=>''
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $res = Curl::to("http://127.0.0.1:9200/act/act/_search")->withContentType("application/json")->get();

        if($res){
            $arr = json_decode($res,true);
            foreach($arr['hits']['hits'] as $v)
            {
                $array[] = array_merge(['id'=>$v['_id']],$v['_source']);
            }
            $this->result['code'] = 2000;
            $this->result['message'] = $array;
            return json_encode($this->result);
        }
        $this->result['code'] = 5000;
        $this->result['message'] = "get error";
        return json_encode($this->result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->post();
        $act = new Act();
        if($act::create($data))
        {
            $id = DB::getPdo()->lastInsertId();
            $res = Curl::to("http://127.0.0.1:9200/act/act/$id")->withData(json_encode($data))->withContentType("application/json")->post();
            if($res){
                $this->result['code'] = 2000;
                $this->result['message']='successfully added';
                return json_encode($this->result);
            }
        }
        $this->result['code'] = 5000;
        $this->result['message']='fail to add';
        return json_encode($this->result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->toArray();
        $id = $data['id'];
        unset($data['id']);
        $res = Curl::to("http://127.0.0.1:9200/act/act/$id")->withData(json_encode($data))->withContentType("application/json")->put();
        if($res){
            $this->result['code'] = 2000;
            $this->result['message'] = "OK";
            return json_encode($this->result);
        }
        $this->result['code'] = 5000;
        $this->result['message'] = "update error";
        return json_encode($this->result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Curl::to("http://127.0.0.1:9200/act/act/$id")->withContentType("application/json")->delete();
        if($res){
            $this->result['code'] = 2000;
            $this->result['message'] = "OK";
            return json_encode($this->result);
        }
        $this->result['code'] = 5000;
        $this->result['message'] = "delete error";
        return json_encode($this->result);
    }


    public function dition(Request $request){
        $all = $request->post();
        foreach($all as $k=>$v)
        {
            $key = $k;
            $value = $v;
        }
        $arr = [
            "query"=>[
                'wildcard'=>[
                    "$key"=>"*$value*"
                ]
            ],
            "highlight"=>[
                'pre_tags'=>["<font color='red'>"],
                'post_tags'=>["</font>"],
                'fields'=>[
                    "$key"=>new \stdClass()
                ]
            ],
        ];
        $res = Curl::to("http://127.0.0.1:9200/act/act/_search")->withData(json_encode($arr))->withContentType("application/json")->post();
        if($res){
            print_r(json_decode($res,true));
            $this->result['code'] = 2000;
            return json_encode($this->result);
        }
        $this->result['code'] = 5000;
        $this->result['message']="error";
        return json_encode($this->result);
    }
}
