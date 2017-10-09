<?php
namespace Common\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class AdminBaseController extends BaseController
{
	/**
	 * 初始化方法
	 */
	public function _initialize()
	{
		parent::_initialize();

		if(empty($_SESSION['user'])){
			$this->error('请登录',U('Login/index'));
			exit;
		}

		$auth=new \Think\Auth();
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$result=$auth->check($rule_name,$_SESSION['user']['id']);
		if(!$result){
			$this->error('您没有权限访问');
		}
		// 分配菜单数据
		$nav_data=D('AdminNav')->getTreeData('level','order_number,id');
		$assign=array(
			'nav_data'=>$nav_data
			);
		$this->assign($assign);
	}

}

