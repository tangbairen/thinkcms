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

}