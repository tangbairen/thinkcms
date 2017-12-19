<?php
namespace Admin\Controller;

use Common\Controller\AdminBaseController;
use Think\Exception;

/*
 * 数据总来源
 * */
class ResourceController extends AdminBaseController
{
    /*
     * 数据总列表
     * */
    public function index()
    {
            $data=D('Resource')->selectData();
            //部门
            $group=M('RoleDepartment')->select();
            $phone=I('get.phone');
            $s_group=I('get.group');
            $start_time=I('get.start_time','');
            $end_time=I('get.end_time','');
            $allocation=I('get.allocation','');
            $brand_id=I('get.brand','');
            $referer_id=I('get.referer','');

            $brand=M('Brands')->select();//品牌
            $referer=M('Referer')->field('distinct title')->select();//来源渠道

            $array=array(
                'phone'=>$phone,
                's_group'=>$s_group,
                'start_time'=>$start_time,
                'end_time'=>$end_time,
                'allocation'=>$allocation,
                'brand'=>$brand,
                'brand_id'=>$brand_id,
                'referer_id'=>$referer_id,
                'referer'=>$referer
            );
            $this->assign($array);
            $this->assign('group',$group);
            $this->assign($data);// 赋值数据集


            $this->display();
    }

    /*
     * 导出总数据
     * */
    public function totalExport()
    {
        $where =1;
        $phone=trim(I('get.phone',''));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $allocation=I('get.allocation','');
        $brand_id=I('get.brand','');
        $referer_id=I('get.referer','');
        if(!empty($phone)){
            //$where .=" and phone={$phone}";
            $where .=" and phone like '%{$phone}%' or chats like '%{$phone}%'";
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

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
        }

        if(!empty($brand)){
            $where .=" and brand_id={$brand}";
        }

        if(!empty($referer)){
            $where .=" and source like '{$referer}%'";
        }

        $field=['addtime','customer_info','province','address','username',
            'phone','chats','source','brand_id','group_id','keyword','service_number','types','allocation','status','company','update_time','assistant','confirm_address','remark'];

        $data=D('Resource')->exportData($field,$where);


        $header=['时间','客服ID','省份','	地址','客户姓名','电话号码','QQ/微信','来源渠道','品牌','所属组','关键字','53账号','添加类型','是否分配','是否可跟','公司名称','回访时间','回访人','确认地址','备注信息'];
        export($header,$data);
    }


    /*
     * 查询数据
     * @param $field array [导出的字段]
     * @param $where array or string [条件]
     * @param $order string [排序]
     * */
    public function comment_export($field,$where=1,$order="addtime desc")
    {
        $data=M('Resource')
            ->field($field)
            ->where($where)
            ->order($order)
            ->select();
        return $data;
    }

    /*
     * 数据列表（客服）
     * */
    public function customer()
    {

        $data=D('Resource')->selectData();
            //部门
        $group=M('RoleDepartment')->select();
        $phone=I('get.phone');
        $s_group=I('get.group');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $brand_id=I('get.brand','');
        $referer_id=I('get.referer','');

        $allocation=I('get.allocation','');

        $brand=M('Brands')->select();//品牌
        $referer=M('Referer')->field('distinct title')->select();//来源渠道

        $array=array(
            'phone'=>$phone,
            's_group'=>$s_group,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'allocation'=>$allocation,
            'brand'=>$brand,
            'brand_id'=>$brand_id,
            'referer_id'=>$referer_id,
            'referer'=>$referer
        );

        $this->assign($array);
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集
        $this->display();
    }

