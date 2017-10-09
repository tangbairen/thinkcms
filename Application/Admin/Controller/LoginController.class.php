<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;
use Think\Verify;

class LoginController extends Controller
{
    /*
     * 登录页
     * */
    public function index()
    {
        $res=session('userinfo');
        $this->display();
    }

    /*
     * 验证码
     * */
    public function code()
    {
        $config = array(
            'fontSize' => 30, // 验证码字体大小
            'length' => 4, // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        );

        $Verify = new Verify($config);
        // 开启验证码背景图片功能 随机使用 ThinkPHP/Library/Think/Verify/bgs 目录下面的图片
        $Verify->entry();
    }

    /*
     * 处理登录
     * */
    public function handler()
    {
        try{
            if(!IS_POST) throw new Exception('非法请求');
            $result=D('Users')->check_login();
            echo  json_encode(array('code'=>200,'message'=>'登录成功'));

        }catch(Exception $e){
            $message=$e->getMessage();
            echo  json_encode(array('code'=>400,'message'=>$message));
        }

    }

    /*
     * 退出登录
     * */
    public function loginout()
    {
        session('user',null);
        $this->success('退出成功',U('login/index'),3);
    }

    /*
     * 空操作
     * */
    public function _empty()
    {
        $this->error('访问的资源不存在');
    }

}