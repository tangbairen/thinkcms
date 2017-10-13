<?php
namespace Admin\Model;

use Think\Model;

class AreaModel extends Model
{

    public function listData()
    {
        $data=D('Area')
            -> alias('a')
            ->field('a.id,a.area_name,GROUP_CONCAT(p.`name`) as province')
            ->join('left join bt_province as p on a.id=p.area_id')
            ->group('a.area_name')
            ->order('a.id')
            ->where('a.id > 0')
            ->select();

        return $data;

    }



}