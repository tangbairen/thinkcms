<?php
namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

/*
 * 处理类
 * @date 2017-11-27
 * */
class HandlerController extends Controller
{
    /*
     * 接收上传的文件
     * */
    public function addExcel()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls','xlsx');// 设置附件上传类型
        $upload->savePath  =      './excel/'; // 设置附件上传目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['myfile']);

        try{

            if(!$info) {
                // 上传错误提示错误信息
                //$this->error($upload->getError());
                $message=$upload->getError();
                throw new Exception($message);

            }else{// 上传成功 获取上传文件信息
                $path='./Uploads/'.$info['savepath'].$info['savename'];

                $number_id=$this->readExcel($path);
            }
            $array=M('Import')->where('number_id='.$number_id)->select();
            //$repeatArray=M()->query("select phone,count(*) as count from bt_resource");
            if(!empty($array)){
                foreach($array as $key=>&$val){
                    if($val['group_id'] > 0){
                        $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                        $val['group_name']=$res['name'];
                        $val['fenpei']='已匹配';
                    }else{
                        $val['group_name']='';
                        $val['fenpei']='未匹配';
                    }
                    if($val['brand_id'] > 0){
                        $brands=M('Brands')->where("id={$val['brand_id']}")->find();
                        $val['brands_name']=$brands['name'];
                    }else{
                        $val['brands_name']='';
                    }
                    if($val['province'] > 0){

                        $province=M('Province')->where("id={$val['province']}")->find();

                        $val['province_name']=$province['name'];
                    }else{
                        $val['province_name']='';
                    }

                    if(!empty($val['phone'])){
                        $map['phone']=$val['phone'];
                        $map['brand_id']=$val['brand_id'];
                        $res=M('Resource')->where($map)->find();
                        $val['repeart']=!empty($res) ? '重复':'';
                    }
                }
            }

            $data=array('status'=>'success','data'=>$array,'number_id'=>$number_id);
            $this->ajaxReturn($data);

        }catch(Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);

