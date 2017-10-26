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
            $where .=" and guest_id='{$guest_id}'";
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
            'url_model' => 1,/*URL模式*/
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

    /*
     * 导出数据
     * @param $field array or string [查询的字段]
     * @param $where array or string [查询条件]
     * @param $order string [排序条件]
     * */
    public function exportData($field,$where=1,$order='talk_time desc')
    {
        $data=$this
            ->field($field)
            ->where($where)
            ->order($order)
            ->select();
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

        return $data;
    }

    /*
     * kf 接口调用
     * 访客聊天记录
     * */
    public function kfAddRecord($data)
    {
        if(empty($data)){
            return false;
        }

        $sessionarr=isset($data['session']) ? $data['session'] : '';
        $end=isset($data['end']) ? $data['end'] : '';
        $message=isset($data['message']) ? $data['message'] : '';

        $this->addRecordData($sessionarr,$end,$message);

        return true;
    }
    public function addRecordData($sessionarr,$end,$message)
    {

        $map['guest_id']=isset($sessionarr['guest_id']) ? $sessionarr['guest_id']:'';
        $map['talk_id']=isset($sessionarr['talk_id']) ? $sessionarr['talk_id']:'';
        $map['company_id']=isset($sessionarr['company_id']) ? $sessionarr['company_id']:'';
        $map['id6d']=isset($sessionarr['id6d']) ? $sessionarr['id6d']:'';
        $map['guest_ip']=isset($sessionarr['guest_ip']) ? $sessionarr['guest_ip']:'';
        $map['guest_area']=isset($sessionarr['guest_area']) ? $sessionarr['guest_area']:'';
        $map['talk_page']=isset($sessionarr['talk_page']) ? $sessionarr['talk_page']:'';
        $map['se']=isset($sessionarr['se']) ? $sessionarr['se']:'';
        $map['kw']=isset($sessionarr['kw']) ? $sessionarr['kw']:'';
        $map['talk_type']=isset($sessionarr['talk_type']) ? $sessionarr['talk_type']:'';
        $map['device']=isset($sessionarr['device']) ? $sessionarr['device']:'';
        $map['worker_id']=isset($sessionarr['worker_id']) ? $sessionarr['worker_id']:'';
        $map['worker_name']=isset($sessionarr['worker_name']) ? $sessionarr['worker_name']:'';
        $map['message']=isset($message) ? json_encode($message):'';
        $map['talk_time']=isset($sessionarr['talk_time']) ? strtotime($sessionarr['talk_time']) : '';
        $map['end_time']=isset($end['end_time']) ? strtotime($end['end_time']) : '';
        $map['message']=json_encode($message);


        $arr=array(
            'guest_id'=>$map['guest_id'],
            'talk_time'=>$map['talk_time']
        );
        $res=$this->where($arr)->find();

        if(empty($res)){

            $id=$this->add($map);
        }


        return true;
    }

}