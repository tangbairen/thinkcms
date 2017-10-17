<?php
	define('APP_DEBUG',true);
	// 定义应用目录
	define('APP_PATH','./Application/');


	// 定义oss的url
	//	define("OSS_URL","");
	// 引入ThinkPHP入口文件
	require './ThinkPHP/ThinkPHP.php';

	$aaa=new \Admin\Controller\VisitorController();

	$aaa->index();

	$data = array('cmd' => 'OK', 'token' => 'TOKEN');
	echo  json_encode($data);