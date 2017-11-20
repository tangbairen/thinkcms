<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Controller;
use Think\Exception;
/*
 * 个人设置（资料）
 * */
class PersonalController extends AdminBaseController
{
    /*
     * 一个基本资料
     * */
    public function index()
    {
        $uid=session('user.id');
        $data=M('Users')->field('id,department_id,username,email,phone,company')->where("id={$uid}")->find();
        $group=M('RoleDepartment')->where("id={$data['department_id']}")->find();
        $this->assign('data',$data);
        $this->assign('group',$group);
        $this->display();
    }

    /*
     * 修改个人资料
     * */
    public function edit()
    {

        try{
            if(!IS_POST) throw new Exception('非法请求');
            //$username=I('post.username','','htmlspecialchars');
            $phone=I('post.phone','','htmlspecialchars');
            $email=I('post.email','','htmlspecialchars');
            $password=I('post.password','','htmlspecialchars');
            $password2=I('post.password2','','htmlspecialchars');
            //if(empty($username)) throw new Exception('登录名不能为空');

            //$map['username']=$username;
            $map['phone']=$phone;
            $map['email']=$email;
            if(!empty($password) || !empty($password2)){
                if($password != $password2) throw new Exception('两个密码不一致');
                $map['password']=md5($password);
                $map['encrypt_pass']=encrypt_encode($password);
            }
            $uid=session('user.id');
            $res=M('Users')->where("id={$uid}")->save($map);

            if($res){
                $this->success('修改成功',U('Personal/index'));
            }else{
                $this->error('修改失败');
            }

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }


    }


}