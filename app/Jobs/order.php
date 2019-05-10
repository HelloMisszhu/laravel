<?php

namespace App\Jobs;

use App\Http\Model\Goods;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;

class order implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $gid;
    private $oid;
    public function __construct($gid,$oid)
    {
        $this->gid = $gid;
        $this->oid = $oid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uid = Redis::get('id');

        $goods = Goods::find($this->gid);
        foreach($goods as $k){
            $arr = $k;
        }
        try{
            if(DB::update('update users set balance = balance - '.$arr->price." where id = $uid"))
            echo "已支付金额".$arr->price;
            echo "\n";
            if(DB::update("update goods set stock_num = stock_num-1 where id = ".$arr->id))
            echo "库存减一";
            echo "\n";
            if(DB::update("update orders set status = 1 where id = ".$this->oid))
            echo "支付状态更改为已支付";
            echo "\n";
            Mail::raw('你好，我是卖家，你的订单已收到，正在准备发货',function($message){
                $to='928259843@qq.com';
                if($message->to($to)->subject('订单信息')){
                    $username = Redis::get('username');
                    echo $username."的邮件已发送";
                    echo "\n";
                }
            });

        }catch (Exception $exception){

        }
    }
}
