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

	/**
	 * 获取服务器信息
	 *
	 * @return array
	 */
	public function getServerInfo()
	{
		$mysqlVersion = M()->query('select version() as version');
		$serverInfo = [
			'ThinkPHP版本' => 'ThinkPHP ' . THINK_VERSION,
			'操作系统' => PHP_OS,
			'主机名信息' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
			'运行环境' => $_SERVER["SERVER_SOFTWARE"],
			'PHP运行方式' => php_sapi_name(),
			'网站文档目录'=>$_SERVER["DOCUMENT_ROOT"],
			'浏览器信息'=>substr($_SERVER['HTTP_USER_AGENT'], 0, 40),
			'服务器时间'=>date("Y年n月j日 H:i:s"),
			'MYSQL版本' => 'MYSQL ' . $mysqlVersion[0]['version'],
			'上传限制' => ini_get('upload_max_filesize'),
			'POST限制' => ini_get('post_max_size'),
			'最大内存' => ini_get('memory_limit'),
			'执行时间限制' => ini_get('max_execution_time') . "秒",
			'内存使用' => $this->getFilesize(memory_get_usage()),
			'磁盘使用' => round((disk_free_space(".")/(1024*1024)),2).'M',
			'display_errors' => ini_get("display_errors") == "1" ? '√' : '×',
			'register_globals' => get_cfg_var("register_globals") == "1" ? '√' : '×',
			'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? '√' : '×',
			'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? '√' : '×'
		];
		return $serverInfo;
	}

	/*
	 * 转化字节
	 * */
	public function getFilesize($num){
		$p = 0;
		$format='bytes';
		if($num>0 && $num<1024){
			$p = 0;
			return number_format($num).' '.$format;
		}
		if($num>=1024 && $num<pow(1024, 2)){
			$p = 1;
			$format = 'KB';
		}
		if ($num>=pow(1024, 2) && $num<pow(1024, 3)) {
			$p = 2;
			$format = 'MB';
		}
		if ($num>=pow(1024, 3) && $num<pow(1024, 4)) {
			$p = 3;
			$format = 'GB';
		}
		if ($num>=pow(1024, 4) && $num<pow(1024, 5)) {
			$p = 3;
			$format = 'TB';
		}
		$num /= pow(1024, $p);
		return number_format($num, 3).' '.$format;
	}

}

