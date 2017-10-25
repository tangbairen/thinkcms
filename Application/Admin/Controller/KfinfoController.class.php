<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;


class KfinfoController extends Controller
{

    public function index()
    {
        try{
            if(!IS_POST) throw new Exception('非法请求');
            $ip = get_client_ip();
            if($ip != '122.227.58.170')throw new Exception('非法情况');

            $cmd=I('post.cmd','');
            if($cmd == 'talk_info'){//整体推送
                $content=I('post.content','');
                if(!empty($content)){
                    $content=urldecode($content);
                    $data=json_decode($content,true);
                    D('VisitorRecord')->kfAddRecord($data);
                }

            }else{
                //访客信息推送
                $customer=I('post.content','');
                if(!empty($customer)){
                    $customer=urldecode($customer);
                    $customer=json_decode($customer,true);
                    $cmd=isset($customer['cmd']) ? $customer['cmd'] : '';
                    if($cmd == 'customer'){
                        D('VisitorInfo')->addInfo($customer);
                    }
                }

            }

            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }catch(Exception $e){
            $message=$e->getMessage();
            file_put_contents('./Uploads/log/message.txt',$message.date('Y-m-d H:i:s',time()));
            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }


    }


}