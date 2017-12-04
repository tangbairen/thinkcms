<?php
namespace Admin\Controller;

use Think\Controller;

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
        $upload->savePath  =      './Uploads/excel/'; // 设置附件上传目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['myfile']);
        if(!$info) {
            // 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            $path=$info['savepath'].$info['savename'];
            $this->readExcel($path);

        }
    }

    //创建一个读取excel数据，可用于入库
    public function readExcel($path='002.xlsx')
    {
        if(!file_exists($path)){
            return false;
        }

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


        p($dataArray);
//        return $dataArray;
    }
}