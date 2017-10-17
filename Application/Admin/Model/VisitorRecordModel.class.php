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


    /*
     * 获取全部数据
     * */
    public function getData($where=1)
    {
        $phone=trim(I('get.phone',''));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $allocation=I('get.allocation','');

        if(!empty($phone)){
            $where .=" and phone={$phone}";
        }

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
        }

        if(!empty($s_group)){
            $where .=" and group_id={$s_group}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and addtime >={$start_time}";
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where .=" and addtime <={$end_time}";
        }

        $count      = $this->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出

        $data=$this->where($where)->order('end_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                $val['talk_time']=date('Y-m-d H:i:s',$val['talk_time']);
                $val['end_time']=date('Y-m-d H:i:s',$val['end_time']);
            }
        }

        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

}