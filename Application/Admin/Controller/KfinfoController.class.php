<?php

namespace Admin\Controller;

use Think\Controller;

class KfinfoController extends Controller
{

    public function index()
    {
        $content=$_POST;
        file_put_contents('./Uploads/log/kf.txt',$content);

        $data= array('cmd'=>'OK','token'=>'TOKEN');
        echo json_encode($data);
    }


}