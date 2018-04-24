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

        //加密密码
        if(empty($data['encrypt_pass'])){
            $arr['encrypt_pass']=encrypt_encode($pass);
            $this->where(array('id'=>$data['id']))->save($arr);
        }


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
        $data=$this->
            field('distinct department_id,id,username,email,phone,company,status,register_time,last_login_ip,last_login_time,login_count,remarks,level')
            ->where("level=3")
            ->select();

        if(!empty($data)){
            // 今日开始时间戳
            $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
            // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            foreach($data as $key=>&$val){
                $name=M('RoleDepartment')->where("id={$val['department_id']}")->find();
                //今日公司的目标数
                $total=M('RoleDepartment')->alias('r')
                    ->field('sum(t.total) as total')
                    ->join('left join bt_total as t on r.id=t.group_id')
                    ->where("r.parent_id={$val['department_id']}")
                    ->find();
                //今日所有公司的资源
                $sql="select count(*) as total,
                count( case status when  0 then status end ) as num1,
                count( case status when 1 then status end ) as num2,
                count( case status when 2 then status end ) as num3
                 from bt_role_department as d
                LEFT JOIN bt_resource as r on d.id=r.group_id
                where d.parent_id={$val['department_id']} and r.addtime between  {$startDay} and {$end}";
                $res=M()->query($sql);
                //月累计
                $firstday =mktime(0, 0, 0, date('m'), 1);
                $lastday = mktime(0, 0, 0,date('m')+1,1)-1;

                $sql="select count(*) as total,count( case status when  0 then status end ) as num1,
                count( case status when 1 then status end ) as num2,
                count( case status when 2 then status end ) as num3
                 from bt_role_department as d
                LEFT JOIN bt_resource as r on d.id=r.group_id
                where d.parent_id={$val['department_id']} and r.addtime between  {$firstday} and {$lastday}";
                $month=M()->query($sql);

                if(!empty($res)){
                    $val['yifenp']=$res[0]['num2']+$res[0]['num3'];
                    $val['weifenp']=$res[0]['num1'];
                    $val['today_youxiao']=$res[0]['num2'];
                    $val['todaynum']=$res[0]['total'];
                }
                $val['total']=isset($total['total']) ? $total['total'] : 0;//今日目标
                $val['totalmonth']=isset($month[0]['total']) ? $month[0]['total'] : 0;//月累计
                $num2=isset($month[0]['num2']) ? $month[0]['num2'] : 0;
                $num3=isset($month[0]['num3']) ? $month[0]['num3'] : 0;
                $val['yifk']=$num2+$num3;//已反馈
                $val['weifk']=isset($month[0]['num1']) ? $month[0]['num1'] : 0;//未反馈
                $val['youxiao']=$num2;//未反馈
                $val['company']=isset($name['name']) ? $name['name'] : '';
            }

            return $data;
        }else{
            return false;
        }


    }





}