            $this->ajaxReturn($data);
        }

    }

    //创建一个读取excel数据，可用于入库
    public function readExcel($path='002.xlsx')
    {

        /*if(!file_exists(__ROOT__.$path)){
            return false;
        }*/

        //引用PHPexcel 类
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        $type = 'Excel2007';//设置为Excel5代表支持2003或以下版本，Excel2007代表2007版

        $suffix=pathinfo($path, PATHINFO_EXTENSION);
        if ($suffix == 'xls') {
            //如果excel文件后缀名为.xls，导入这个类
            $xlsReader=\PHPExcel_IOFactory::createReader('Excel5');
        } elseif($suffix == 'xlsx') {
            //如果excel文件后缀名为.xlsx，导入这个类
            $xlsReader=\PHPExcel_IOFactory::createReader('Excel2007');
        }else{

        }

//        $xlsReader = \PHPExcel_IOFactory::createReader($type);
        /*$xlsReader->setReadDataOnly(true);
        $xlsReader->setLoadSheetsOnly(true);*/
        $Sheets = $xlsReader->load($path);
        //开始读取上传到服务器中的Excel文件，返回一个二维数组
        $result= $Sheets->getSheet(0);
        //取得最大的列号
        //$allColumn = $result->getHighestColumn();
        $allRow = $result->getHighestRow(); //行数
        $dataArray=$result->toArray();

        $this->existTitle($dataArray[0]);

        $number_id=date("YmdHis"). mt_rand(1,100);//15-16 位

        for($i=1;$i < count($dataArray);$i++){
            if(!empty($dataArray[$i])){
                $this->handlerData($dataArray[$i],$number_id);
            }
        }

        return $number_id;
    }

    /*
     * 处理数据入库
     * $data 一维数组
     * $number_id   这次入库的编号
     * */
    public function handlerData($data,$number_id)
    {
        $kefu_id    =isset($data[0]) ? $data[0]:'';
        $username   =isset($data[1]) ? trim($data[1]):'';
        $address    =isset($data[2]) ? trim($data[2]):'';
        $group      =isset($data[3]) ? trim($data[3]):'';
        $phone      =isset($data[4]) ? trim($data[4]):'';
        $chats      =isset($data[5]) ? trim($data[5]):'';
        $source     =isset($data[6]) ? trim($data[6]):'';//渠道
        $keyword    =isset($data[7]) ? trim($data[7]):'';
        $service_number    =isset($data[8]) ? trim($data[8]):'';

        if(!empty($phone) || !empty($chats)){
            $model=D('Resource');
            $area=array();
            if(!empty($address)){
                $area=$model->getArea($address);//获取省份，区域
            }

            if(!empty($area)){
                $province=$area['id'];//省份id
                $area_id=$area['area_id'];//区域id
            }else{
                $province=0;
                $area_id=0;
            }

            $brand_id=$this->getBrandId($keyword);//品牌id
            //获取部门
            $group_id=0;
            if(!empty($group)){
                $arr['name']=$group;
                $groupinfo=M('RoleDepartment')->where($arr)->find();

                if(!empty($groupinfo)){
                    $group_id=$groupinfo['id'];
                }
            }

            if(empty($group_id)){
                $group_id=$this->allocationGroup($brand_id,$area_id,$number_id);//部门id
            }

            $array=array('百度移动','百度PC','百度信息流','360移动','360PC','搜狗移动','搜狗PC','神马移动','SEO优化','新媒体','400','留言板','离线宝','中国加盟网');
            if(!in_array(trim($source),$array)){
                $source='';
            }

            $map['number_id']       =$number_id;
            $map['custormer_info']  =$kefu_id;
            $map['username']        =$username;
            $map['phone']           =substr($phone,0,13);
            $map['chats']           =$chats;
            $map['brand_id']        =$brand_id;
            $map['area_id']         =$area_id;
            $map['group_id']        =$group_id;
            $map['province']        =$province;
            $map['source']          =$source;
            $map['keywork']         =$keyword;
            $map['service_number']  =$service_number;
            $map['status']          =1;
            $map['addtime']            =time();

            M('Import')->add($map);

        }

        return true;
    }

    /*
     * 分配组
     * @param $brand_id [品牌id]
     * @param $area_id [地区id]
     * @param $number_id 本次操作编号
     * @return $group_id [用户组id]
     * */
    public function allocationGroup($brand_id,$area_id,$number_id)
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
            $count=M('Resource')->where("group_id={$val['group_id']} and brand_id={$brand_id} and addtime  between {$startDay} and {$endDay}")->count();
            $importCount=M('Import')->where("group_id={$val['group_id']} and number_id='{$number_id}'")->count();
            $arr[$val['group_id']]=$count+$val['num']+$importCount;//品牌数+今日资源总数
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
    public function getBrandId($keywork)
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
     * 判断表格 栏目标题是否合法
     * $array 一维数组
     * */
    public function existTitle($array)
    {
        if($array[0] !='客服ID'){
            throw new Exception('文件格式不正确');
        }

        if($array[1] !='客户姓名'){
            throw new Exception('文件格式不正确');
        }

        if($array[2] !='地区'){
            throw new Exception('文件格式不正确');
        }

        if($array[3] !='部门'){
            throw new Exception('文件格式不正确');
        }

        if($array[4] !='电话号码'){
            throw new Exception('文件格式不正确');
        }

        if($array[5] !='QQ/微信'){
            throw new Exception('文件格式不正确');
        }

        if($array[6] !='来源渠道'){
            throw new Exception('文件格式不正确');
        }

        if($array[7] !='关键字'){
            throw new Exception('文件格式不正确');
        }
        if($array[8] !='53账号'){
            throw new Exception('文件格式不正确');
        }

    }


    /*
     * 导入 ，获取品牌
     * */
    public function get_brand()
    {
        $get_province=I('get.get_brand','');

        $array['name']=array('like',"%$get_province%");
        $brandArr=M('Brands')->field('id,name')
            ->where($array)
            ->select();
        if(empty($brandArr)){
            $data=array('code'=>400,'data'=>'');
        }else{
            $data=array('code'=>200,'data'=>$brandArr);
        }
        $this->ajaxReturn($data);
    }

    /*
     * 同步到资源表中
     * */
    public function adddata()
    {
        try{
            if(!IS_POST) throw new Exception('非法操作');
            $number_id=I('post.number_id',0);

            if(empty($number_id)) throw new Exception('数据有误，请刷新重试！');
            $map['number_id']=$number_id;
            $map['status']=1;
            $importData=M('Import')->where($map)->select();

            if(empty($importData)) throw new Exception('操作失败，请刷新后重试！');
            $time=time();
            $sql="insert into bt_resource (`id`,`username`,`customer_info`,`phone`,`brand_id`,`area_id`,`group_id`,`source`,`province`,`chats`,`keyword`,`service_number`,`addtime`,`allocation`) values ";
            foreach($importData as $key=>$val){
                if(empty($val['group_id'])){
                    $allocation=1;
                }else{
                    $allocation=2;
                }
                $sql .="(null,'{$val['username']}','{$val['custormer_info']}','{$val['phone']}',{$val['brand_id']},{$val['area_id']},{$val['group_id']},'{$val['source']}',{$val['province']},'{$val['chats']}','{$val['keywork']}','{$val['service_number']}',{$time},{$allocation} ),";
            }
            $sql=rtrim($sql,',');
            $sql=rtrim($sql,'"');

            $res=M()->execute($sql);
            if(empty($res)) throw new Exception('添加失败');
            M('Import')->where('number_id='.$number_id)->save(array('status'=>1));

            $data=array('status'=>'success','message'=>'成功导入了'.count($importData).'条数据');

            $this->ajaxReturn($data);

        }catch (Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }
    }

    public function del()
    {
        try{

            $number=I('post.number');
            if(empty($number)) throw new Exception('删除失败');

            $res=M('Import')->where("import_id=".$number)->delete();

            if(empty($res)) throw new Exception('删除失败');

            $data=array('status'=>'success','message'=>'删除成功');
            $this->ajaxReturn($data);
        }catch(Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }

    }

    /*
     * 修改导入数据
     * */
    public function modity()
    {
        try{

            if(!IS_POST) throw new Exception('非法请求');

            $import_id              =empty(I('post.import_id')) ? 0: I('post.import_id');
            $map['username']        =empty(I('post.username')) ? '': I('post.username');
            $map['phone']           =empty(I('post.phone')) ? '':I('post.phone');
            $map['service_number']  =empty(I('post.service_number')) ? '':I('post.service_number');
            $map['source']          =empty(I('post.source')) ? '':I('post.source');
            $map['province']        =empty(I('post.province')) ? 0:I('post.province');
            $map['brand_id']        =empty(I('post.brand')) ? 0:I('post.brand');
            $map['group_id']        =empty(I('post.group')) ? 0:I('post.group');

            $res=M('Province')->where("id=".$map['province'])->find();
            if(empty($res)){
                $map['area_id']     =0;
            }else{
                $map['area_id']     =$res['area_id'];
            }

            $res=M('Import')->where("import_id=".$import_id)->save($map);
            if(empty($res)) throw new Exception('修改失败');

            $data=array('status'=>'success','message'=>'修改成功');
            $this->ajaxReturn($data);
        }catch(Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }
    }

    /*
     * 获取导入数据
     * */
    public function getdatainfo()
    {

        $number_id=I('post.number_id');
        $array=M('Import')->where('number_id='.$number_id)->select();
//        $repeatArray=M()->query("select phone,count(*) as count from bt_resource");
        if(!empty($array)){
            foreach($array as $key=>&$val){
                if($val['group_id'] > 0){
                    $res=M('RoleDepartment')->where("id={$val['group_id']}")->find();
                    $val['group_name']=$res['name'];
                    $val['fenpei']='已匹配';
                }else{
                    $val['group_name']='';
                    $val['fenpei']='未匹配';
                }
                if($val['brand_id'] > 0){
                    $brands=M('Brands')->where("id={$val['brand_id']}")->find();
                    $val['brands_name']=$brands['name'];
                }else{
                    $val['brands_name']='';
                }
                if($val['province'] > 0){

                    $province=M('Province')->where("id={$val['province']}")->find();

                    $val['province_name']=$province['name'];
                }else{
                    $val['province_name']='';
                }

                if(!empty($val['phone'])){
                    $map['phone']=$val['phone'];
                    $map['brand_id']=$val['brand_id'];
                    $res=M('Resource')->where($map)->find();
                    $val['repeart']=!empty($res) ? '重复':'';
                }
            }
        }

        $data=array('status'=>'success','data'=>$array,'number_id'=>$number_id);
        $this->ajaxReturn($data);
    }

    /*
     * 查询添加的资源是否重复，
     * 条件：品牌，手机号 ，QQ，微信号
     * */
    public function getrepeat()
    {
        try{

            if(!IS_AJAX) throw new Exception('非法请求');
            $brand_id=empty(I('get.brand_id')) ? 0 : I('get.brand_id');
            $phone=empty(I('get.phone')) ? '' : trim(I('get.phone'));
            $chats=empty(I('get.chats')) ? '' : I('get.chats');
            if(!empty($phone)){
                $res=M('Resource')->where("brand_id={$brand_id} and phone='{$phone}'")->order('addtime desc')->select();
            }else{
                $res=M('Resource')->where("brand_id={$brand_id} and chats='{$chats}'")->order('addtime desc')->select();
            }

            if(empty($res)) throw new Exception('允许添加');
            $li='该资源信息重复，如下：<br>';
            foreach($res as $key=>$val){
                $group=M('RoleDepartment')->where("id=".$val['group_id'])->find();
                $brand=M('Brands')->where("id=".$val['brand_id'])->find();
                $li .=$group['name'].' : '.$brand['name'].'  '.date('Y-m-d H:i',$val['addtime']).' '.$val['source'].'<br>';
            }
            $data=array('status'=>'success','message'=>'信息已经存在','data'=>$li);
            $this->ajaxReturn($data);
        }catch(Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }
    }

    /*
     * 获取单条导入信息
     * */
    public function getimport()
    {
        try{

            if(!IS_AJAX) throw new Exception('非法请求');
            $import_id=empty(I('post.import_id')) ? 0:I('post.import_id');

            $dataArray=M('Import')->where("import_id=".$import_id)->find();
            if(empty($dataArray)) throw new Exception('数据不存在');



            $data=array('status'=>'success','data'=>$dataArray);
            $this->ajaxReturn($data);
        }catch(Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }
    }

    /*
     * 根据省份和品牌分析所属的组
     * */
    public function group()
    {
        $province_id=I('get.province',0);
        $brand_id=I('get.brand_id',0);

        //选择区域id  得到区域id
        $province=M('Province')->where("id={$province_id}")->find();
        //组
        //$group=M('AuthGroup')->field('id,title,area_id')->select();
        //部门
        $group=M('RoleDepartment')->order('parent_id')->select();
        foreach($group as $key=>$val){
            $arr=explode(',',$val['area_id']);
            if(!in_array($province['area_id'],$arr)){
                unset($group[$key]);
            }
        }

        foreach($group as $k=>$v){
            $res=M('BrandsAuth')->where("brands_id={$brand_id} and gid={$v['id']}")->find();
            if(empty($res)){
                unset($group[$k]);
            }
        }
        foreach($group as $kk=>$vv){
            $res=M('Total')->where("group_id={$vv['id']} and total > 0")->find();
            if(empty($res)){
                unset($group[$kk]);
            }else{
                // 今日开始时间戳
                $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
                // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
                $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                $group_total=M('Resource')
                    ->field('count(*) as num')
                    ->where("group_id={$vv['id']} and addtime  between {$startDay} and {$endDay}")
                    ->find();
                if($group_total['num'] >= $res['total']){
                    unset($group[$kk]);
                }

            }
        }

        $this->ajaxReturn($group);
    }


}