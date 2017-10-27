<?php
namespace Admin\Controller;

use Think\Controller;

/*
 * 定时任务
 * */
class CrontabController extends Controller
{
    /*
     * 分配资源
     * 如果访客信息表有数据，匹配记录表，把它合并到资源表中
     * 当前时间 到 前一个小时的数据
     * */
    public function allot()
    {
        $ip = get_client_ip();
        if($ip != '47.52.59.51'){

            return false;
        }

        $time=time();//当前时间
        $beterTime=$time - (3600*24);//前一天的时间

        $map['status']=1;
        $map['time']=array('between',array($beterTime,$time));
        $infoData=M('VisitorInfo')
            ->field('id,guest_id,guest_name,worker_id,status')
            ->where($map)
            ->select();

        if(!empty($infoData)){
            $this->addResource($infoData);//匹配，分配
        }
    }

    public function addResource($infoData)
    {
        foreach($infoData as $key=>$val){
            D('Resource')->handler($infoData[$key],$val['guest_name'],$val['guest_id']);
        }

        return true;
    }


    /*
     * 53kf bote 获取失败消息
     *
     * */
    public function getbote()
    {

        $toten=$this->getBoteToken();
        $url='http://api.saas.53kf.com/push';
        $post_data = array(
            "app_id" => "19822FCB",
            "cmd" => "unsent_message",
            "53kf_token" =>$toten
        );
        echo $toten;
        $content=$this->getCurl($url,$post_data);

        file_put_contents('./Uploads/log/mess01.txt',$content);
        //显示获得的数据

        $data=json_decode($content,true);

        dump($data);

        $cmd=isset($data['cmd']) ? $data['cmd'] : '';

        if($cmd != 'error'){
            file_put_contents('./Uploads/log/bote1.txt',$content);
            array_pop($data);
            foreach($data as $ke=>$val){
                $result=json_decode(urldecode($val),true);
                $count=getmaxdim($result);
                if($count > 1){//整体推送
                    D('VisitorRecord')->kfAddRecord($result);
                }else{//客户信息

                    $cmd=isset($result['cmd']) ? $result['cmd'] : '';
                    if($cmd == 'customer'){
                        D('VisitorInfo')->addInfo($result);
                    }
                }

            }

        }

        return json_encode(array('code'=>200,'message'=>'获取成功'));

    }

    /*
     * 53kf ditie 获取失败消息
     *
     * */
    public function getditie()
    {

        $toten=$this->getToken();
        $url='http://api.saas.53kf.com/push';
        $post_data = array(
            "app_id" => "19832QKB",
            "cmd" => "unsent_message",
            "53kf_token" =>$toten
        );
        echo $toten;
        $content=$this->getCurl($url,$post_data);
        file_put_contents('./Uploads/log/mess02.txt',$content);
        $data=json_decode($content,true);

        dump($data);
        $cmd=isset($data['cmd']) ? $data['cmd'] : '';

        if($cmd != 'error'){
            file_put_contents('./Uploads/log/ditie1.txt',$content);
            array_pop($data);
            foreach($data as $ke=>$val){
                $result=json_decode(urldecode($val),true);
                $count=getmaxdim($result);

                if($count > 1){//整体推送
                    D('VisitorRecord')->kfAddRecord($result);
                }else{//客户信息

                    $cmd=isset($result['cmd']) ? $result['cmd'] : '';
                    if($cmd == 'customer'){
                        D('VisitorInfo')->addInfo($result);
                    }
                }

            }

        }

        return json_encode(array('code'=>200,'message'=>'获取成功'));

    }

    /*
     * 获取接口调用权限 53 bote kf_token
     * */
    public function getBoteToken()
    {
        //S(array('type'=>'File','expire'=>60));

        $url='http://api.saas.53kf.com/token';
        $data=array(
            'cmd'       =>'53kf_token',
            'appid'     =>'19822FCB',
            'appsecret' =>'19822XPI'
        );

        // 采用文件方式缓存数据300秒
        /*$bote_token = S('bote_token');
        if(!$bote_token){

            S('bote_token',$bote_token,array('type'=>'file','expire'=>86000));
        }*/

        $res=$this->getCurl($url,$data);
        $token=json_decode($res,true);
        $bote_token=$token['server_response']['53kf_token'];

        return $bote_token;
    }

    /*
     * 获取接口调用权限 53地铁站  kf_token
     * */
    public function getToken()
    {
        //S(array('type'=>'File','expire'=>60));

        $url='http://api.saas.53kf.com/token';
        $data=array(
            'cmd'       =>'53kf_token',
            'appid'     =>'19832QKB',
            'appsecret' =>'19832CTI'
        );

        // 采用文件方式缓存数据300秒
        /*$bote_token = S('ditie_token');
        if(!$bote_token){

            S('ditie_token',$bote_token,array('type'=>'file','expire'=>86000));
        }*/
        $res=$this->getCurl($url,$data);
        $token=json_decode($res,true);
        $bote_token=$token['server_response']['53kf_token'];

        return $bote_token;
    }

    /*
     * get curl操作
     * @param $url 地址
     * @param $data array 请求的参数
     * */
    public function getCurl($url,$data)
    {
        $str='';
        foreach($data as $key=>$val){
            $str .='&'.$key.'='.$val;
        }

        $map=trim($str,'&');

        $url=$url.'?'.$map;

        $ch=curl_init();
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置自动重定向
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        // 抓取URL并把它传递给浏览器
        $res=curl_exec($ch);
        // 关闭cURL资源，并且释放系统资源
        curl_close($ch);

        return $res;
    }

    /*
     * curl post 操作
     * */
    public function postCurl($url,$post_data)
    {
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
        //设置自动重定向
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据

        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $content = curl_exec($curl);

        curl_close($curl);

        return $content;
    }


}