<?php

namespace Admin\Controller;

use Think\Controller;

class KfinfoController extends Controller
{

    public function index()
    {
        
        $data= array('cmd'=>'OK','token'=>'TOKEN');
        echo json_encode($data);
    }


}