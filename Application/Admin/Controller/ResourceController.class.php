<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Exception;

/*
 * 数据总来源
 * */
class ResourceController extends AdminBaseController
{
    /*
     * 数据总列表
     * */
    public function index()
    {
        $data=D('Resource')->selectData();
        //所有组
        $group=M('AuthGroup')->select();
        $phone=I('get.phone');
        $s_group=I('get.group');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');


        $this->assign(array('phone'=>$phone,'s_group'=>$s_group,'start_time'=>$start_time,'end_time'=>$end_time));
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集
        $this->display();
    }

    /*
     * 数据列表（客服）
     * */
    public function customer()
    {
        $data=D('Resource')->selectData();
        //所有组
        $group=M('AuthGroup')->select();
        $phone=I('get.phone');
        $s_group=I('get.group');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');


        $this->assign(array('phone'=>$phone,'s_group'=>$s_group,'start_time'=>$start_time,'end_time'=>$end_time));
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集
        $this->display();
    }

    public function delete()
    {
        try{
            $id=I('get.id');
            if(empty($id)) throw new Exception('数据不存在');

            $count=M('Resource')->where("id={$id}")->find();
            if(!$count) throw new Exception('数据不存在');

            $res=M('Resource')->where("id={$id}")->delete();
            if(!$res) throw new Exception('删除失败');

            $this->success('删除成功');

        }catch(Exception $e){

            $message=$e->getMessage();
            $this->error($message);
        }

    }

    /*
     * 修改数据（客服的数据）
     * */
    public function modify()
    {
        if(IS_POST){

            $res=D('Resource')->edit();
            if($res){
                $this->success('修改成功',U('Admin/Resource/customer'));
            }else{
                $this->error('修改失败');
            }

        }else{

            try{
                $id=I('get.number')+0;
                if(empty($id)) throw new Exception('数据不存在');

                $data=M('Resource')->where("id={$id}")->find();
                if(empty($data)) throw new Exception('数据不存在');

                $group_name='';
                if($data['group_id'] > 0){
                    $group=M('AuthGroup')->field('title')->where("id={$data['group_id']}")->find();
                    $group_name=$group;
                }

                $brand_name='';
                if($data['brand_id'] > 0){

                    $brand=M('Brands')->field('name')->where("id={$data['brand_id']}")->find();
                    $brand_name=$brand['name'];
                }

                //用户组
                $autGroup=M('AuthGroup')->select();

                //品牌
                $brandArr=M('Brands')->select();
                $array=array(
                    'group_name'=>$group_name['title'],
                    'brand_name'=>$brand_name,
                    'autGroup'=>$autGroup,
                    'brandArr'=>$brandArr,

                );
                $this->assign($array);
                $this->assign('data',$data);
                $this->display();

            }catch(Exception $e){

                $message=$e->getMessage();
                $this->error($message);
            }
        }

    }

    /*
     * 添加数据（客服添加）
     * */
    public function add_resource()
    {
        if(IS_POST){

            try{
                $res=D('Resource')->addData();
                if(empty($res)) throw new Exception('添加失败');

                $this->success('添加成功',U('Admin/Resource/customer'));
            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }


        }else{

            //用户组
            $autGroup=M('AuthGroup')->select();
            //品牌
            $brandArr=M('Brands')->select();
            $array=array(
                'autGroup'=>$autGroup,
                'brandArr'=>$brandArr,
            );

            $this->assign($array);
            $this->display();
        }
    }

    /*
     * 数据审核（对应的组，如科应组）
     * */
    public function audit()
    {
        $uid=session('user.id');
        $group=M('AuthGroupAccess')->where("uid=$uid")->find();
        $data=D('Resource')->selectData("group_id = {$group['group_id']}");
        //所有组
        $group=M('AuthGroup')->select();
        $phone=I('get.phone');
        $s_group=I('get.group');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');


        $this->assign(array('phone'=>$phone,'s_group'=>$s_group,'start_time'=>$start_time,'end_time'=>$end_time));
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集

        $this->display();
    }

    /*
     * 数据修改(组)是否可跟，回访人...
     * */
    public function group_modify()
    {
        try{

            $res=D('Resource')->groupModify();
            if(!$res) throw new Exception('修改失败');

            $this->success('修改成功',U('Admin/Resource/audit'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }

    }


}