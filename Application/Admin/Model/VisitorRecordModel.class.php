<?php
namespace Admin\Model;

use Think\Model;

/*
 * 访客记录（聊天）模型
 * */
class VisitorRecordModel extends Model
{
    /*
     * 查询是否存在数据
     * @param $guest_id [访客ID]
     * @return array [一维，存在返回这条数据]
     * */
    public function existData($guest_id)
    {
        $result=$this->where("guest_id={$guest_id} and status=1")->find();
        return $result;
    }

    /*
     * 添加数据
     * */
    public function addData($data)
    {
        $sessionarr=$data['session'];
        $end=$data['end'];
        $message=$data['message'];
        $id=$this->addRecord($sessionarr,$end);
        $guest_id=$sessionarr['guest_id'];
        //查询客户信息是否存在
        $exist=D('VisitorInfo')->where("guest_id={$guest_id} and status=1")->find();

        $recordData=array_merge($sessionarr,$end);
        //数据存在
        if(!empty($exist)){
           D('VisitorInfo')->addResource($exist,$recordData,$message);
        }


    }

    public function addRecord($sessionarr,$end,$message)
    {
        $map=array_merge($sessionarr,$end);

        $map['talk_time']=strtotime($sessionarr['talk_time']);
        $map['end_time']=strtotime($end['end_time']);
        $map['message']=json_encode($message);

        $id=$this->add($map);
        return $id;
    }
}