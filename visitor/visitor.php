<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(1);
    require('./Visitor.class.php');
    $mysql=new MMysql(array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    ));

    var_dump($mysql);
    exit;
    $content=$_POST;
    $strData=@urldecode($content);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();
    require('./MMysql.class.php');

    if(count($data) == count($data,1)){//一维（访客信息）

        $visitor->addInfo($data);

    }else{//二维（访客聊天记录）
        $visitor->addRecord($data);
    }

    $time=date('Y-m-d H:i:s',time());
    file_put_contents("../Uploads/log/".$time.'.txt', $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);