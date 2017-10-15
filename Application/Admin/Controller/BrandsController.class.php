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
       /* $count= M('BrandsAuth')
            ->alias('b')
            ->field("b.gid,g.title,group_CONCAT(`name`,'(',count,')') as brand_count ")
            ->join('left join bt_brands as t on b.brands_id=t.id ')
            ->join('left join bt_auth_group as g on b.gid=g.id')
            ->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出*/

        $data=M('BrandsAuth')
            ->alias('b')
            ->field("b.gid,g.title,group_CONCAT(`name`,'( ',count,' )') as brand_count,ifnull(z.total,0) as total")
            ->join('left join bt_brands as t on b.brands_id=t.id ')
            ->join('left join bt_auth_group as g on b.gid=g.id')
            ->join('left join bt_total as z on z.group_id=g.id')
            ->group('b.gid')
            ->order('g.id')
            ->select();

        $array=array(
            'data'=>$data
        );
        $this->assign($array);
        $this->display();
    }

    /*
     * 品牌分组详情
     * */
    public function detail()
    {
        $gid=I('get.gid')+0;
        $group=M('AuthGroup')->where("id={$gid}")->find();
        $data=M('BrandsAuth')
            ->alias('b')
            ->field('b.id,b.gid,t.name,b.count')
            ->join('left join bt_brands as t on b.brands_id=t.id')
            ->where("b.gid={$gid}")
            ->select();

        $array=array(
            'data'=>$data,
            'group_name'=>$group['title']
        );
        $this->assign($array);

        $this->display();
    }

    /*
     * 删除分配组中的品牌分配
     * */
    public function del_brand()
    {
        $id=I('get.id');
        $gid=I('get.gid');

        $res=M('BrandsAuth')->where("id={$id}")->delete();
        if($res){
            $this->success('删除成功',U('Admin/Brands/detail',array('gid'=>$gid)));
        }else{
            $this->error('删除失败');
        }

    }

    /*
     * 修改分配组中的品牌数量
     * */
    public function edit_brand()
    {
        $id=I('post.brandId');
        $groupId=I('post.groupId');
        $count=I('post.count');

        $res=M('BrandsAuth')->where("id={$id}")->save(array('count'=>$count));
        if($res){
            $this->success('修改成功',U('Admin/Brands/detail',array('gid'=>$groupId)));
        }else{
            $this->error('修改失败');
        }

    }

    /*
     * 分配数据
     * */
    public function allot()
    {
        if(IS_POST){
            try{
                $group_id=I('post.group_id');
                $brand_id=I('post.brand_id');
                $count=I('post.count');

                if(empty($group_id)) throw new Exception('请选择用户组');
                if(empty($brand_id)) throw new Exception('请选择分配品牌');
//                if(empty($count)) throw new Exception('请输入分配数量');
                $map['brands_id']=$brand_id;
                $map['gid']=$group_id;
                $res=M('BrandsAuth')->where($map)->find();
                if($res) throw new Exception('已经分配过！');

                $map['count']=$count;

                $data=M('BrandsAuth')->add($map);

                if(!$data) throw new Exception('分配失败');

                $this->success('分配成功',U('Admin/Brands/brand_auth'));

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
     * 分配总数
     * */
    public function total()
    {
        $data=M('Total')->alias('t')
            ->field('t.id,t.title,t.group_id,t.total,g.title as group_name')
            ->join('bt_auth_group as g on t.group_id = g.id')
            ->select();

        //所有组
        $group=M('AuthGroup')->select();


        $this->assign('data',$data);
        $this->assign('group',$group);
        $this->display();
    }

    public function add_total()
    {
        $title=I('post.title');
        $group_id=I('post.group');
        $total=I('post.total');

        $res=M('Total')->where("group_id={$group_id}")->find();
        if($res){
            $this->error('该组已经分配有了');
        }
        $array=array(
            'title'=>$title,
            'group_id'=>$group_id,
            'total'=>$total
        );

        $data=M('Total')->add($array);

        if($data){
            $this->success('添加成功',U('Admin/Brands/total'));
        }else{
            $this->error('添加失败');
        }

    }

    public function edit_total()
    {
        $total=I('post.total_count');
        $id=I('post.id');

        $data=M('Total')->where("id={$id}")->save(array('total'=>$total));

        if($data){
            $this->success('修改成功',U('Admin/Brands/total'));
        }else{
            $this->error('修改失败');
        }
    }

}