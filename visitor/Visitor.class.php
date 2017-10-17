<?php
require('./MMysql.class.php');
/*
 * 处理类
 * */
class Visitor
{
    public $conf=array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    );

    /*
     * 访客信息
     * */
    public function addInfo($data)
    {

        if(empty($data)){
            return false;
        }

        $map=array();
        foreach($data as $key=>$val){
            $map[$key]=$val;
        }

        $mysql=new MMysql($this->conf);
        echo 23322;exit;
        $mysql->insert('bt_visitor_info',$map);

        $guest_id=$data['guest_id'];//访客id


        //查询聊天记录是否存在
        $recordData=$this->existData('bt_visitor_record',$guest_id);

        //数据存在
        if(!empty($recordData)){
            $this->addResource($data,$recordData[0]);
        }

    }

    /*
     * 访客聊天记录
     * */
    public function addRecord($data)
    {

        if(empty($data)){
            return false;
        }
        $sessionarr=$data['session'];
        $end=$data['end'];
        $message=$data['message'];
        $id=$this->addRecordData($sessionarr,$end,$message);
        $guest_id=$sessionarr['guest_id'];
        //查询客户信息是否存在
        //$exist=D('VisitorInfo')->where("guest_id={$guest_id} and status=1")->find();
        $mysql=new MMysql($this->conf);
        $exist=$mysql->where("guest_id={$guest_id} and status=1")->select('bt_visitor_info');

        $recordData=array_merge($sessionarr,$end);
        //数据存在
        if(!empty($exist)){
            $this->addResource($exist[0],$recordData,$message);
        }

    }

    public function addRecordData($sessionarr,$end,$message)
    {
        $map=array_merge($sessionarr,$end);

        $map['talk_time']=strtotime($sessionarr['talk_time']);
        $map['end_time']=strtotime($end['end_time']);
        $map['message']=json_encode($message);

        //$id=$this->add($map);

        $mysql=new MMysql($this->conf);
        $id=$mysql->insert('bt_visitor_record',$map);
        return $id;
    }

    /*
     * 添加到资源里面
     * @param $data [访客信息]
     * @param $recordData [访客聊天信息]
     * */
    public function addResource($data,$recordData)
    {
        $guest_name=$data['guest_name']; //客服名称
        $len=strpos($guest_name,'#');
        $phone=substr($guest_name,$len+1);//手机号码
        $guest_area=mb_substr($recordData['guest_area'],0,2,'UTF-8');//访客所在省份，（查询所在区域）
        $keyword=$recordData['kw'];
        $device=array(1=>'PC',2=>'移动',3=>'微信');
        $source=$recordData['se'].$device[$recordData['device']];//来源渠道
        $talk_page=$recordData['talk_page'];//咨询地址

        $area=$this->getAreaId($guest_area);//获取省份信息（得到区域id）
        $brand_id=$this->getBrandId($keyword,$talk_page);//获取品牌id

        $group_id=$this->allocationGroup($brand_id,$area['area_id']);


        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['talk_id']=$recordData['talk_id'];
        $map['address']=$recordData['guest_area'];
        $map['username']='';
        $map['phone']=$phone;
        $map['chats']=$data['qq'].','.$data['email'];
        $map['customer_info']=$data['worker_id'];
        $map['brand_id']=$brand_id;
        $map['province']=$area['id'];
        $map['area_id']=$area['area_id'];
        $map['source']=$source;
        $map['keyword']=$keyword;
        $map['types']=2;

        $mysql=new MMysql($this->conf);
        $mysql->insert('bt_resource',$map);
        //D('Resource')->add($map);
       // D('VisitorRecord')->where("guest_id={$data['guest_id']}")->save(array('status'=>2));
        //D('VisitorInfo')->where("guest_id={$data['guest_id']}")->save(array('status'=>2));

        $mysql->where("guest_id={$data['guest_id']}")->update('bt_visitor_record',array('status'=>2));
        $mysql->where("guest_id={$data['guest_id']}")->update('bt_visitor_info',array('status'=>2));

        return true;


    }

    /*
     * 分配组
     * @param $brand_id [品牌id]
     * @param $area_id [地区id]
     * @return $group_id [用户组id]
     * */
    public function allocationGroup($brand_id,$area_id)
    {
        if(empty($brand_id) || empty($area_id)){
            return 0;
        }

        $mysql=new MMysql($this->conf);

        $group=$mysql->field(array('id','title','area_id'))->select('bt_auth_group');

        if(empty($group)){
            return 0;
        }
        //$group=M('AuthGroup')->field('id,title,area_id')->select();
        $group_id='';
        foreach($group as $key=>$val){
            $arr=explode(',',$val['area_id']);
            if(!in_array($area_id,$arr)){
                unset($group[$key]);
            }


        }
        //清除没有品牌的组
        foreach($group as $k=>$v){
            $res=$mysql->where(array('brands_id'=>$brand_id,'gid'=>$v['id']))->select('bt_brands_auth');
            //$res=M('BrandsAuth')->where("brands_id={$brand_id} and gid={$v['id']}")->find();
            if(empty($res)){
                unset($group[$k]);
            }else{

                $group_id .=$v['id'].',';
            }
        }

        $group_id=trim($group_id,',');          //所有用户组id
        $map['group_id']  = array('in',$group_id);
        $totalsql="select * from bt_total where group_id in({$group_id})";
        $total_count=$mysql->doSql($totalsql);
        //$total_count=M('Total')->where($map)->select();//分配总数
        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        foreach($total_count as $key=>$val){
            /*$group_total=M('Resource')->
            field('count(*) as num')
                ->where("group_id={$val['group_id']} and addtime  between {$startDay} and {$endDay}")
                ->select();*/
            $group_total=$mysql->field('count(*) as num')
                ->where("group_id={$val['group_id']} and addtime  between {$startDay} and {$endDay}")
                ->select('bt_resource');

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
            //$count=$this->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")->count();
            $count=$mysql->field('count(*) as num')
                ->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")
                ->select('bt_resource');
            if(!empty($count)){

                $arr[$val['group_id']]=$count[0]['num'];
            }


        }
        $total=0;
        //$brand=M('BrandsAuth')->where("brands_id={$brand_id}")->select();

        $brand=$mysql->where("brands_id={$brand_id}")->select('bt_brands_auth');
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
     * 获取品牌id
     * @param $keywork 关键字
     * @param $talk_page 咨询地址
     * */
    public function getBrandId($keywork,$talk_page)
    {
        $mysql=new MMysql($this->conf);
        $brand=$mysql->select('bt_brands');
//        $brand=M('Brands')->select();
        foreach($brand as $key=>$val){
            $pos=strpos($keywork,$val['name']);
            if($pos !== false){
                return $val['id'];
            }
        }

        return 0;
    }

    /*
     * 获取区域id
     * */
    public function getAreaId($guest_area)
    {
        $mysql=new MMysql($this->conf);
        $sql="select * from bt_province where name like '%{$guest_area}%'";
        $res=$mysql->doSql($sql);
//        $res=M('province')->where("name like '%{$guest_area}%'")->find();


        if($res){
            return $res[0];
        }

        return 0;
    }

    /*
     * 查询是否存在
     * @param $table [表名]
     * @param $guest_id [访客id]
     * */
    public function existData($table,$guest_id)
    {
        $mysql=new MMysql($this->conf);

        $res=$mysql->where(array('guest_id'=>$guest_id,'status'=>1))->select($table);

        return $res;
    }


}