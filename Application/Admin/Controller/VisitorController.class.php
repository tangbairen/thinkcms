<?php
namespace Admin\Controller;

//use Think\Controller;
/*
 * 访客处理类（53客服）
 * */
use Think\Controller;
use Think\Crypt\Driver\Think;

class VisitorController extends Controller
{
    //接受数据
    public function index()
    {

        /*$strData=urldecode($content);
        $len=strripos($strData,'}');
        $result=substr($strData, 0,$len+1);

        $data=json_decode($result,true);
        if(count($data) == count($data,1)){//一维（访客信息）

            D('VisitorInfo')->addData($data);


        }else{//二维（访客聊天记录）

            D('VisitorRecord')->addData($data);
        }*/


        //返回数据给接口方
        $data = array('cmd' => 'OK', 'token' => 'TOKEN');
        echo  json_encode($data);
    }
}