    /*
     * 客服导出数据
     * */
    public function customerExport()
    {
        $where =1;
        $phone=trim(I('get.phone',''));
        $s_group=I('get.group','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $allocation=I('get.allocation','');
        $box=I('get.box','');
        $brand=I('get.brand','');
        $referer=I('get.referer','');

        if(!empty($box)){
            $where .=" and id in({$box})";
        }

        if(!empty($phone)){
            //$where .=" and phone={$phone}";
            $where .=" and phone like '%{$phone}%' or chats like '%{$phone}%'";
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

        if(!empty($allocation)){
            $where .=" and allocation={$allocation}";
        }
        if(!empty($brand)){
            $where .=" and brand_id={$brand}";
        }

        if(!empty($referer)){
            $where .=" and source like '{$referer}%'";
        }

        $field=['addtime','customer_info','province','address','username',
            'phone','chats','source','brand_id','group_id','keyword','service_number','types','allocation'];

        $data=D('Resource')->exportData($field,$where);


        $header=['时间','客服ID','省份','	地址','客户姓名','电话号码','QQ/微信','来源渠道','品牌','所属组','关键字','53账号','添加类型','是否分配'];
        export($header,$data);
    }

    /*
     * 数据审核导出
     * */
    public function auditExport()
    {
        $uid=session('user.id');
//        $group=M('AuthGroupAccess')->where("uid=$uid")->find();
        //$group=M('Users')->where("id=$uid")->find();

        $group=M('Users')->where("id=$uid")->find();
        if($group['level'] == 3){//公司账号
            $sql='select GROUP_CONCAT(id) as id from bt_role_department where parent_id='.$group['department_id'];
            $res=M()->query($sql);
            $id=isset($res[0]['id']) ? $res[0]['id'] : 0;

            $where="group_id in({$id})";
        }else{

//            $where="group_id = {$group['department_id']}";
            //查看三天的数据
            $start=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
            $end=time();
            $where="group_id = {$group['department_id']} and addtime between {$start} and {$end} ";
        }
        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
//        $where="group_id = {$group['department_id']}";
        $box=I('get.box','');
        $brand=I('get.brand','');
        $referer=I('get.referer','');
        $status=I('get.status','');

        if(!empty($box)){
            $where .=" and id in({$box})";
        }

        if(!empty($phone)){
            $where .=" and phone={$phone}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and addtime >={$start_time}";
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where .=" and addtime <={$end_time}";
        }

        if(!empty($brand)){
            $where .=" and brand_id={$brand}";
        }

        if(!empty($referer)){
            $where .=" and source like '{$referer}%'";
        }
        /*if(!empty($status)){
            $where .=" and status={$status}";
        }*/

        if(!empty($status) && $status == 3){
            $where .=" and status=0";
        }else if(!empty($status)){
            $where .=" and status={$status}";
        }

        $field=['addtime','customer_info','province','address','username',
            'phone','chats','source','brand_id','group_id','keyword','types','allocation','status','company','update_time','assistant','confirm_address','remark'];
        $header=['时间','客服ID','省份','	地址','客户姓名','电话号码','QQ/微信','来源渠道','品牌','所属组','关键字','添加类型','是否分配','是否可跟','公司名称','回访时间','回访人','确认地址','备注信息'];


        $data=D('Resource')->exportData($field,$where);

        export($header,$data);


    }

    public function delete()
    {
        try{
            $id=I('get.id');
            if(empty($id)) throw new Exception('数据不存在');

            $count=M('Resource')->where("id={$id}")->find();
            if(!$count) throw new Exception('数据不存在');

            $res=M('Resource')->where("id={$id}")->delete();
            if(!$res) throw new Exception('删除失败');

            $this->success('删除成功');

        }catch(Exception $e){

            $message=$e->getMessage();
            $this->error($message);
        }

    }

    /*
     * 修改数据（客服的数据）
     * */
    public function modify()
    {
        if(IS_POST){

            $res=D('Resource')->edit();
            if($res){
                $this->success('修改成功',U('Admin/Resource/customer'));
            }else{
                $this->error('修改失败');
            }

        }else{

            try{
                $id=I('get.number')+0;
                if(empty($id)) throw new Exception('数据不存在');

                $data=M('Resource')->where("id={$id}")->find();
                if(empty($data)) throw new Exception('数据不存在');

                $group_name='';
                if($data['group_id'] > 0){
                    $group=M('RoleDepartment')->field('name')->where("id={$data['group_id']}")->find();
                    $group_name=$group;
                }

                $brand_name='';
                if($data['brand_id'] > 0){

                    $brand=M('Brands')->field('name')->where("id={$data['brand_id']}")->find();
                    $brand_name=$brand['name'];
                }

                /*//用户组
                $autGroup=M('AuthGroup')->select();*/
                //省份
                $province=M('Province')->select();
                //品牌
                $brandArr=M('Brands')->select();
                $array=array(
                    'group_name'=>$group_name['name'],
                    'brand_name'=>$brand_name,
//                    'autGroup'=>$autGroup,
                    'brandArr'=>$brandArr,
                    'province'=>$province,

                );
                $this->assign($array);
                $this->assign('data',$data);
                $this->display();

            }catch(Exception $e){

                $message=$e->getMessage();
                $this->error($message);
            }
        }

    }

    /*
     * 添加数据（客服添加）
     * */
    public function add_resource()
    {
        if(IS_POST){

            try{
                $res=D('Resource')->addData();
                if(empty($res)) throw new Exception('添加失败');

                $this->success('添加成功',U('Admin/Resource/customer'));
            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }


        }else{

            //省份
            $province=M('Province')->select();
            //品牌
            $brandArr=M('Brands')->order('order_by desc')->limit(45)->select();
            $array=array(
                'brandArr'=>$brandArr,
                'province'=>$province
            );

            $this->assign($array);
            $this->display();
        }
    }

    /*
     * 数据审核（对应的组，如科应组）
     * */
    public function audit()
    {
        $uid=session('user.id');
        $group=M('Users')->where("id=$uid")->find();
        if($group['level'] == 3){//公司账号
            $sql='select GROUP_CONCAT(id) as id from bt_role_department where parent_id='.$group['department_id'];
            $res=M()->query($sql);
            $id=isset($res[0]['id']) ? $res[0]['id'] : 0;
            $data=D('Resource')->bumenData("group_id in({$id}) ");
        }else{
            //查看三天的数据
            $start=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
            $end=time();
            $where="group_id = {$group['department_id']} and addtime between {$start} and {$end} ";
            $data=D('Resource')->selectData($where);
        }
        //所有组
        $group=M('AuthGroup')->select();
        $phone=I('get.phone');
        $s_group=I('get.group');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        $referer_id=I('get.referer','');
        $brand_id=I('get.brand','');
        $status=I('get.status','');
        $allocation=I('get.allocation','');

        $brand=M('Brands')->select();//品牌
        $referer=M('Referer')->field('distinct title')->select();//来源渠道

        $array=array(
            'phone'=>$phone,
            's_group'=>$s_group,
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'brand'=>$brand,
            'brand_id'=>$brand_id,
            'referer_id'=>$referer_id,
            'referer'=>$referer,
            'status'=>$status
        );
        $this->assign($array);
        $this->assign('group',$group);
        $this->assign($data);// 赋值数据集

        $this->display();
    }

    /*
     * 数据修改(组)是否可跟，回访人...
     * */
    public function group_modify()
    {
        try{

            $res=D('Resource')->groupModify();
            if(!$res) throw new Exception('修改失败');

            $this->success('修改成功',U('Admin/Resource/audit'));

        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }

    }



    private  function getExcel($fileName,$headArr,$data){
        //对数据进行检验
        if(empty($data) || !is_array($data)){
            die("data must be a array");
        }
        //检查文件名
        if(empty($fileName)){
            exit;
        }
        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";
        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }
        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }
        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        // $objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        ob_end_clean();
        ob_start();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;

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

    /*
     * 各部门资源情况统计
     * */
    public function group_total()
    {
        // 今日开始时间戳
        $startDay=mktime(0,0,0,date('m'),date('d'),date('Y'));
        // 减1 是少了一秒 ，不然就是第二天了  结束时间戳
        $endDay=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;

        $sql="select t.group_id,g.title,t.total ,(SELECT COUNT(*) FROM  bt_resource as r WHERE t.group_id=r.group_id and  r.addtime >={$startDay} and r.addtime <={$endDay} ) AS number
from bt_total as t left JOIN bt_auth_group as g on t.group_id=g.id
GROUP BY  t.group_id,t.total";
        $data=M()->query($sql);

        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 公司 各部门汇总
     * @data 2017-11-16 11：30
     * */
    public function summary()
    {
        $data=D('Resource')->getSummary();

        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 各部门获取最新的资源  (ajax)
     * @data 2017-11-17 14:56
     * */
    public function getnewdata()
    {
        $uid=session('user.id');
        $group=M('Users')->where("id=$uid")->find();//获取部门id
        $data=D('Resource')->where("group_id = {$group['department_id']} and status=0")->count();

        if($data > 0){
            $array=array('code'=>200,'message'=>$data);
        }else{
            $array=array('code'=>400,'message'=>'');
        }

        echo json_encode($array);
    }


    /*
     * 导入客户资源
     * @date: 2017-11-27 16:00
     * */
    public function importdata()
    {
        //省份
        $province=M('Province')->select();
        //品牌
        $brandArr=M('Brands')->order('order_by desc')->limit(30)->select();



        $this->assign('province',$province);
        $this->assign('brandArr',$brandArr);
        $this->display();
    }

}