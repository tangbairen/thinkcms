<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台首页控制器
 */
class IndexController extends AdminBaseController{
	/**
	 * 首页
	 */
	public function index()
	{
		$uid=session('user.id');
		$data=M('Users')->field('last_login_time,last_login_ip,login_count')->where("id={$uid}")->find();
		$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
		$area = $Ip->getlocation($data['last_login_ip']); // 获取某个IP地址所在的位置

		$res=M('AuthGroupAccess')->where("uid={$uid}")->find();
		$group=M('AuthGroup')->where("id={$res['group_id']}")->find();

		$this->assign('data',$data);
		$this->assign('area',$area);
		$this->assign('group',$group);
		$this->display();
	}
	/**
	 * elements
	 */
	public function elements(){

		$this->display();
	}
	
	/**
	 * welcome
	 */
	public function welcome(){
	    $this->display();
	}

	/*
	 * 控制台
	 * */
	public function console()
	{
		//获取服务器信息
		$data=$this->getServerInfo();
		// 扩展列表
		$extensionsList = get_loaded_extensions();

		$manger_count=M('Users')->count();
		$menu_count=M('AdminNav')->count();

		$this->assign(array('data'=>$data,'extensionsList'=>implode(' , ',$extensionsList),'manger_count'=>$manger_count,'menu_count'=>$menu_count));
		$this->display();
	}



}
