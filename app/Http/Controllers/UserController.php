<?php

namespace App\Http\Controllers;

use App\Http\Model\Goods;
use App\Jobs\order;
use app\models\User;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Ixudra\Curl\Facades\Curl;

class UserController extends Controller
{

    private $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function add(Request $request){
        $this->validate($request,[
            'gname'=>'required',
            'gdesc'=>'required',
            'stock_num'=>'required',
            'price'=>'required',
            ]);
        $all = $request->toArray();
        if($this->userService->add($all)){
            $id = DB::getPdo()->lastInsertId();
            if(Curl::to("http://127.0.0.1:9200/order/order/$id")->withData(json_encode($all))->withContentType("application/json")->post()){
                return json_encode(['code'=>2000,'message'=>'商品添加成功']);
            }
        }
        return json_encode(['code'=>5000,'message'=>'商品添加失败']);
    }



    public function login(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'pwd'=>'required'
        ]);
        $name = $request->post('name');
        $pwd = $request->post('pwd');
        $res = $this->userService->login($name,$pwd);
        if($res){
            echo "登陆成功";
        }else
        {
            echo "登录失败";
        }
    }


    public function loginOut(){
        if(Redis::del('id')){
            echo "已退出登录状态";
        }else{
            echo "退出登录失败";
        }
    }

    public function order(Request $request){
        $this->validate($request,['id'=>'required']);
        $gid = $request->post('id');
        $goods = Goods::find($gid);
        $res = $this->userService->Order($goods);
        $this->dispatch(new order($res['gid'],$res['oid']));
        return response()->json(['code'=>2000,'message'=>'success']);
    }
}
