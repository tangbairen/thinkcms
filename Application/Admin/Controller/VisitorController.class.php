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
        $get=I('get.');

        $data=D('VisitorRecord')->getData();

        $this->assign($data);
        $this->assign('get',$get);
        $this->display();
    }

    /*
     * 访客信息
     * */
    public function userinfo()
    {
        $get=I('get.');

        $data=D('VisitorInfo')->getData();

        $this->assign($data);
        $this->assign('get',$get);
        $this->display();
    }

    /*
     * 数据源导出
     * */
    public function recordExport()
    {
        $where=1;
        $guest_id=trim(I('get.guest_id'));
        $worker_id=trim(I('get.worker_id'));
        $status=I('get.status','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        if(!empty($guest_id)){
            $where .=" and guest_id={$guest_id}";
        }

        if(!empty($worker_id)){
            $where .=" and worker_id='{$worker_id}'";
        }

        if(!empty($status)){
            $where .=" and status={$status}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and talk_time >={$start_time}";
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where .=" and talk_time <={$end_time}";
        }

        if(empty($start_time) &&empty($end_time)){
            // 今日开始时间戳
            $startDay=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
            // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
            $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $where .=" talk_time between {$startDay} and {$endDay}";
        }


        $field=array('id','guest_id','talk_id','guest_ip','guest_area','talk_page','se','kw','worker_id','talk_time','end_time','status');
        $data=D('VisitorRecord')->exportData($field);
        $header=['ID','访客ID','会话ID','访客IP','地址','咨询地址','搜索引擎','关键字','客服工号','对话时间','结束时间','处理状态'];
        export($header,$data);
    }

    /*
     * 访客信息导出
     * */
    public function infoExport()
    {
        $where=1;
        $guest_id=trim(I('get.guest_id'));
        $worker_id=trim(I('get.worker_id'));
        $status=I('get.status','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $guest_name=I('get.guest_name','',false);

        if(!empty($guest_id)){
            $where .=" and guest_id={$guest_id}";
        }

        if(!empty($worker_id)){
            $where .=" and worker_id='{$worker_id}'";
        }

        if(!empty($status)){
            $where .=" and status={$status}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and time >={$start_time}";
        }

        if(!empty($end_time)){
            $where .=" and time <={$end_time}";
        }

        if(!empty($guest_name)){
            $guest_name=trim($guest_name);
            $guest_name=str_replace('A','#',$guest_name);
            $guest_name=str_replace('B','+',$guest_name);
            $where .= " and guest_name like '%{$guest_name}%'";
        }

        $field=array('id','guest_id','guest_name','mobile','worker_id','time','status');
        $data=D('VisitorInfo')->exportData($field,$where);
        $header=['ID','访客ID','	访客名称','手机号','客服工号','添加时间','状态'];
        export($header,$data);
    }


}