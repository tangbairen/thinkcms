<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Exception;

/*
 * 品牌管理
 * */
class BrandsController extends AdminBaseController
{
    /*
     * 品牌列表
     * */
    public function index()
    {

        $data=M('Brands')->select();
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 添加数据
     * */
    public function add()
    {
        try{
            $name=I('post.name','','htmlspecialchars');
            $name=trim($name);
            if(empty($name)) throw new Exception('品牌名称不能为空');

            //判断是否存在
            $data=M('Brands')->where("name='{$name}'")->select();
            if($data) throw new Exception('品牌已存在');
            $map['name']=trim($name);
            $map['addtime']=time();
            $res=M('Brands')->add($map);
            if(!$res) throw new Exception('添加失败');
            $this->success('添加成功',U('Admin/Brands/index'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }

    }

    /*
     * 删除品牌
     * */
    public function delete()
    {
        $id=I('get.id','','htmlspecialchars');
        $res=M('Brands')->where('id='.$id)->delete();
        if($res){
            $this->success('删除成功',U('Admin/Brands/index'));
        }else{
            $this->error('删除失败');
        }

    }

    /*
     * 修改
     * */
    public function edit()
    {
        try{
            $id=I('post.id');
            $name=I('post.name','','htmlspecialchars');
            $status=I('post.status');
            if(empty($id)) throw new Exception('数据不存在！');
            if(empty($name)) throw new Exception('品牌名不能为空！');
            $map['name']=trim($name);
            $map['status']=$status;
            $res=M('Brands')->where("id={$id}")->save($map);

            if(!$res) throw new Exception('修改失败');

            $this->success('修改成功',U('Admin/Brands/index'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }

    }

    /*
     * 品牌分配规则
     * */
    public function brand_auth()
    {
        $count= M('BrandsAuth')
            ->alias('b')
            ->field("b.gid,g.title,group_CONCAT(`name`,'(',count,')') as brand_count ")
            ->join('left join bt_brands as t on b.brands_id=t.id ')
            ->join('left join bt_auth_group as g on b.gid=g.id')
            ->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出

        $data=M('BrandsAuth')
            ->alias('b')
            ->field("b.gid,g.title,group_CONCAT(`name`,'(',count,')') as brand_count ")
            ->join('left join bt_brands as t on b.brands_id=t.id ')
            ->join('left join bt_auth_group as g on b.gid=g.id')
            ->group('b.gid')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('g.id')
            ->select();
        $array=array(
            'show'=>$show,
            'data'=>$data
        );

        $this->assign($array);
        $this->display();
    }


}