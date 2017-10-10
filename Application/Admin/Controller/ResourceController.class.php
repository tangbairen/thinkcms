<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;

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
        $this->display();
    }


}