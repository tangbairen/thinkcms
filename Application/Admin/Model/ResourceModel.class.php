<?php
namespace Admin\Model;

use Think\Exception;
use Think\Model;

class ResourceModel extends Model
{
    /*
     * 获取全部数据
     * */
    public function selectData()
    {
        $where='1';
        $phone=trim(I('get.phone','','htmlspecialchars'));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        if(!empty($phone)){
            $where .=" and phone={$phone}";
        }
        if(!empty($s_group)){
            $where .=" and group_id={$s_group}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and addtime >={$start_time}";
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where .=" and addtime <={$end_time}";
        }


        $count      = $this->where($where)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出

        $data=$this->where($where)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('AuthGroup')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['title'];
                }
                if($val['brand_id'] > 0){
                    $brands=M('Brands')->where("id={$val['brand_id']}")->find();
                    $val['brands_name']=$brands['name'];
                }
            }
        }

        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

    public function edit()
    {
        $id=I('post.id');
        $group_id=I('post.group_id');//用户组id
        $username=I('post.username');
        $phone=I('post.phone');
        $chats=I('post.chats');
        $address=I('post.address');
        $source=I('post.source');
        $brand_id=I('post.brand_id');//品牌id
        $remarks=I('post.remarks');

        $map['group_id']=$group_id;
        $map['username']=$username;
        $map['phone']=$phone;
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['address']=$address;
        $map['source']=$source;
        $map['remarks']=$remarks;
        $map['brand_id']=$brand_id;

        $result=$this->where("id={$id}")->save($map);
        return $result;
    }

    /*
     * 添加数据
     * */
    public function addData()
    {
        $group_id=I('post.group_id');
        $username=I('post.username');
        $phone=I('post.phone');
        $chats=I('post.chats');
        $address=I('post.address');
        $source=I('post.source');
        $brand_id=I('post.brand_id');
        $remarks=I('post.remarks');

        if(empty($username)) throw new Exception('请填写姓名');
        if(empty($source)) throw new Exception('请填写来源渠道');
        if(empty($brand_id)) throw new Exception('请选择咨询品牌');

        if(empty($group_id)){
            $group_id=$this->allocationGroup($brand_id);
        }
        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['address']=$address;
        $map['username']=$username;
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['brand_id']=$brand_id;
        $map['source']=$source;
        $map['remarks']=$remarks;

        $res=$this->add($map);

        return $res;
    }

    /*
     * 分配组
     * @param $brand_id [品牌id]
     * @return $group_id [用户组id]
     * */
    public function allocationGroup($brand_id)
    {
        $brand=M('BrandsAuth')->where("brands_id={$brand_id}")->select();
        //如果没有设置分配规则
        if(empty($brand)){
            return 0;
        }
        $array=[];
        $total=0;
        foreach($brand as $key=>$val){
            $count=$this->where("group_id={$val['gid']} and brand_id={$val['brands_id']}")->count();
            $array[$val['gid']][]=$count;//记录用户组分配了多少个品牌
            $total +=$val['count'];//这个品牌总分配数
        }

        //清除个数已满的
        foreach($brand as $key=>$val){
            if($val['count'] >= $array[$val['gid']]){
                unset($array[$val['gid']]);
            }

        }
        if(empty($array)){
            return 0;
        }

        $gid=$this->getGid($array,$total);

        return $gid;

    }

    public function getGid($array,$total)
    {
        $map=[];
        foreach($array as $key=>$val){
            $map[$key]=round($val[0] / $total,2);
        }
        $gid=array_search(min($map),$map);

        return $gid;
    }

}