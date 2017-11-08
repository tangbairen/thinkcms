<?php
namespace Admin\Model;

use Think\Exception;
use Think\Model;

/*
 * 部门模型类
 * */
class RoleDepartmentModel extends Model
{
    /*
     * 删除部门
     * */
    public function delData()
    {
        $id=I('get.id') > 0 ? I('get.id') : 0;

        //查询是否有用户
        $user=M('Users')->where("department_id={$id}")->select();
        if(!empty($user)) throw new Exception('该部门存在用户，请先删除用户');

        //查询是否有下级部门
        $data=$this->where("parent_id={$id}")->select();
        if(!empty($data)) throw new Exception('该部门存在子部门，请先删除子部门');

        $res=$this->where("id={$id}")->delete();
        if(empty($res))throw new Exception('删除失败');
        return true;
    }

    /*
     * 修改部门
     * */
    public function editData()
    {
        $edit_name=trim(I('post.edit_name'));
        $edit_id=I('post.edit_id')+0;
        $edit_description=trim(I('post.edit_description'));
        $check2=I('post.edit_check2');
        if(empty($edit_name)) throw new Exception('部门名称不能为空');

        if(!empty($check2)){
            $map['area_id']=implode($check2,',');
        }

        $map['name']=$edit_name;
        $map['description']=$edit_description;

        //判断是否存在
        $arr['name']=$edit_name;
        $arr['id']=array('NEQ',$edit_id);
        $count=$this->where($arr)->find();
        if(!empty($count)) throw new Exception('该部门名称已经存在');

        $res=$this->where("id={$edit_id}")->save($map);

        if(empty($res)) throw new Exception('修改失败');

    }

    /*
     * 获取该公司账号下的部门信息   部门id
     * */
    public function getDepartData($department_id)
    {
        $depart=$this->where("parent_id={$department_id}")->select();

        if(!empty($depart)){

            foreach($depart as $key=>&$val){
                //今天目标数
                $total=M('Total')->where("group_id={$val['id']}")->find();
                $val['total']=0;
                if(!empty($total)){
                    $val['total']=$total['total'];
                }
                // 今日开始时间戳
                $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
                // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
                $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

                $feedback=M('Resource')->field("count(*) as total,count( case status when  0 then status end ) as num1,count( case status when 1 then status end ) as num2,
        count( case status when 2 then status end ) as num3")
                    ->where("group_id={$val['id']} and  addtime between  {$startDay} and {$endDay}")
                    ->find();

                //月累计
                $firstday =mktime(0, 0, 0, date('m'), 1);
                $lastday = mktime(0, 0, 0,date('m')+1,1)-1;

                $month=M('Resource')->field("count(*) as total,count( case status when  0 then status end ) as num1,count( case status when 1 then status end ) as num2,
        count( case status when 2 then status end ) as num3")
                    ->where("group_id={$val['id']} and  addtime between  {$firstday} and {$lastday}")
                    ->find();
                $val['totalmonth']=isset($month['total']) ? $month['total'] : 0;//月累计
                $num2=isset($month['num2']) ? $month['num2'] : 0;
                $num3=isset($month['num3']) ? $month['num3'] : 0;
                $val['m_yifk']=$num2+$num3;//已反馈
                $val['m_weifk']=isset($month['num1']) ? $month['num1'] : 0;//未反馈
                $val['m_youxiao']=$num2;//未反馈


                $num1=isset($feedback['num1']) ? $feedback['num1'] : 0;//未反馈
                $num2=isset($feedback['num2']) ? $feedback['num2'] : 0;//可跟
                $num3=isset($feedback['num3']) ? $feedback['num3'] : 0;//不可跟
                $today=isset($feedback['total']) ? $feedback['total'] : 0;//今日资源
                $val['yifenp']=$num2+$num3;//已分配
                $val['meifenp']=$num1;
                $val['youxiao']=$num2;
                $val['totalnum']=$today;
                $val['rate']=round($num2 / $today,2);

            }


            return $depart;
        }

        return false;

    }



}