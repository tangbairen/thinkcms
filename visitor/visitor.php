<?php
    /*header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    set_time_limit(0);*/
    header('content-type:text/html; charset=utf-8');
    //开启所有的错误报告
    error_reporting(-1);
    set_time_limit(180);
    //设置时区
    ini_set('date.timezone', 'PRC');
    //禁用页面显示错误
    ini_set('display_errors', 0);
    //开启日志记录功能
    ini_set('log_errors', 1);
    //设置错误日志保存的位置
    ini_set('error_log', '../Uploads/log/error.log');
    //忽略重复的错误
//    ini_set('ignore_repeated_errors', 'on');
    //忽略重复的错误来源
//    ini_set('ignore_repeated_source', 'on');


    if($_POST){
        require('./Visitor.class.php');
        sleep(0.5);
        $visitor=new Visitor();
        $cmd=isset($_POST['cmd']) ? $_POST['cmd'] : '';
        if($cmd == 'talk_info'){//整体推送
            $content=isset($_POST['content'])? urldecode($_POST['content']) : '';
            $data=json_decode($content,true);

            if(!empty($data)){
                $visitor->addRecord($data);
            }

        }else{
            //访客信息推送
            $customer=isset($_POST['content'])? urldecode($_POST['content']) : '';
            $customer=json_decode($customer,true);
            if(!empty($customer)){
                $cmd=isset($customer['cmd']) ? $customer['cmd'] : '';
                if($cmd == 'customer'){
                    $visitor->addInfo($customer);
                }

            }

        }


    }

    file_put_contents('../Uploads/log/end.txt','122211');
    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);