<?php
namespace Admin\Model;

use Think\Db;
use Think\Model;

/*
 * 迈锡尼留言表
 * */
class Messagemxn2Model extends Model
{
    //调用配置文件中的数据库配置1
    protected $connection = 'DB_CONFIG1';


    public function getBoteData()
    {

        $phone=trim(I('get.phone',''));
        $start_time=I('get.start_time','');
        $end_time=I('get.end_time','');

        $where['isshow']=1;

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

        $data=$this->where($where)
            ->field('id,username,xm,tel,email,qq,content,url_come,url,create_time,ip,area,hashstr,isshow')
            ->order('id desc')
            ->limit($page->pagerows(),$page->maxrows())
            ->select();

        if(!empty($data)){
            foreach($data as $key=>&$val){
                //来源渠道
                $talk_page=isset($val['url']) ? $val['url']:'';
                $res=parse_url($talk_page);
                $host=isset($res['host']) ? $res['host']:'';//来源url
                $res=M('Referer')->where("url='{$host}'")->find();
                if(!empty($res)){
                    $val['company']=$res['company'];
                }
            }
        }

        // 得到分页
        $show = $page->get_page();

        return array('data'=>$data,'show'=>$show,'count'=>$count);

    }

    /*
     * 柏特导出
     * */
    public function boteExport($field,$where)
    {
        $count=count($where);
        if($count == 1){
            $data=$this->where($where)
                ->field($field)
                ->order('id desc')
                ->limit(1000)
                ->select();
        }else{
            $data=$this->where($where)
                ->field($field)
                ->order('id desc')
                ->select();
        }

        return $data;
    }


}