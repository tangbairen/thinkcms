<?php
namespace Admin\Model;

use Org\Nx\Page;
use Think\Model;

/*
 * 访客记录（聊天）模型
 * */
class VisitorRecordModel extends Model
{
    /*
     * 查询是否存在数据
     * @param $guest_id [访客ID]
     * @return array [一维，存在返回这条数据]
     * */
    public function existData($guest_id)
    {
        $result=$this->where("guest_id={$guest_id} and status=1")->find();
        return $result;
    }

    /*
     * 添加数据
     * */
    public function addData($data)
    {
        $sessionarr=$data['session'];
        $end=$data['end'];
        $message=$data['message'];
        $id=$this->addRecord($sessionarr,$end);
        $guest_id=$sessionarr['guest_id'];
        //查询客户信息是否存在
        $exist=D('VisitorInfo')->where("guest_id={$guest_id} and status=1")->find();

        $recordData=array_merge($sessionarr,$end);
        //数据存在
        if(!empty($exist)){
           D('VisitorInfo')->addResource($exist,$recordData,$message);
        }


    }

    public function addRecord($sessionarr,$end,$message)
    {
        $map=array_merge($sessionarr,$end);

        $map['talk_time']=strtotime($sessionarr['talk_time']);
        $map['end_time']=strtotime($end['end_time']);
        $map['message']=json_encode($message);

        $id=$this->add($map);
        return $id;
    }


    /*
     * 获取全部数据
     * */
    public function getData($where=1)
    {
        $guest_id=trim(I('get.guest_id'));
        $worker_id=trim(I('get.worker_id'));
        $status=I('get.status','');
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        if(!empty($guest_id)){
            $where .=" and guest_id={$guest_id}";
        }

        if(!empty($worker_id)){
            $where .=" and worker_id='{$worker_id}'";
        }

        if(!empty($status)){
            $where .=" and status={$status}";
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where .=" and talk_time >={$start_time}";
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where .=" and talk_time <={$end_time}";
        }

        import('@.Class.Page'); //引入Page类
        // 查询满足要求的总记录数
        $count = $this->where($where)->count();
        /*进行第三方分页类配置*/
        $page = array(
            'total' => $count,/*总数（改）*/
            'url' => !empty($param['url']) ? $param['url'] : '',/*URL配置*/
            'max' => !empty($param['max']) ? $param['max'] : 20,/*每页显示多少条记录（改）*/
            'url_model' => 2,/*URL模式*/
            'ajax' =>  !empty($param['ajax']) ? true : false,/*开启ajax分页*/
            'out' =>  !empty($param['out']) ? $param['out'] : false,/*输出设置*/
            'url_suffix' => true,/*url后缀*/
            'tags' => array('首页','上一页','下一页','尾页'),
        );
        /*实例化第三方分页类库*/
        $page = new \Page($page);

        $data=$this->where($where)->order('end_time desc')->limit($page->pagerows(),$page->maxrows())->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                $val['talk_time']=date('Y-m-d H:i:s',$val['talk_time']);
                $val['end_time']=date('Y-m-d H:i:s',$val['end_time']);
                if($val['status'] == 1){
                    $val['status']='未处理';
                }else{
                    $val['status']='已处理';
                }
            }

        }
        // 得到分页
        $show = $page->get_page();
        return array('data'=>$data,'show'=>$show,'count'=>$count);
    }

}