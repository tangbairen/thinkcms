<?php
namespace Admin\Model;

use Think\Model;
/*
 * 访客信息 模型
 * */
class VisitorInfoModel extends Model
{

    /*
     * 添加数据
     * @param $data array [一维数组]
     * */
    public function addData($data)
    {
        $map=[];
        foreach($data as $key=>$val){
            $map[$key]=$val;
        }
        $id=$this->add($map);

        $guest_id=$data['guest_id'];
        //查询聊天记录是否存在
        $recordData=D('VisitorRecord')->existData($guest_id);

        //数据存在
        if(!empty($recordData)){
            $this->addResource($data,$recordData);
        }

        return true;
    }

    /*
     * 添加到资源里面
     * @param $data [访客信息]
     * @param $recordData [访客聊天信息]
     * */
    public function addResource($data,$recordData)
    {
        $guest_name=$data['guest_name']; //客服名称
        $len=strpos($guest_name,'#');
        $phone=substr($guest_name,$len+1);//手机号码
        $guest_area=substr($recordData['guest_area'],0,2);//访客所在省份，（查询所在区域）
        $keyword=$recordData['kw'];
        $device=array(1=>'PC',2=>'移动',3=>'微信');
        $source=$recordData['se'].$device[$recordData['device']];//来源渠道
        $talk_page=$recordData['talk_page'];//咨询地址

        $area=$this->getAreaId($guest_area);
        $brand_id=$this->getBrandId($keyword,$talk_page);//获取品牌id

        $group_id=D('Resource')->allocationGroup($brand_id,$area['area_id']);


        $map['addtime']=time();
        $map['group_id']=$group_id;
        $map['talk_id']=$recordData['talk_id'];
        $map['address']=$recordData['guest_area'];
        $map['username']='';
        $map['phone']=$phone;
        $map['chats']=$data['qq'].','.$data['email'];
        $map['customer_info']=$data['worker_id'];
        $map['brand_id']=$brand_id;
        $map['province']=$area['id'];
        $map['area_id']=$area['area_id'];
        $map['source']=$source;
        $map['keyword']=$keyword;
        $map['types']=2;

        D('Resource')->add($map);

        D('VisitorRecord')->where("guest_id={$data['guest_id']}")->save(array('status'=>2));
        D('VisitorInfo')->where("guest_id={$data['guest_id']}")->save(array('status'=>2));

        return true;


    }

    /*
     * 获取品牌id
     * @param $keywork 关键字
     * @param $talk_page 咨询地址
     * */
    public function getBrandId($keywork,$talk_page)
    {
        $brand=M('Brands')->select();
        foreach($brand as $key=>$val){
            $pos=strpos($keywork,$val['name']);
            if($pos !== false){
                return $val['id'];
            }
        }

        return 0;
    }

    /*
     * 获取区域id
     * */
    public function getAreaId($guest_area)
    {
        $res=M('province')->where("name like '%{$guest_area}%'")->find();

        if($res){
            return $res;
        }

        return 0;
    }

}
