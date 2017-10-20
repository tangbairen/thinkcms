<?php
    header('Content-type:text/html;charset=utf-8');
    error_reporting(0);
    set_time_limit(0);
    require('./Visitor.class.php');
    $content=$_POST;

    if($_POST){
        sleep(1);
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


    }

    $data= array('cmd'=>'OK','token'=>'TOKEN');
    echo json_encode($data);