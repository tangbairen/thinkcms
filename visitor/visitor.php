<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    require('./Visitor.class.php');

    $content='%7B%22guest_name%22%3A%22%E4%BB%98%E5%AE%B6%E5%A6%AE8771%2BT%2318720220716%22%2C%22email%22%3A%22%22%2C%22province%22%3A%22%22%2C%22city%22%3A%22%22%2C%22qq%22%3A%22%22%2C%22mobile%22%3A%22%22%2C%22address%22%3A%22%22%2C%22remark%22%3A%22%22%2C%22guest_id%22%3A%2210575296314018%22%2C%22zipcode%22%3A%22%22%2C%22worker_id%22%3A%22bote53kf08%40163.com%22%2C%22tag%22%3A%22%22%2C%22time%22%3A1508147949%2C%22company_id%22%3A%2272133840%22%2C%22cmd%22%3A%22customer%22%2C%22token%22%3A%22TOKEN%22%7D1794267d-98fb-41d5-8407-1ae2de465cb4';
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

    $time=date('Y-m-d H:i:s',time());
    file_put_contents("../Uploads/log/".$time.'.txt', $content);

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);