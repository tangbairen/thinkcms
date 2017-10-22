<?php
namespace Admin\Controller;

use Think\Controller;

/*
 * 定时任务
 * */
class CrontabController extends Controller
{
    /*
     * 分配资源
     * 如果访客信息表有数据，匹配记录表，把它合并到资源表中
     * 当前时间 到 前一个小时的数据
     * */
    public function allot()
    {
        $time=time();//当前时间
        $beterTime=$time - (3600*24);//前一天的时间

        $map['status']=1;
        $map['time']=array('between',array($beterTime,$time));
        $infoData=M('VisitorInfo')
            ->field('id,guest_id,guest_name,worker_id,status')
            ->where($map)
            ->select();
        if(!empty($infoData)){
            $this->addResource($infoData);//匹配，分配
        }
    }

    public function addResource($infoData)
    {
        foreach($infoData as $key=>$val){
            D('Resource')->handler($infoData[$key],$val['guest_name'],$val['guest_id']);
        }

        return true;
    }


}