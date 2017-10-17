<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    require('./Visitor.class.php');
    /*$mysql=new MMysql(array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    ));*/

    /*$content=$_POST;
    file_put_contents("../Uploads/file/visitor.txt", $content);

    $cont=file_get_contents('../Uploads/file/visitor.txt');

    $strData=@urldecode($cont);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();
    $count=$visitor->getmaxdim($data);
    if($count == 1 ){//一维（访客信息）
        file_put_contents("../Uploads/log/log222.txt", '123456');
        $visitor->addInfo($data);

    }else{//二维（访客聊天记录）
        file_put_contents("../Uploads/log/log.txt", '123456');
      */  $visitor->addRecord($data);
    }
    $time=date('Y-m-d H:i:s',time());
    file_put_contents("../Uploads/log/".$time.'.txt', $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);