<?php
namespace Admin\Controller;

use Admin\Model\MessageModel;
use Common\Controller\AdminBaseController;

/*
 * 留言管理
 * */
class MessageController extends AdminBaseController
{

    /*
     * 柏特留言 列表
     * */
    public function bote()
    {

        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        $model=new MessageModel();
        $data=$model->getBoteData();
        $array=array(
            'phone'         =>$phone,
            'start_time'    =>$start_time,
            'end_time'      =>$end_time

        );
        $this->assign($data);
        $this->assign($array);
        $this->display();
    }

    /*
     * bote 伪删除
     * */
    public function del_data()
    {
        $id=I('get.id',0);
        $model=new MessageModel();
        $res=$model->where("id={$id}")->save(array('isshow'=>0));

        if($res){
            $this->success('删除成功',U('message/bote'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * 柏特导出
     * */
    public function boteExport()
    {
        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');
        $box=I('get.box','');
        $where['isshow']=1;

        if(!empty($box)){
            $where['id']=array('in',$box);
        }

        if(!empty($phone)){
            $where['tel']=array('like',"{$phone}%");
        }

        if(!empty($start_time)){
            $start_time=strtotime($start_time);
            $where['unix_timestamp(create_time)']=array('egt',$start_time);
        }

        if(!empty($end_time)){
            $end_time=strtotime($end_time);
            $where['unix_timestamp(create_time)']=array('elt',$end_time);
        }

        $field=['username','tel','area','xm','qq','content','url','ip','create_time'];

        $model=new MessageModel();
        $data=$model->boteExport($field,$where);

        $header=['姓名','电话','地址','项目','QQ','留言内容','来源url','来源ip','提交时间'];

        export($header,$data);

    }


}