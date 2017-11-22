<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Controller;

/*
 * 区域 （分配）
 * */
class AreaController extends AdminBaseController
{
    /*
     * 区域列表
     * */
    public function index()
    {
        $data=D('Area')->listData();
        $this->assign('data',$data);

        $this->display();
    }

    /*
     * 添加数据
     * */
    public function add()
    {
        $name=I('post.name');
        if(empty($name)){
            $this->error('区域名称不能为空');
        }

        $res=M('Area')->add(array('area_name'=>$name));

        if($res){
            $this->success('添加成功',U('Admin/Area/index'));
        }else{
            $this->error('添加失败');
        }

    }

    /*
     * 修改数据
     * */
    public function edit()
    {

        $id=I('post.id');
        $name=I('post.name');

        $res=M('Area')->where("id={$id}")->save(array('area_name'=>$name));

        if($res){
            $this->success('修改成功',U('Admin/Area/index'));
        }else{
            $this->error('修改失败');
        }

    }

    /*
     * 删除数据
     * */
    public function delete()
    {
        $id=I('get.id');

        M('Area')->where("id={$id}")->delete();
        $res=M('Province')->where("area_id={$id}")->save(array('area_id'=>0));

        if($res){
            $this->success('删除成功',U('Admin/Area/index'));
        }else{
            $this->error('删除失败');
        }

    }

    /*
     * 分配区域
     * */
    public function province()
    {
        if(IS_POST){
            $provinceId=I('post.provinceId');
            $area_id=I('post.area_id');

            $res=M('Province')->where("id={$provinceId}")->save(array('area_id'=>$area_id));

            if($res){
                $data=array('code'=>200,'message'=>'分配成功');
            }else{
                $data=array('code'=>400,'message'=>'分配失败');
            }

            echo json_encode($data);
            exit;

        }else{
            $data=M('Province')->select();
            $area=M('Area')->select();
            $array=array(
                'data'=>$data,
                'area'=>$area
            );

            $this->assign($array);

            $this->display();
        }

    }

    /*
     * 添加省份
     * */
    public function add_provinc()
    {
        $name=trim(I('post.name'));
        if(empty($name)){
            $this->error('省份名称不能为空');
        }

        $data=M('Province')->where("name='{$name}'")->find();

        if($data){
            $this->error('该名称已添加过了');
            return false;
        }


        $res=M('Province')->add(array('name'=>$name));

        if($res){
            $this->success('添加成功',U('Admin/Area/province'));
        }else{
            $this->error('添加失败');
        }



    }

    /*
     * 获取省份
     * @data 2017-11-22 13:45
     * */
    public function get_province()
    {
        $get_province=I('get.get_province','');

        $array['name']=array('like',"%$get_province%");
        $brandArr=M('Province')->field('id,name')
            ->where($array)
            ->select();
        if(empty($brandArr)){
            $data=array('code'=>400,'data'=>'');
        }else{
            $data=array('code'=>200,'data'=>$brandArr);
        }
        $this->ajaxReturn($data);
    }


}
