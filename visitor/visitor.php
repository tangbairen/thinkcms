<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    require('./Visitor.class.php');

    $content=$_POST;
    $strData=@urldecode($content);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();

    if(count($data) == count($data,1)){//一维（访客信息）

        $visitor->addInfo($data);

    }else{//二维（访客聊天记录）
        $visitor->addRecord($data);
    }


    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);