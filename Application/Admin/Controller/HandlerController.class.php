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
            $repeatArray=M('Import')->query("select phone,count(*) as count from bt_resource group by phone having count>1");
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

                    if(!empty($repeatArray)){
                        foreach($repeatArray as $k=>$v){
                            if($val['phone'] == $v['phone']){
                                $val['repeart']='重复';
                            }else{
                                $val['repeart']='';
                            }
                        }
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
        $username   =isset($data[1]) ? $data[1]:'';
        $address    =isset($data[2]) ? $data[2]:'';
        $group      =$data[3];
        $phone      =isset($data[4]) ? $data[4]:'';
        $chats      =isset($data[5]) ? $data[5]:'';
        $source     =isset($data[6]) ? $data[6]:'';//渠道
        $keyword    =isset($data[7]) ? $data[7]:'';

        if(!empty($phone) || !empty($chats)){
            $model=D('Resource');
            $area=$model->getArea($address);//获取品牌id

            if($area){
                $province=$area['id'];//省份id
                $area_id=$area['area_id'];//区域id
            }else{
                $province=0;
                $area_id=0;
            }

            $brand_id=$this->getBrandId($keyword);//品牌id
            $group_id=$model->allocationGroup($brand_id,$area_id);//部门id

            if($group_id > 0){
                $status=2;
            }else{
                $status=1;
            }

            $map['number_id']       =$number_id;
            $map['custormer_info']  =$kefu_id;
            $map['username']        =$username;
            $map['phone']           =$phone;
            $map['chats']           =$chats;
            $map['brand_id']        =$brand_id;
            $map['area_id']         =$area_id;
            $map['group_id']        =$group_id;
            $map['province']        =$province;
            $map['source']          =$source;
            $map['keywork']         =$keyword;
            $map['status']          =$status;
            $map['time']            =time();

            M('Import')->add($map);

        }



        return true;
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
            $number_id=I('post.number_id','');
            if(empty($number_id)) throw new Exception('数据有误，请刷新重试！');

            $importData=M('Import')->where('number_id='.$number_id)->select();
            if(empty($importData)) throw new Exception('操作失败，请刷新后重试！');
            $time=time();
            $sql='install into bt_resource (`id`,`username`,`customer_info`,`phone`,`brand_id`,`area_id`,`group_id`,`source`,`province`
                ,`chats`,`keyword`,`service_number`,`addtime`) values ';
            foreach($importData as $key=>$val){
                $sql .="({$val['id']},'{$val['username']}','{$val['custormer_info']}','{$val['phone']}',{$val['brand_id']},
                {$val['area_id']}),{$val['group_id']},'{$val['source']}',{$val['province']},'{$val['chats']}','{$val['keyword']}',
                '{$val['service_number']}',{$time} )";
            }

            $res=M('Resource')->query($sql);

            if(empty($res)) throw new Exception('添加失败');

            $data=array('status'=>'success','message'=>'成功导入了'.count($importData).'条数据');

            $this->ajaxReturn($data);

        }catch (Exception $e){

            $message=$e->getMessage();
            $data=array('status'=>'error','message'=>$message);
            $this->ajaxReturn($data);
        }
    }

}