<?php
namespace Admin\Model;

use Think\Exception;
use Think\Model;
header('content-type:text/html;charset=utf-8');
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
        $allocation=I('get.allocation','');
        $brand_id=I('get.brand','');
        $referer_id=I('get.referer','');
        $status=I('get.status','');
        if(!empty($phone)){
            $where .=" and phone like '%{$phone}%' or chats like '%{$phone}%'";
        }

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
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
            if($end_time == $start_time){
                $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                $end_time=$endDay;
            }
            $where .=" and addtime <={$end_time}";
        }
        if(!empty($brand_id)){
            $where .=" and brand_id={$brand_id}";
        }
        if(!empty($referer_id)){
            $where .=" and source like '{$referer_id}%'";
        }
        if(!empty($status) && $status == 3){
            $where .=" and status=0";
        }else if(!empty($status)){
            $where .=" and status={$status}";
        }

        import('@.Class.Page'); //引入Page类
        // 查询满足要求的总记录数
        $count = $this->where($where)->count();
        /*进行第三方分页类配置*/
        $page = array(
            'total' => $count,/*总数（改）*/
            'url' => !empty($param['url']) ? $param['url'] : '',/*URL配置*/
            'max' => !empty($param['max']) ? $param['max'] : 20,/*每页显示多少条记录（改）*/
            'url_model' => 1,/*URL模式*/
            'ajax' =>  !empty($param['ajax']) ? true : false,/*开启ajax分页*/
            'out' =>  !empty($param['out']) ? $param['out'] : false,/*输出设置*/
            'url_suffix' => true,/*url后缀*/
            'tags' => array('首页','上一页','下一页','尾页'),
        );
        /*实例化第三方分页类库*/
        $page = new \Page($page);

        $data=$this->where($where)->order('addtime desc,status asc')->limit($page->pagerows(),$page->maxrows())->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['name'];
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
        // 得到分页
        $show = $page->get_page();
        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

    /*
     * 获取全部数据
     * */
    public function auditData($where='1')
    {

        $phone=trim(I('get.phone',''));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $allocation=I('get.allocation','');
        $brand_id=I('get.brand','');
        $referer_id=I('get.referer','');
        $status=I('get.status','');
        if(!empty($phone)){
            $where .=" and phone={$phone} or chats={$phone}";
        }

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
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
            if($end_time == $start_time){
                $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                $end_time=$endDay;
            }
            $where .=" and addtime <={$end_time}";
        }
        if(!empty($brand_id)){
            $where .=" and brand_id={$brand_id}";
        }
        if(!empty($referer_id)){
            $where .=" and source like '{$referer_id}%'";
        }
        if(!empty($status) && $status == 3){
            $where .=" and status=0";
        }else if(!empty($status)){
            $where .=" and status={$status}";
        }

        import('@.Class.Page'); //引入Page类
        // 查询满足要求的总记录数
        $count = $this->where($where)->count();
        /*进行第三方分页类配置*/
        $page = array(
            'total' => $count,/*总数（改）*/
            'url' => !empty($param['url']) ? $param['url'] : '',/*URL配置*/
            'max' => !empty($param['max']) ? $param['max'] : 20,/*每页显示多少条记录（改）*/
            'url_model' => 1,/*URL模式*/
            'ajax' =>  !empty($param['ajax']) ? true : false,/*开启ajax分页*/
            'out' =>  !empty($param['out']) ? $param['out'] : false,/*输出设置*/
            'url_suffix' => true,/*url后缀*/
            'tags' => array('首页','上一页','下一页','尾页'),
        );
        /*实例化第三方分页类库*/
        $page = new \Page($page);

        $data=$this->where($where)->order('addtime desc,status asc')->limit($page->pagerows(),$page->maxrows())->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['name'];
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
        // 得到分页
        $show = $page->get_page();
        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

    /*
     * 获取全部数据
     * */
    public function bumenData($where='1')
    {

        $phone=trim(I('get.phone',''));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $allocation=I('get.allocation','');
        $brand_id=I('get.brand','');
        $referer_id=I('get.referer','');
        $status=I('get.status','');
        if(!empty($phone)){
            $where .=" and phone={$phone} or chats={$phone}";
        }

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
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
        if(!empty($brand_id)){
            $where .=" and brand_id={$brand_id}";
        }
        if(!empty($referer_id)){
            $where .=" and source like '{$referer_id}%'";
        }
        if(!empty($status) && $status == 3){
            $where .=" and status=0";
        }else if(!empty($status)){
            $where .=" and status={$status}";
        }

        import('@.Class.Page'); //引入Page类
        // 查询满足要求的总记录数
        $count = $this->where($where)->count();

        /*进行第三方分页类配置*/
        $page = array(
            'total' => $count,/*总数（改）*/
            'url' => !empty($param['url']) ? $param['url'] : '',/*URL配置*/
            'max' => !empty($param['max']) ? $param['max'] : 20,/*每页显示多少条记录（改）*/
            'url_model' => 1,/*URL模式*/
            'ajax' =>  !empty($param['ajax']) ? true : false,/*开启ajax分页*/
            'out' =>  !empty($param['out']) ? $param['out'] : false,/*输出设置*/
            'url_suffix' => true,/*url后缀*/
            'tags' => array('首页','上一页','下一页','尾页'),
        );
        /*实例化第三方分页类库*/
        $page = new \Page($page);

        $data=$this->where($where)->order('addtime desc,id desc')->limit($page->pagerows(),$page->maxrows())->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['name'];
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
        // 得到分页
        $show = $page->get_page();
        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

    public function edit()
    {

        $id=I('post.id');
        $username=I('post.username');
        $phone=I('post.phone');
        $chats=I('post.chats');
        $province_id=I('post.province',0);//省份id
        $customer_info=I('post.customer_info');//客服信息
        $address=I('post.address');
        $source=I('post.source');
        $group_id=I('post.group_id');
        $brand_id=I('post.brand_id');
        $remarks=I('post.keyword');
        $service_number=I('post.s_number');
        //选择区域id
        $area_id=0;
        if(!empty($province_id)){
            $province=M('Province')->where("id={$province_id}")->find();
            $area_id=$province['area_id'];
        }

        if(empty($group_id)){
            $allocation=1;
        }else{
            $allocation=2;
        }

        //$map['addtime']=time();
        $map['group_id']=$group_id;
        $map['address']=$address;
        $map['username']=$username;
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['customer_info']=$customer_info;
        $map['brand_id']=$brand_id;
        $map['province']=$province_id;
        $map['area_id']=$area_id;
        $map['source']=$source;
        $map['keyword']=$remarks;
        $map['service_number']=$service_number;
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
        $address=I('post.address','');
        $source=I('post.source');
        $group_id=I('post.group_id');
        $brand_id=I('post.brand_id');
        $remarks=I('post.keyword');
        $s_number=I('post.s_number');

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
        $map['service_number']=$s_number;
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
        if(empty($brand_id) || empty($area_id)){

            return 0;
        }

        //组
        //$group=M('AuthGroup')->field('id,title,area_id')->select();

        //部门
        $group=M('RoleDepartment')->select();

        $group_id='';
        foreach($group as $key=>$val){//清除没有分配的地区的组
            $arr=explode(',',$val['area_id']);
            if(!in_array($area_id,$arr)){
                unset($group[$key]);
            }

        }

        if(empty($group)){

            return 0;
        }

        //清除没有品牌的组
        foreach($group as $k=>$v){
            $res=M('BrandsAuth')->where("brands_id={$brand_id} and gid={$v['id']}")->find();
            if(empty($res)){
                unset($group[$k]);
            }else{
                $group_id .=$v['id'].',';
            }
        }
        //p($group);
        if(empty($group_id)){
            return 0;
        }

        $group_id=trim($group_id,',');          //所有部门id
        $map['group_id']  = array('in',$group_id);
        $total_count=M('Total')->where($map)->select();//总数
        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        foreach($total_count as $key=>$val){
            $group_total=M('Resource')
                ->field('count(*) as num')
                ->where("group_id={$val['group_id']} and addtime  between {$startDay} and {$endDay}")
                ->select();

            if($group_total[0]['num'] >= $val['total']){

                unset($total_count[$key]);
            }else{
                $total_count[$key]['num']=$group_total[0]['num'];
            }
        }

        //总数都满了
        if(empty($total_count)){
            return 0;
        }

        //品牌超出 删除
        $arr=array();//所属组 今日的资源数量
        foreach($total_count as $key=>$val){
            //今天这个品牌的数量
            $count=$this->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")->count();
            $arr[$val['group_id']]=$count+$val['num'];//品牌数+今日资源总数
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

            $total +=$val['count']+$arr[$val['gid']];//这个品牌总分配数+已分配的
        }

        if(empty($arr)){

            return 0;
        }

        $gid=$this->getGid($arr,$total);

        return $gid;

    }

    public function getGid($array,$total)
    {
        $map=array();
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
        $company=I('post.company',''); //公司名
        $confirm_address=I('post.confirm_address'); //确认地址
        $assistant=I('post.assistant'); //回访人
        $confirm_remark=I('post.confirm_remark'); //备注
        $status=I('post.status'); //是否可跟
        $resId=I('post.resId'); //id
        $groupId=I('post.groupId'); //组id

        if(empty($assistant)) throw new Exception('请填入回访人');
        if($status === '') throw new Exception('请选择是否可跟');

        /*if(!empty($company)){

            $array['company']=$company;

        }else{
            $id=session('user.id');
            $data=M('Users')->where("id={$id}")->find();
            $company=isset($data['company']) ? $data['company']: '';
            $array['company']=$company;
        }*/
        /*$id=session('user.id');
        $company=M('Company')->field('company')->alias('c')->join('bt_users as u  on  c.cid=u.id')->where("c.uid={$id}")->find();
        if(empty($company)){
            $array['company']='';
        }else{
            $array['company']=$company['company'];
        }*/

        $array['company']=$company;
        $map['id']=$resId;
        $map['group_id']=$groupId;

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
    public function exportData($field,$where=1,$order='addtime desc,allocation')
    {
        $data=$this
            ->field($field)
            ->where($where)
            ->order($order)
            ->select();
        $type=array(1=>'平台手动',2=>'53客服平台');
        $fenpei=array(1=>'未分配',2=>'已分配');
        $status= array(1=>'可跟',2=>'不可跟');
        if(!empty($data)){
            foreach($data as $key=>&$val){
                $val['addtime']=date('Y-m-d H:i:s',$val['addtime']);
                if($val['group_id'] > 0){
                    $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                    $val['group_id']=$res['name'];
                }else{
                    $val['group_id']='';
                }
                if($val['brand_id'] > 0){
                    $brands=M('Brands')->where("id={$val['brand_id']}")->find();
                    $val['brand_id']=$brands['name'];
                }else{
                    $val['brand_id']='';
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

                $val['keyword']=urldecode($val['keyword']);

                $val['types']=$type[$val['types']];
                $val['allocation']=$fenpei[$val['allocation']];
            }
        }

        return $data;


    }

    /*
     * 处理定时那边的任务
     * $info_id 访客信息 数组
     * $guest_id 访客id
     * */
    public function handler($info,$guest_name,$guest_id)
    {
        $res=M('VisitorRecord')
            ->field('id,guest_id,talk_id,talk_page,guest_area,se,kw,worker_id,worker_name,device,status')
            ->where("guest_id={$guest_id} and status=1")
            ->order('id desc')
            ->find();

        if(!empty($res)){
            $this->allocation($info,$guest_name,$res);

            M('VisitorInfo')->where("id={$info['id']}")->save(array('status'=>2));
            M('VisitorRecord')->where("id={$res['id']}")->save(array('status'=>2));

        }else{//存在 修改资源
            $data=M('VisitorRecord')
                ->field('id,guest_id,talk_id,talk_page,guest_area,se,kw,worker_id,worker_name,device,status')
                ->where("guest_id={$guest_id} and status=2")
                ->order('id desc')
                ->find();
            if($data){
                $phone='';
                $chats='';
                $len=stripos ($guest_name,'t#');

                if($len !== false){
                    $phone=substr($guest_name,$len+2);//手机号码

                }else{
                    $qlen=strrpos($guest_name,'#');
                    if($qlen !== false){
                        $chats=substr($guest_name,$qlen+1);//QQ或微信...
                    }
                }

                if(empty($phone)){
                    $phone =$info['mobile'];
                }

                if(empty($phone)){
                    $phone = '';
                }
                if(empty($chats)){
                    $chats = '';
                }
                $map['phone']=$phone;
                $map['chats']=$chats;
                $this->where("talk_id='{$guest_id}'")->save($map);
            }

        }

        return true;
    }


    /*
     * 信息表id，访客名称（手机号），记录结果集(record)
     * */
    public function allocation($info,$guest_name,$data)
    {

        //选择区域id
        $area=$this->getArea($data['guest_area']);
        if($area){
            $province=$area['id'];
            $area_id=$area['area_id'];
        }else{
            $province=0;
            $area_id=0;
        }
//        $brand_id=$this->getBrandId($data['kw'],$data['talk_page']);
        $bransSource=$this->brands_source($data);//获取来源渠道和品牌
        $group_id=$this->allocationGroup53($bransSource['brand_id'],$area_id,$data['worker_id']);

        if(empty($group_id)){
            $allocation=1;
        }else{
            $allocation=2;
        }

        $phone='';
        $chats='';
        $len=stripos ($guest_name,'t#');

        if($len !== false){
            $phone=substr($guest_name,$len+2);//手机号码

        }else{
            $qlen=strrpos($guest_name,'#');
            if($qlen !== false){
                $chats=substr($guest_name,$qlen+1);//QQ或微信...
            }
        }

        if(empty($phone)){
            $phone =$info['mobile'];
        }

        if(empty($phone)){
            $phone = '';
        }
        if(empty($chats)){
            $chats = '';
        }
        $array=parse_url_param($data['talk_page']);
        $keyword=isset($array['keyword']) ? $array['keyword'] : urlencode($data['kw']);

        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['talk_id']=isset($data['guest_id']) ? $data['guest_id'] : '';
        $map['address']=isset($data['guest_area']) ? $data['guest_area'] : '';
        $map['username']='';
        $map['phone']=$phone;
        $map['chats']=$chats;
        $map['customer_info']=isset($data['worker_id']) ? $data['worker_id'] : '';//客服工号
        $map['brand_id']=isset($bransSource['brand_id']) ? $bransSource['brand_id']: '';//品牌id
        $map['province']=isset($province) ? $province : '';//省份id
        $map['area_id']=isset($area_id) ? $area_id : '';//地区id
        $map['source']=isset($bransSource['source']) ? $bransSource['source'] : '';//来源
        $map['keyword']=isset($keyword) ? $keyword : '';
        $map['allocation']=isset($allocation) ? $allocation : '';
        $map['types']=2;

        $res=$this->add($map);

        return $res;
    }

    /*
     * 分配部门
     * @param $brand_id [品牌id]
     * @param $area_id [地区id]
     * @param $worker_id [客服工号]
     * @return $group_id [用户组id]
     * */
    public function allocationGroup53($brand_id,$area_id,$worker_id='')
    {

        if(empty($brand_id) || empty($area_id)){

            return 0;
        }

        //部门
        $group=M('RoleDepartment')->select();

        $group_id='';
        foreach($group as $key=>$val){//清除没有分配的地区的组
            $arr=explode(',',$val['area_id']);
            if(!in_array($area_id,$arr)){
                unset($group[$key]);
            }

        }

        if(empty($group)){

            return 0;
        }

        //清除没有品牌的组
        foreach($group as $k=>$v){
            $res=M('BrandsAuth')->where("brands_id={$brand_id} and gid={$v['id']}")->find();
            if(empty($res)){
                unset($group[$k]);
            }else{
                $group_id .=$v['id'].',';
            }
        }

        if(empty($group_id)){
            return 0;
        }

        $group_id=trim($group_id,',');          //所有部门id
        $map['group_id']  = array('in',$group_id);
        $total_count=M('Total')->where($map)->select();//总数

        //处理它是哪个53账号下的公司
        $len=strpos($worker_id,'kf');
        $gongid=substr($worker_id,0,$len+2);
        foreach($total_count as $k=>$v){
            if(strpos($v['account_numbe'],$gongid) ===false){
                unset($total_count[$k]);
            }
        }

        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
        foreach($total_count as $key=>$val){
            $group_total=M('Resource')
                ->field('count(*) as num')
                ->where("group_id={$val['group_id']} and addtime  between {$startDay} and {$endDay}")
                ->select();
            if($group_total[0]['num'] >= $val['total']){

                unset($total_count[$key]);
            }else{
                $total_count[$key]['num']=$group_total[0]['num'];
            }

        }
        //总数都满了
        if(empty($total_count)){
            return 0;
        }

        //品牌超出 删除
        $arr=array();//所属组 今日的资源数量
        foreach($total_count as $key=>$val){
            //今天这个品牌的数量
            $count=$this->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")->count();
            $arr[$val['group_id']]=$count+$val['num'];//品牌数+今日资源总数
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

            $total +=$val['count']+$arr[$val['gid']];//这个品牌总分配数+已分配的
        }

        if(empty($arr)){

            return 0;
        }
        $gid=$this->getGid($arr,$total);

        return $gid;

    }

    /*
     * 获取来源渠道和品牌
     * */
    public function brands_source($data)
    {
        //来源渠道
        $talk_page=$data['talk_page'];
        $res=parse_url($talk_page);


        $host=$res['host'];//来源url
        $path=trim($res['path'],'/');//品牌标识

        $source='';
        $brand_id='';
        $arr=array('1'=>'PC',2=>'移动',3=>'微信');
        $referer=M('Referer')->select();
        if(!empty($referer)){
            foreach($referer as $key=>$val){
                if(stripos($val['url'],$host) !== false){
                    $source=$val['title'];
                }
            }
        }

        if(empty($source)){
            $source=$data['se'];
        }

        $brand=M('Brands')->select();
        foreach($brand as $key=>$val){
            $arrFy=explode(',',$val['identify']);
            /*if(stripos($val['identify'],$path) !== false){
                $brand_id=$val['id'];
            }*/
            if(in_array($path,$arrFy)){
                $brand_id=$val['id'];
            }

        }

        if(empty($brand_id)){
            foreach($brand as $key=>$val){
                $pos=strpos($data['kw'],$val['name']);
                if($pos !== false){
                    $brand_id=$val['id'];
                }
            }
        }

        $device=$arr[$data['device']];
        if(empty($source))$source ='';
        if(empty($brand_id))$brand_id ='';
        if(empty($device))$device ='';

        return array('source'=>$source.$device,'brand_id'=>$brand_id);

    }

    /*
     * 获取地区和省份
     * */
    public function getArea($guest_area)
    {
        $guest_area=mb_substr($guest_area,0,2,'UTF-8');//访客所在省份，（查询所在区域）

        $map['name']=array('like',array("%{$guest_area}%"));
        $res=M('Province')->where($map)->find();
        return $res;
    }

    /*
     * 获取品牌id
     * @param $keywork 关键字
     * @param $talk_page 咨询地址
     * */
    public function getBrandId($keywork,$talk_page)
    {
        $brand=M('Brands')->select();
        foreach($brand as $key=>$val){
            $pos=strpos($keywork,$val['name']);
            if($pos !== false){
                return $val['id'];
            }
        }

        return 0;
    }

    /*
     * 今日，当月资源汇总
     * @param $group_id  所属组id
     * */
    public function summary($group_id)
    {
        $total=M('Total')->where("group_id={$group_id}")->find();
        $totalNum=isset($total['total']) ? $total['total']:0;//今日总数量

        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

        $feedback=$this->field("count(*) as total,count( case status when  0 then status end ) as num1,count( case status when 1 then status end ) as num2,
        count( case status when 2 then status end ) as num3")
            ->where("group_id={$group_id} and  addtime between  {$startDay} and {$endDay}")
            ->find();




        //当月
        $firstday =mktime(0, 0, 0, date('m'), 1);
        $lastday = mktime(0, 0, 0,date('m')+1,1)-1;

        $data=$this->field("count(*) as total,count( case status when  0 then status end ) as num1,count( case status when 1 then status end ) as num2,
        count( case status when 2 then status end ) as num3")
            ->where("group_id={$group_id} and  addtime between  {$firstday} and {$lastday}")
            ->find();
        if(!empty($data)){
            $month=array(
                'todayMonth'=>$data['total'],
                'num1'      =>$data['num1'],
                'num2'      =>$data['num2'],
                'num3'      =>$data['num3']

            );
        }

        if(!empty($feedback)){
            $today=array(
                'totalNum'  =>$totalNum,
                'todayTotal'=>$feedback['total'],
                'num1'      =>$feedback['num1'],
                'num2'      =>$feedback['num2'],
                'num3'      =>$feedback['num3']
            );
        }

        return array('today'=>$today,'month'=>$month);
    }

    /*
     * 获取公司各部门汇总信息 （昨天比，上周比）
     * @date 2017-11-16 13:46
     * */
    public function getSummary()
    {
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $endDay=mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));

        $lastDay=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
        $endlastDay=mktime(date('H'),date('i'),date('s'),date('m'),date('d')-1,date('Y'));

        //$lastweekStart=mktime(0, 0 , 0,date("m"),date("d")-date("w")+1-7,date("Y"));
        $lastweekStart=mktime(0, 0 , 0,date("m"),date("d")-7,date("Y"));
        $lastweekEnd=mktime(date('H'),date('i'),date('s'),date("m"),date("d")-7,date("Y"));

        //$thisweekStart=mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
        $thisweekStart=mktime(0, 0 , 0,date("m"),date("d"),date("Y"));
        $thisweekEnd=mktime(date('H'),date('i'),date('s'),date("m"),date("d"),date("Y"));

        $data=$this->alias('r')
            ->field("r.group_id,t.total,count(case  when r.addtime >= {$startDay} and r.addtime  <= {$endDay} then r.id end	) as today,
                count(case  when r.addtime >= {$lastDay} and r.addtime  <= {$endlastDay} then r.id end	) as yesterday,
                count(case  when r.addtime >= {$lastweekStart} and r.addtime  <= {$lastweekEnd} then r.id end	) as lastweek,
                count(case  when r.addtime >= {$thisweekStart} and r.addtime  <= {$thisweekEnd} then r.id end	) as thisweek,
                count(case when r.source='SEO优化' and r.addtime >= {$startDay} and r.addtime <= {$endDay}  then r.id end	) as seo,
                count(case when r.source='新媒体' and r.addtime >= {$startDay} and r.addtime <= {$endDay}  then r.id end	) as xinmeiti,
                count(case when r.source='中国加盟网' and r.addtime >= {$startDay} and r.addtime <= {$endDay}  then r.id end	) as jiameng"
            )
            ->join("left join bt_total as t on t.group_id=r.group_id")
            ->where('r.group_id > 0')
            ->group('r.group_id,t.total')
            ->select();

        $array=array();
        if(!empty($data)){
            foreach($data as $key=>$val){
                $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();

                if(!empty($res)){
                    $parent=M('RoleDepartment')->where("id={$res['parent_id']}")->find();
                    if(!empty($parent)){
                        $array[$parent['id']]['company']=$parent['name'];
                    }
                }
                if(!empty($array[$res['parent_id']])){
                    $array[$res['parent_id']]['data'][]=array_merge($res,$data[$key]);
                }

            }
        }

        return $array;
    }

}