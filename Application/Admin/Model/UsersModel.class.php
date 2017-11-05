<?php
namespace Admin\Model;

use Think\Exception;
use Think\Model;

class UsersModel extends Model
{
    /*
     * 处理登录
     * */
    public function check_login()
    {
        $username=I('post.username','','htmlspecialchars');
        $pass=I('post.pass','','htmlspecialchars');
        $code=I('post.code','','htmlspecialchars');

        if(empty($username))throw new Exception('登录名不能为空');
        if(empty($pass))throw new Exception('密码不能为空');
        if(empty($code))throw new Exception('验证码不能为空');

        $res=$this->check_verify($code);
        if(!$res) throw new Exception('验证码错误');

        $data=$this->where("username ='{$username}'")->find();

        if(empty($data)) throw new Exception('用户不存在');

        if($data['status'] != '1') throw new Exception('用户已被禁用请联系管理员');

        $passwd=md5($pass);
        if($passwd != $data['password']) throw new Exception('密码错误');

        $map['last_login_time']=time();
        $map['last_login_ip']=get_client_ip();
        $map['login_count']=$data['login_count']+1;

        $this->where("id={$data['id']}")->save($map);

        session('user',array('id'=>$data['id'],'username'=>$data['username']));
        cookie('loginname',$username,3600*24*7); // 指定cookie保存时间

        return '登录成功';
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /*
     * 获取所有公司下面的部门情况
     * */
    public function getTotalData()
    {
        $data=$this->where("level=3")->select();

        if(!empty($data)){
            // 今日开始时间戳
            $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
            // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            foreach($data as $key=>&$val){
                //今日所有公司的资源
                $sql="select count(*) as total,
                count( case status when  0 then status end ) as num1,
                count( case status when 1 then status end ) as num2,
                count( case status when 2 then status end ) as num2
                 from bt_role_department as d
                LEFT JOIN bt_resource as r on d.id=r.group_id
                where d.parent_id={$val['department_id']} and r.addtime between  {$startDay} and {$end}";
                $res=M()->query($sql);
                p($res);
                if(!empty($res)){
                    $val['yifenp']=$res[0]['num2']+$res[0]['num3'];
                    $val['weifenp']=$res[0]['num1'];
                    $val['youxiao']=$res[0]['num2'];
                }
            }
        }

        p($data);

    }





}