<?php

define('HOST','localhost');
define('USER','thinkcms');
define('PASS','bairen168');
define('DB','thinkcms');

// 1.连接
$link = @mysqli_connect(HOST,USER,PASS,DB) or exit('连接失败！');

// 2.设置字符集
mysqli_set_charset($link , 'utf8');

// 7.关闭连接
mysqli_close($link);

require('./MMysql.class.php');

$mysql=new MMysql(array(
        'host'=>'localhost',
        'port'=>'3306',
        'user'=>'thinkcms',
        'passwd'=>'bairen168',
        'dbname'=>'thinkcms'
    ));
   var_dump($mysql);