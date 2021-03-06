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

        $data=M('Brands')->order('order_by desc')->select();
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
            $identify=I('post.identify','','htmlspecialchars');
            $name=trim($name);
            $identify=trim($identify);
            if(empty($name)) throw new Exception('品牌名称不能为空');
            if(empty($identify)) throw new Exception('标识不能为空');

            //判断是否存在
            $data=M('Brands')->where("name='{$name}'")->select();
            if($data) throw new Exception('品牌已存在');
            $map['name']=$name;
            $map['identify']=$identify;
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
            $identify2=I('post.identify2','','htmlspecialchars');
            $status=I('post.status');
            if(empty($id)) throw new Exception('数据不存在！');
            if(empty($name)) throw new Exception('品牌名不能为空！');
            if(empty($identify2)) throw new Exception('标识不能为空！');
            $map['name']=trim($name);
            $map['identify']=trim($identify2);
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
            ->field("b.gid,g.name,group_CONCAT(t.`name`,'( ',count,' )') as brand_count,ifnull(z.total,0) as total")
            ->join('left join bt_brands as t on b.brands_id=t.id ')
            ->join('left join bt_role_department as g on b.gid=g.id')
            ->join('left join bt_total as z on z.group_id=g.id')
            ->group('b.gid,total')
            ->order('g.id')
            ->where('z.id > 0')
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
        $group=M('RoleDepartment')->where("id={$gid}")->find();
        $data=M('BrandsAuth')
            ->alias('b')
            ->field('b.id,b.gid,t.name,b.count')
            ->join('left join bt_brands as t on b.brands_id=t.id')
            ->where("b.gid={$gid}")
            ->select();

        $array=array(
            'data'=>$data,
            'group_name'=>$group['name'],
            'gid'=>$gid
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
                if(empty($group_id)) throw new Exception('请选择用户组');

                $map['gid']=$group_id;
                $res=M('BrandsAuth')->where($map)->find();
                if($res) throw new Exception('已经分配过！');

                $arr=I('post.');
                unset($arr['group']);
                unset($arr['group_id']);

                foreach($arr as $key=>$val){
                    if($val === '' && !is_numeric($val)){
                        unset($arr[$key]);
                    }
                }

                if(empty($arr)) throw new Exception('至少分配一个品牌的数量');

                foreach($arr as $k=>$v){
                    $strarr['gid']=$group_id;
                    $strarr['brands_id']=$k;
                    $strarr['count']=$v;
                    $data=M('BrandsAuth')->add($strarr);
                }


                $this->success('分配成功',U('Admin/Brands/brand_auth'));

            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }

        }else{

            //用户组
            //$autGroup=M('AuthGroup')->select();

            //部门
            $autGroup=M('RoleDepartment')->select();

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
            ->field('t.id,t.title,t.group_id,t.total,t.account_numbe,g.name as group_name')
            ->join('bt_role_department as g on t.group_id = g.id')
            ->select();

        //所有组
        //$group=M('AuthGroup')->select();

        //部门
        $group=M('RoleDepartment')->select();
        $this->assign('data',$data);
        $this->assign('group',$group);
        $this->display();
    }

    public function add_total()
    {
        $title=I('post.title');
        $group_id=I('post.group');
        $total=I('post.total');
        $check2=I('post.check2');

        $account_numbe=implode($check2,',');

        $res=M('Total')->where("group_id={$group_id}")->find();
        if($res){
            $this->error('该组已经分配有了');
        }
        $array=array(
            'title'=>$title,
            'group_id'=>$group_id,
            'total'=>$total,
            'account_numbe'=>$account_numbe
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
        $total_title=I('post.total_title');
        $edit_check2=I('post.edit_check2');
        $account_numbe=implode($edit_check2,',');

        $data=M('Total')->where("id={$id}")->save(array('total'=>$total,'account_numbe'=>$account_numbe));

        if($data){
            $this->success('修改成功',U('Admin/Brands/total'));
        }else{
            $this->error('修改失败');
        }
    }

    /*
     * 来源渠道列表
     * */
    public function referer()
    {
        $data=M('Referer')->select();


        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 添加来源数据
     * */
    public function add_referer()
    {
        try{
            $title=I('post.title');
            $company=I('post.company','');
            $url=I('post.url');
            if(empty($title)) throw new Exception('标题不能为空');
            if(empty($url)) throw new Exception('url地址不能为空');

            $map['title']=$title;
            $map['url']=$url;
            $map['company']=$company;
            $data=M('Referer')->where("url='{$url}'")->select();
            if($data) throw new Exception('url地址已添加过了');

            $res=M('Referer')->add($map);

            if(!$res) throw new Exception('添加失败');

            $this->success('添加成功',U('Admin/Brands/referer'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }
    }

    /*
     * 删除来源渠道数据
     * */
    public function del_referer()
    {
        $id=I('get.id');
        $res=M('Referer')->where("id={$id}")->delete();
        if($res){
            $this->success('删除成功',U('Admin/Brands/referer'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * 修改来源渠道数据
     * */
    public function edit_referer()
    {

        try{
            $edit_id=I('post.edit_id');
            $edit_title=I('post.edit_title');
            $edit_url=I('post.edit_url');
            $edit_company=I('post.edit_company');
            if(empty($edit_title)) throw new Exception('标题不能为空');
            if(empty($edit_url)) throw new Exception('url地址不能为空');

            $map['title']=$edit_title;
            $map['url']=$edit_url;
            $map['company']=$edit_company;

            $res=M('Referer')->where("id={$edit_id}")->save($map);
            if(!$res) throw new Exception('修改失败');

            $this->success('修改成功',U('Admin/Brands/referer'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }
    }


    /*
     * 删除总数
     * */
    public function del_total()
    {

        $id=I('get.id');
        $group_id=I('get.group_id');
        M('BrandsAuth')->where("gid={$group_id}")->delete();
        $res=M('Total')->where("id={$id}")->delete();
        if($res){
            $this->success('删除成功',U('Admin/Brands/total'));
        }else{
            $this->error('删除失败');
        }

    }

    /*
     * 删除品牌分配规则
     * */
    public function del_data()
    {
        $gid=I('get.gid',0);

        $res=M('BrandsAuth')->where("gid={$gid}")->delete();
        M('Total')->where("group_id={$gid}")->delete();
        if($res){
            $this->success('删除成功',U('Admin/Brands/brand_auth'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * 品牌排序
     * @date 2017-11-17 09:25
     * */
    public function order()
    {
        $data=I('post.');

        $result=$this->orderData($data);
        if ($result) {
            $this->success('排序成功',U('Admin/Brands/index'));
        }else{
            $this->error('排序失败');
        }
    }

    /**
     * 数据排序
     * @param  array $data   数据源
     * @param  string $id    主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($data,$id='id',$order='order_by'){
        foreach ($data as $k => $v) {

            $v=empty($v) ? null : $v;
            M('Brands')->where(array($id=>$k))->save(array($order=>$v));
        }
        return true;
    }

    /*
     * 获取所有品牌
     * */
    public function getbrand()
    {
        $brandArr=M('Brands')->field('id,name')
            ->order('order_by desc')
            ->select();
        if(!empty($brandArr)){
            $data=array('status'=>'success','data'=>$brandArr);
        }else{
            $data=array('status'=>'error','data'=>'');
        }

        echo json_encode($data);
    }

    /*
     * 获取搜索的品牌
     * */
    public function get_brands()
    {
        $brand_name=I('get.brand_name','');
        $array['name']=array('like',"%$brand_name%");
        $brandArr=M('Brands')->field('id,name')
            ->where($array)
            ->order('order_by desc')
            ->select();

        $this->ajaxReturn($brandArr);
    }


    /*
     * 品牌分类
     * @date 2017-11-20
     * */
    public function category()
    {
        if(IS_POST){

            try{
                $name=I('post.name','');
                $parent_id=I('post.parent_id',0);
                $description=I('post.description','');
                if(empty($name)) throw new Exception('品牌分类名称不能为空');

                $map['name']=$name;
                $map['parent_id']=$parent_id;
                $map['description']=$description;

                $res=M('BrandsCategory')->add($map);
                if(empty($res)) throw new Exception('添加失败');

                $this->success('添加成功');

            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }


        }else{

            $data=M('BrandsCategory')->select();
            $data=\Org\Nx\Data::tree($data,'name','id','parent_id');
            $this->assign('data',$data);
            $this->display();
        }

    }

    /*
     * 增加新的品牌
     * @date 2017-11-25 10:50
     * */
    public function newbrands()
    {
        if(IS_POST){

            try{
                $group_id=I('post.group_id')+0;
                if(empty($group_id)) throw new Exception('请选择用户组');

                $arr=I('post.');


                unset($arr['group_id']);

                foreach($arr as $key=>$val){
                    if($val === '' && !is_numeric($val)){
                        unset($arr[$key]);
                    }
                }
                if(empty($arr)) throw new Exception('至少分配一个品牌的数量');

                foreach($arr as $k=>$v){
                    $strarr['gid']=$group_id;
                    $strarr['brands_id']=$k;
                    $strarr['count']=$v;
                    $data=M('BrandsAuth')->add($strarr);
                }


                $this->success('分配成功',U('Admin/Brands/brand_auth'));

            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }



        }else{

            $gid=I('get.gid',0)+0;
            $group=M('RoleDepartment')->where("id={$gid}")->find();

            $brands_id=M('BrandsAuth')->field("GROUP_CONCAT(brands_id) as brands_id")->where("gid = {$gid}")->find();

            //品牌
            $brandArr=M('Brands')
                ->field('b.*')
                ->alias('b')
                ->join('left join bt_brands_auth as t on t.gid=b.id')
                ->where("b.id not in({$brands_id['brands_id']})")
                ->select();

            $array=array(
                'brandArr'=>$brandArr,
                'group'=>$group
            );

            $this->assign($array);
            $this->display();
        }

    }


}