<?php

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;


class KfinfoController extends Controller
{

    /*
     * bote 52
     * */
    public function bote()
    {
        try{
//            if(!IS_POST) throw new Exception('非法请求');
            //$aaa=$_POST;
            //$time=date('Y-m-d H:i:s',time()).'_'.rand();
            //file_put_contents("./Uploads/log/bote_".$time.'.txt', $aaa);

            //$ip = get_client_ip();
            //if($ip != '122.227.58.170')throw new Exception('非法请求');
            M()->startTrans();
            $cmd=I('post.cmd','talk_info');
            if($cmd == 'talk_info'){//整体推送
                $content=I('post.content','');
//                if(!empty($content)){
                    /*$content=urldecode($content);*/
                echo 111;
                $content='{"message":[{"worker_name":"","company_id":"72149307","msg_type":"p","id6d":"10217824","talk_id":"21123749209","worker_id":"ditiezhankf02@163.com","msg":"鎮ㄥソ锛岃闂偍鐢佃瘽澶氬皯?绋嶅悗鎶婁骇鍝佷环鏍笺€佷紭鎯犳斂绛栥€佸埄娑﹀垎鏋�,鍚堜綔娴佺▼绛夊彂鍒版偍鎵嬫満涓婏紝鎮ㄥ厛浜嗚В涓€涓嬪ソ鍚椼€�    ","msg_time":"20171104004133"}],"session":{"kw":"","company_id":"72149307","guest_area":"娌冲崡鐪佺劍浣滃競[绉婚€歖","land_page":"http://bdzh.im-royaltea.com/yidiandian-m/?bdclickid=bdmo_00334665&keyword=%e5%a6%82%e4%bd%95%e5%8a%a0%e7%9b%9f%e4%b8%80%e7%82%b9%e7%82%b9&semk=70882102318&semc=18524619414&semm=1&semp=mb1&sema=bj&semd=mo","guest_id":"10264600744008","talk_id":"21123749209","id6d":"10217824","guest_ip":"223.90.24.196","se":"Baidu","worker_name":null,"talk_type":"5","talk_page":"http://bdzh.im-royaltea.com/yidiandian-m/?bdclickid=bdmo_00334665&keyword=%e5%a6%82%e4%bd%95%e5%8a%a0%e7%9b%9f%e4%b8%80%e7%82%b9%e7%82%b9&semk=70882102318&semc=18524619414&semm=1&semp=mb1&sema=bj&semd=mo","device":"2","referer":"http://cpro.baidu.com/cpro/ui/uijs.php?en=mywWUA71T1Yknzu9TZKxpyfqn1DLPHcYn10LnBu9TZKxTv-b5yFbPjcdujfsFhPh5HDhmv6qnHbLnH6LPjRhuAbqniuGTdq9TZ0qniuJp1d9PWRLryN9nvwWPHwhPymdg1Dhp1Y-f16-wHT-fbD-fYR-fbn-wjn-f1n-fYc-wjc-fbc-fWR-wHn-fWR-wHnhp10qFRn3FRRLFRFKFRP7FRFjFRf1FRn1FRPaFRfzFRFaFRcdFRR1FRcdFRR1Fh_k5iNjPaNaraNDnzNKPaNafzNDnzNjnzNjfBNjniNKfzNjfBNAraNaPiN7fiuonWY-wjf-wHT-fbf-fYn-fbn-wjn-f1n-fYc-fbn-wjn-f1n-fYchp1nqFRnYFRuaFRn1FRPKFRc4FRDYFRcLFRFaFRFjFRf1FRn1FRPaFRcLFRfkFRcvFRRsFRn4FRf4Fh_Y5iNaraNjriNafBNAPiNafzNDnzNjnzNjfBNaPiN7fiuoPHY-fWD-wDn-fWT-wHT-fYn-f1D-fbn-wjn-f1n-fYchUZNopHYzFhdWTAYqnHmdPauk5yFbPjcdujfsgvPsTBuzmWYkFMF15HDhTvwogLmqPau1uAVxIhNzTv-EUWYdQWn8nau1uyk_ugFxpyfqnBu1pyfquWNhPHRYuAP9n1--PHI9PBu1IA-b5HmsnjDhIjdYTAP_pyPouyf1gvdEm-q9TLKxPiuYUgnqnHRsrHTzP1DYniuYIHYYP1mdPjfzFMRqpZwYTaR1fiRzwBRzwWwBuAcYmiRzwaRzwAFbPjcdujfsFHF7mvqVFMmqniuG5ycLrywBPHcs&adx=1&c=news&ctk=48746059e9e20004&fv=0&itm=1&kdi0=1&kdi1=1&kdi2=1&kdi3=1&kdi4=1&kdi5=1&lukid=2&mscf=701&n=10&nttp=3&p=baidu&ssp2=0&swi=0&tsf=dtp:2&u=&urlid=0&wi=4","worker_id":"ditiezhankf02@163.com","talk_time":"20171104004132"},"end":{"company_id":"72149307","end_time":"20171104004336","end_type":"3","talk_id":"21123749209"}}';
                    $data=json_decode($content,true);
                    D('VisitorRecord')->kfAddRecord($data);
//                }

            }else{
                //访客信息推送
                $customer=I('post.content','');
                if(!empty($customer)){
                    $customer=urldecode($customer);
                    $customer=json_decode($customer,true);
                    $cmd=isset($customer['cmd']) ? $customer['cmd'] : '';
                    if($cmd == 'customer'){
                        D('VisitorInfo')->addInfo($customer);
                    }
                }

            }
            M()->commit();
            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }catch(Exception $e){
            M()->rollback();
            $message=$e->getMessage();
            //file_put_contents('./Uploads/log/message.txt',$message);
            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }


    }

    /*
     * dietiezhan 53
     * */
    public function ditiezhan()
    {
        try{
            if(!IS_POST) throw new Exception('非法请求');
            //$aaa=$_POST;
            //$time=date('Y-m-d H:i:s',time()).'_'.rand();
            //file_put_contents("./Uploads/log/ditie_".$time.'.txt', $aaa);
            //$ip = get_client_ip();
            //if($ip != '122.227.58.170')throw new Exception('非法请求');
            M()->startTrans();
            $cmd=I('post.cmd','');
            //file_put_contents("./Uploads/log/ditiecmd_".$time.'.txt', $cmd);
            if($cmd == 'talk_info'){//整体推送
                $content=I('post.content','');
                if(!empty($content)){
                    $content=urldecode($content);
                    $data=json_decode($content,true);
                    D('VisitorRecord')->kfAddRecord($data);
                }

            }else{
                //访客信息推送
                $customer=I('post.content','');
                //file_put_contents("./Uploads/log/ditiectomer_".$time.'.txt', $customer);
                if(!empty($customer)){
                    $customer=urldecode($customer);
                    $customer=json_decode($customer,true);
                    $cmd=isset($customer['cmd']) ? $customer['cmd'] : '';
                    if($cmd == 'customer'){
                        D('VisitorInfo')->addInfo($customer);
                    }
                }

            }
            M()->commit();
            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }catch(Exception $e){
            M()->rollback();
            $message=$e->getMessage();
            //file_put_contents('./Uploads/log/ditie_message.txt',$message);
            $data= array('cmd'=>'OK','token'=>'TOKEN');
            echo json_encode($data);
        }


    }

}