<?php
namespace Admin\Controller;

use Admin\Model\MessageluchiModel;
use Admin\Model\MessageModel;
use Admin\Model\Messagemxn2Model;
use Admin\Model\MessageseoModel;
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
            'end_time'      =>$end_time,

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

        if(!empty($start_time) &&  !empty($end_time)){
            $start_time=strtotime($start_time);
            $end_time=strtotime($end_time);
            $where['unix_timestamp(create_time)']=array('between',array($start_time,$end_time));
        }else{

            if(!empty($start_time)){
                $start_time=strtotime($start_time);
                $where['unix_timestamp(create_time)']=array('EGT',$start_time);
            }else if(!empty($end_time)){
                return [];
            }
        }

        $field=['username','tel','area','xm','qq','content','url','ip','create_time'];

        $model=new MessageModel();
        $data=$model->boteExport($field,$where);

        $header=['姓名','电话','地址','项目','QQ','留言内容','来源url','来源ip','提交时间','公司'];

        export($header,$data);

    }


    /*
     * 迈锡尼留言
     * */
    public function maixini()
    {
        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        $model=new Messagemxn2Model();
//        $model=new MessageModel();
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
     * 迈锡尼 伪删除
     * */
    public function del_mai()
    {
        $id=I('get.id',0);
        $model=new Messagemxn2Model();

        $res=$model->where("id={$id}")->save(array('isshow'=>0));

        if($res){
            $this->success('删除成功',U('message/maixini'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * 迈锡尼导出
     * */
    public function maiExport()
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

        if(!empty($start_time) &&  !empty($end_time)){
            $start_time=strtotime($start_time);
            $end_time=strtotime($end_time);
            $where['unix_timestamp(create_time)']=array('between',array($start_time,$end_time));
        }else{

            if(!empty($start_time)){
                $start_time=strtotime($start_time);
                $where['unix_timestamp(create_time)']=array('EGT',$start_time);
            }else if(!empty($end_time)){
                return [];
            }
        }

        $field=['username','tel','area','xm','qq','content','url','ip','create_time'];

        $model=new Messagemxn2Model();
        $data=$model->boteExport($field,$where);

        $header=['姓名','电话','地址','项目','QQ','留言内容','来源url','来源ip','提交时间','公司'];

        export($header,$data);

    }


    /*
     * seo留言
     * */
    public function seolist()
    {
        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        $model=new MessageseoModel();
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
     * seo 伪删除
     * */
    public function del_seo()
    {
        $id=I('get.id',0);
        $model=new MessageseoModel();

        $res=$model->where("id={$id}")->save(array('isshow'=>0));

        if($res){
            $this->success('删除成功',U('message/seolist'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * seo导出
     * */
    public function seoExport()
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

        if(!empty($start_time) &&  !empty($end_time)){
            $start_time=strtotime($start_time);
            $end_time=strtotime($end_time);
            $where['unix_timestamp(create_time)']=array('between',array($start_time,$end_time));
        }else{

            if(!empty($start_time)){
                $start_time=strtotime($start_time);
                $where['unix_timestamp(create_time)']=array('EGT',$start_time);
            }else if(!empty($end_time)){
                return [];
            }
        }

        $field=['username','tel','area','xm','qq','content','url','ip','create_time'];

        $model=new MessageseoModel();
        $data=$model->boteExport($field,$where);

        $header=['姓名','电话','地址','项目','QQ','留言内容','来源url','来源ip','提交时间','公司'];

        export($header,$data);

    }

    /*
     * 禄持留言板
     * 2017-11-10 09：48
     * */
    public function luchi()
    {
        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

       ;
        $model=new \Admin\Model\Luchi\Messagemxn2Model();
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


}