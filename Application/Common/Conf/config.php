<?php
return array(
//*************************************附加设置***********************************
    'SHOW_PAGE_TRACE'        => false,                          // 是否显示调试面板
    'URL_CASE_INSENSITIVE'   => false,                          // url区分大小写
    'DEFAULT_FILTER'        => 'htmlspecialchars,trim',              //系统默认的变量过滤机制
    'LOAD_EXT_CONFIG'        => 'db',                           // 加载网站设置文件
    'TMPL_PARSE_STRING'      => array(                          // 定义常用路径
        '__OSS__'            => OSS_URL,
        '__PUBLIC__'         => OSS_URL.__ROOT__.'/Public',
        '__HOME_CSS__'       => __ROOT__.trim(TMPL_PATH,'.').'Home/Public/css',
        '__HOME_CSS__'       => __ROOT__.trim(TMPL_PATH,'.').'Home/Public/css',
        '__HOME_JS__'        => __ROOT__.trim(TMPL_PATH,'.').'Home/Public/js',
        '__HOME_IMAGES__'    => OSS_URL.trim(TMPL_PATH,'.').'Home/Public/images',
        '__ADMIN_CSS__'      => __ROOT__.trim(TMPL_PATH,'.').'Admin/Public/css',
        '__ADMIN_JS__'       => __ROOT__.trim(TMPL_PATH,'.').'Admin/Public/js',
        '__ADMIN_IMAGES__'   => OSS_URL.trim(TMPL_PATH,'.').'Admin/Public/images',
        '__ADMIN_ACEADMIN__' => OSS_URL.__ROOT__.'/Public/statics/aceadmin',
        '__PUBLIC_CSS__'     => __ROOT__.trim(TMPL_PATH,'.').'Public/css',
        '__PUBLIC_JS__'      => __ROOT__.trim(TMPL_PATH,'.').'Public/js',
        '__PUBLIC_IMAGES__'  => OSS_URL.__ROOT__.trim(TMPL_PATH,'.').'Public/images',
        '__USER_CSS__'       => __ROOT__.trim(TMPL_PATH,'.').'User/Public/css',
        '__USER_JS__'        => __ROOT__.trim(TMPL_PATH,'.').'User/Public/js',
        '__USER_IMAGES__'    => OSS_URL.trim(TMPL_PATH,'.').'User/Public/images',
        '__APP_CSS__'        => __ROOT__.trim(TMPL_PATH,'.').'App/Public/css',
        '__APP_JS__'         => __ROOT__.trim(TMPL_PATH,'.').'App/Public/js',
        '__APP_IMAGES__'     => OSS_URL.trim(TMPL_PATH,'.').'App/Public/images'
    ),
//***********************************URL设置**************************************
    'MODULE_ALLOW_LIST'      => array('Home','Admin','Api','User','App'), //允许访问列表
    'URL_HTML_SUFFIX'        => '',  // URL伪静态后缀设置
    'URL_MODEL'              => 2,  //启用rewrite
    'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名配置
    'APP_SUB_DOMAIN_RULES'    =>    array(
        'cms.lezycy.com'  => 'Admin',  // admin.domain1.com域名指向Admin模块
    ),
//***********************************SESSION设置**********************************
    'SESSION_OPTIONS'        => array(
        'name'               => 'BJYADMIN',//设置session名
        'expire'             => 24*3600, //SESSION保存15天
        'use_trans_sid'      => 1,//跨页传递
        'use_only_cookies'   => 0,//是否只开启基于cookies的session的会话方式
    ),
    'COOKIE_PREFIX'          =>'bote_',
//***********************************页面设置**************************************
    'TMPL_EXCEPTION_FILE'    => APP_DEBUG ? THINK_PATH.'Tpl/think_exception.tpl' : './Template/default/Home/Public/404.html',
    'TMPL_ACTION_ERROR'      => TMPL_PATH.'/Public/dispatch_jump.tpl', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'    => TMPL_PATH.'/Public/dispatch_jump.tpl', // 默认成功跳转对应的模板文件
//***********************************auth设置**********************************
    'AUTH_CONFIG'            => array(
            'AUTH_USER'      => 'users'                         //用户信息表
        ),

//***********************************缓存设置**********************************
    'DATA_CACHE_TIME'        => 1800,        // 数据缓存有效期s
    'DATA_CACHE_PREFIX'      => 'mem_',      // 缓存前缀
    'DATA_CACHE_TYPE'        => 'Memcached', // 数据缓存类型,
    'MEMCACHED_SERVER'       => '127.0.0.1', // 服务器ip
    'ALIOSS_CONFIG'          => array(
        'KEY_ID'             => '', // 阿里云oss key_id
        'KEY_SECRET'         => '', // 阿里云oss key_secret
        'END_POINT'          => '', // 阿里云oss endpoint
        'BUCKET'             => ''  // bucken 名称
        ),

    //数据库配置1 (柏特,迈锡尼 留言)
    'DB_CONFIG1' => array(
        'DB_TYPE'  => 'mysqli',
        'DB_USER'  => 'btmessage1_msg',
        'DB_PWD'   => 'mJD76^u2',
        'DB_HOST'  => '116.31.118.96',
        'DB_PORT'  => '3306',
        'DB_NAME'  => 'btmessage1_msg',
        'DB_CHARSET'=>    'utf8',
        'DB_PREFIX' => '', // 数据库表前缀
    ),

    //数据库配置2 (SEO留言)
    'DB_CONFIG2' => array(
        'DB_TYPE'  => 'mysqli',
        'DB_USER'  => 'maixini_sliuyan',
        'DB_PWD'   => 'cGN28%z7',
        'DB_HOST'  => '116.31.118.96',
        'DB_PORT'  => '3306',
        'DB_NAME'  => 'maixini_sliuyan',
        'DB_CHARSET'=>    'utf8',
        'DB_PREFIX' => '', // 数据库表前缀
    ),

    //数据库配置(Luchi留言)
    'DB_LUCHI' => array(
        'DB_TYPE'  => 'mysqli',
        'DB_USER'  => 'jjluchi_message',
        'DB_PWD'   => 'bHV07@s1',
        'DB_HOST'  => '116.31.118.96',
        'DB_PORT'  => '3306',
        'DB_NAME'  => 'jjluchi_message',
        'DB_CHARSET'=>    'utf8',
        'DB_PREFIX' => '', // 数据库表前缀
    ),
    //数据库配置 (Oben留言)
    'DB_OBEN' => array(
        'DB_TYPE'  => 'mysqli',
        'DB_USER'  => 'jjoben_message',
        'DB_PWD'   => 'yTQ20-u9',
        'DB_HOST'  => '116.31.118.96',
        'DB_PORT'  => '3306',
        'DB_NAME'  => 'jjoben_message',
        'DB_CHARSET'=>    'utf8',
        'DB_PREFIX' => '', // 数据库表前缀
    ),
);
