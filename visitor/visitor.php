<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    require('./Visitor.class.php');

    /*
    $mysql=new MMysql(array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    ));
    $arr=array('content'=>json_encode($_POST));
    $id=$mysql->insert('bt_content',$arr);*/
    $content=$_POST;
    if($_GET){
        file_get_contents('../Uploads/get.txt',json_encode($_GET));
    }
    file_put_contents("../Uploads/log/visitor.txt", $content);

    $cont=file_get_contents('../Uploads/log/visitor.txt');

    $strData=@urldecode($cont);
    $len=strripos($strData,'}');
    $result=substr($strData, 0,$len+1);

    $data=json_decode($result,true);

    $visitor=new Visitor();
    $count=$visitor->getmaxdim($data);
    if($count == 1 ){//一维（访客信息）
        $cmd=isset($data['cmd']) ? $data['cmd']:'';
        if($cmd == 'customer'){//是否为推送访客信息 命令
            $visitor->addInfo($data);
        }

    }else{//多维（访客聊天记录）
        $message=isset($data['message']) ? $data['message'] : '';
        $session=isset($data['session']) ? $data['session'] : '';
        $message=isset($data['end']) ? $data['end'] : '';
        if($message && $session && $message){
            $visitor->addRecord($data);
        }

    }

    file_put_contents("../Uploads/log/content.txt", $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);