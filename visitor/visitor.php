<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    set_time_limit(0);
    require('./Visitor.class.php');

    if($_POST){

        $visitor=new Visitor();
        $cmd=isset($_POST['cmd']) ? $_POST['cmd'] : '';
        if($cmd == 'talk_info'){//整体推送
            $content=urldecode($_POST['content']);

            $visitor->addRecord(json_decode($content,true));
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



        /*if(!empty($content)){
            file_put_contents("../Uploads/log/visitor.txt", $content);

            $cont=file_get_contents('../Uploads/log/visitor.txt');
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

                $message=isset($data['message']) ? $data['message'] : '';
                $session=isset($data['session']) ? $data['session'] : '';
                $message=isset($data['end']) ? $data['end'] : '';
                if($message && $session && $message){
                    $visitor->addRecord($data);
                }

            }
        }*/
        $content=$_POST;
        file_put_contents("../Uploads/log/content.txt", $content);
    }

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);