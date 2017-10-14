<?php
namespace Admin\Model;

use Think\Exception;
use Think\Model;

class ResourceModel extends Model
{
    /*
     * 获取全部数据
     * */
    public function selectData($where='1')
    {

        $phone=trim(I('get.phone',''));
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
                if($val['province'] > 0){

                    $province=M('Province')->where("id={$val['province']}")->find();

                    $val['province_name']=$province['name'];
                }
            }
        }

        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

    public function edit()
    {

        $id=I('post.id');
        $username=I('post.username');
        $phone=I('post.phone');
        $chats=I('post.chats');
        $province_id=I('post.province');//省份id
        $customer_info=I('post.customer_info');//客服信息
        $address=I('post.address');
        $source=I('post.source');
        $group_id=I('post.group_id');
        $brand_id=I('post.brand_id');
        $remarks=I('post.keyword');
        //选择区域id
        $province=M('Province')->where("id={$province_id}")->find();

        if(empty($group_id)){
            $allocation=1;
        }else{
            $allocation=2;
        }

        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['address']=$address;
        $map['username']=$username;
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['customer_info']=$customer_info;
        $map['brand_id']=$brand_id;
        $map['province']=$province_id;
        $map['area_id']=$province['area_id'];
        $map['source']=$source;
        $map['keyword']=$remarks;
        $map['allocation']=$allocation;

        $result=$this->where("id={$id}")->save($map);
        return $result;
    }

    /*
     * 添加数据
     * */
    public function addData()
    {
        $username=I('post.username');
        $phone=I('post.phone');
        $chats=I('post.chats');
        $province_id=I('post.province');//省份id
        $customer_info=I('post.customer_info');//客服信息
        $address=I('post.address');
        $source=I('post.source');
        $group_id=I('post.group_id');
        $brand_id=I('post.brand_id');
        $remarks=I('post.keyword');

        if(empty($source)) throw new Exception('请填写来源渠道');
        if(empty($brand_id)) throw new Exception('请选择咨询品牌');

        //选择区域id
        $province=M('Province')->where("id={$province_id}")->find();

        if(empty($group_id)){
            $group_id=$this->allocationGroup($brand_id,$province['area_id']);
        }

        if(empty($group_id)){
            $allocation=1;
        }else{
            $allocation=2;
        }

        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['address']=$address;
        $map['username']=$username;
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['customer_info']=$customer_info;
        $map['brand_id']=$brand_id;
        $map['province']=$province_id;
        $map['area_id']=$province['area_id'];
        $map['source']=$source;
        $map['keyword']=$remarks;
        $map['allocation']=$allocation;

        $res=$this->add($map);

        return $res;
    }

    /*
     * 分配组
     * @param $brand_id [品牌id]
     * @param $area_id [地区id]
     * @return $group_id [用户组id]
     * */
    public function allocationGroup($brand_id,$area_id)
    {

        $group=M('AuthGroup')->field('id,title,area_id')->select();
        $group_id='';
        foreach($group as $key=>$val){
            $arr=explode(',',$val['area_id']);
            if(!in_array($area_id,$arr)){
                unset($group[$key]);
            }
            $group_id .=$val['id'].',';

        }

        $group_id=trim($group_id,',');          //所有用户组id
        $map['group_id']  = array('in',$group_id);
        $total_count=M('Total')->where($map)->select();//总数
        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        foreach($total_count as $key=>$val){
            $group_total=M('Resource')->
            field('count(*) as num')
                ->where("group_id={$val['group_id']} and addtime  between {$startDay} and {$endDay}")
                ->select();
            if($group_total[0]['num'] >= $val['total']){
                unset($total_count[$key]);
            }
        }
        //总数都满了
        if(empty($total_count)){
            return 0;
        }

        //品牌超出 删除
        $arr=array();
        foreach($total_count as $key=>$val){
            //今天这个品牌的数量
            $count=$this->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")->count();
            $arr[$val['group_id']]=$count;
        }
        $total=0;
        $brand=M('BrandsAuth')->where("brands_id={$brand_id}")->select();
        //清除个数已满的
        foreach($brand as $key=>$val){
            //设置限定个数
            if($val['count'] > 0){
                if($arr[$val['gid']] >= $val['count']){
                    unset($arr[$val['gid']]);
                }
            }

            $total +=$val['count'];//这个品牌总分配数
        }

        if(empty($arr)){
            return 0;
        }

        $gid=$this->getGid($arr,$total);

        return $gid;

        /*dump($gid);
        dump($arr);
        dump($total_count);exit;*/
        /*//搜索这个品牌的，所有组的数量
        $group_num=M('Resource')->
            field('group_id,count(*) as num')
            ->where("brand_id={$brand_id} and area_id={$area_id}")
            ->group('group_id')
            ->select();

        $auth['brands_id']=$brand_id;
        $auth['git']=array('in',$group_id);

        $brand=M('BrandsAuth')->where($auth)->select();
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

        return $gid;*/

    }

    public function getGid($array,$total)
    {
        $map=[];
        foreach($array as $key=>$val){
            $map[$key]=round($val / $total,2);
        }
        $gid=array_search(min($map),$map);

        return $gid;
    }

    /*
     * 组修改数据（科应）
     * */
    public function groupModify()
    {
        $company=I('post.company'); //公司名
        $confirm_address=I('post.confirm_address'); //确认地址
        $assistant=I('post.assistant'); //回访人
        $confirm_remark=I('post.confirm_remark'); //备注
        $status=I('post.status'); //是否可跟
        $resId=I('post.resId'); //id
        $groupId=I('post.groupId'); //组id

        if(empty($assistant)) throw new Exception('请填入回访人');
        if($status === '') throw new Exception('请选择是否可跟');

        $map['id']=$resId;
        $map['group_id']=$groupId;

        $array['company']=$company;
        $array['confirm_address']=$confirm_address;
        $array['assistant']=$assistant;
        $array['remark']=$confirm_remark;
        $array['status']=$status;
        $array['update_time']=time();

        $res=$this->where($map)->save($array);

        return $res;
    }

    /*
     * 导出数据
     * @param $field array or string [查询的字段]
     * @param $where array or string [查询条件]
     * @param $order string [排序条件]
     * */
    public function exportData($field,$where=1,$order='address desc,allocation')
    {
        $data=$this
            ->field($field)
            ->where($where)
            ->order($order)
            ->select();
        $type=[1=>'平台手动',2=>'53客服平台'];
        $fenpei=[1=>'未分配',2=>'已分配'];
        $status=[1=>'可跟',2=>'不可跟'];
        if(!empty($data)){
            foreach($data as $key=>&$val){
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                if($val['group_id'] > 0){
                    $res=M('AuthGroup')->where("id={$val['group_id']}")->find();
                    $val['group_id']=$res['title'];
                }
                if($val['brand_id'] > 0){
                    $brands=M('Brands')->where("id={$val['brand_id']}")->find();
                    $val['brand_id']=$brands['name'];
                }

                if($val['province'] > 0){
                    $province=M('Province')->where("id={$val['province']}")->find();
                    $val['province']=$province['name'];
                }
                if($val['status'] > 0   ){
                    $val['status']=$status[$val['status']];
                }else{
                    $val['status']='';
                }
                if($val['update_time'] > 0){
                    $val['update_time']=date('Y-m-d H:i:s',$val['update_time']);
                }else{
                    $val['update_time']='';
                }

                $val['types']=$type[$val['types']];
                $val['allocation']=$fenpei[$val['allocation']];
            }
        }
      
        return $data;


    }




}