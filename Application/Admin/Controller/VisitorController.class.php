<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Controller;

/*
 * 访客处理类（53客服）
 * */

class VisitorController extends AdminBaseController
{
    //接受数据
    public function index()
    {
        $content=$_POST;
        /*$strData=urldecode($content);
        $len=strripos($strData,'}');
        $result=substr($strData, 0,$len+1);

        $data=json_decode($result,true);
        if(count($data) == count($data,1)){//一维（访客信息）

            D('VisitorInfo')->addData($data);

        }else{//二维（访客聊天记录）

            D('VisitorRecord')->addData($data);
        }*/
        /*$time=date('Y-m-d H:i:s',time());
        file_put_contents("./Uploads/log/".$time.'.txt',$content);*/

        //返回数据给接口方
        $data = array('cmd' => 'OK', 'token' => 'TOKEN');
       echo  json_encode($data);
    }

    /*
     * 53 数据源
     * */
    public function data_source()
    {

        $data=D('VisitorRecord')->getData();

        $this->assign($data);
        $this->display();
    }

}