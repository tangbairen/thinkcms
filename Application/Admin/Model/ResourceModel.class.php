<?php
namespace Admin\Model;

use Think\Model;

class ResourceModel extends Model
{
    /*
     * 获取全部数据
     * */
    public function selectData()
    {
        $where='1';
        $phone=trim(I('get.phone','','htmlspecialchars'));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        if(!empty($phone)){
            $where .=" and phone={$phone}";
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

        $data=$this->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('AuthGroup')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['title'];
                }
            }
        }

        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }


}