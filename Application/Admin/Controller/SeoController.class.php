<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Exception;

/*
 * 处理SEO
 * */
class SeoController extends AdminBaseController
{
    /*
     * 列表
     * */
    public function index()
    {
        $phone=I('get.phone','');
        if(empty($phone)){
            $where="source='SEO优化'";
        }else{
            $where='phone='.$phone;
        }
        $data=D('Resource')->selectData($where);
        //部门
        $group=M('RoleDepartment')->select();
        $phone=I('get.phone');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $brand_id=I('get.brand','');


        $brand=M('Brands')->select();//品牌
        $referer=M('Referer')->field('distinct title')->select();//来源渠道

        $array=array(
            'phone'=>$phone,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'brand'=>$brand,
            'brand_id'=>$brand_id,
            'referer'=>$referer
        );

        $this->assign($array);
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集
        $this->display();

    }

    /*
     * 添加数据
     * */
    public function add_data()
    {
        if(IS_POST){

            try{
                $res=D('Resource')->addData();
                if(empty($res)) throw new Exception('添加失败');

                $this->success('添加成功',U('Admin/seo/index'));
            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }


        }else {
            //省份
            $province = M('Province')->select();
            //品牌
            $brandArr = M('Brands')->order('order_by desc')->limit(45)->select();
            $array = array(
                'brandArr' => $brandArr,
                'province' => $province
            );

            $this->assign($array);
            $this->display();
        }
    }
}