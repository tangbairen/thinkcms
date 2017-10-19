<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    set_time_limit(0);
    require('./Visitor.class.php');

    if($_POST){

        $content=$_POST;
        /*file_put_contents("../Uploads/log/visitor.txt", $content);

        $cont=file_get_contents('../Uploads/log/visitor.txt');*/
        if(!empty($content)){
            file_put_contents("../Uploads/log/11111.txt", $content);
            $strData=@urldecode($content);
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
                file_put_contents("../Uploads/log/12222.txt", json_encode($data));
                $message=isset($data['message']) ? $data['message'] : '';
                $session=isset($data['session']) ? $data['session'] : '';
                $message=isset($data['end']) ? $data['end'] : '';
                if($message && $session && $message){
                    $visitor->addRecord($data);
                }

            }
        }

        file_put_contents("../Uploads/log/content.txt", $content);
    }

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);