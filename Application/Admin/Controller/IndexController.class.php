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
		$data=M('Users')
			->alias('u')
			->join('left join bt_role_department as d on u.department_id=d.id')
			->field('last_login_time,last_login_ip,login_count,d.name,level,department_id')
			->where("u.id={$uid}")
			->find();
		$Ip = new \Org\Net\IpLocation('UTFWry.dat'); // 实例化类 参数表示IP地址库文件
		$area = $Ip->getlocation($data['last_login_ip']); // 获取某个IP地址所在的位置


		/*$res=M('AuthGroupAccess')->where("uid={$uid}")->find();
		$group=M('AuthGroup')->where("id={$res['group_id']}")->find();*/

		/*$sql="select FROM_UNIXTIME(addtime,'%Y-%m-%d') as day,count(*)as number  from  bt_resource where group_id={$res['group_id']}   GROUP BY day  order by day desc";
		$total=M('Resource')->query($sql);*/

		$this->assign('data',$data);
		$this->assign('area',$area);

		switch($data['level']){
			case 1://超级
				$resource=D('Users')->getTotalData();
				$this->assign('resource',$resource);
				$this->display('total');
				break;
			case 3:
				//获取部门资源信息  部门id
				$depart=D('RoleDepartment')->getDepartData($data['department_id']);
				$this->assign('depart',$depart);
				$this->display('index');
				break;
			case 5://销售部门
				$summary=D('Resource')->summary($data['department_id']);//今日，当月汇总
				$this->assign($summary);
				$this->display('department');
				break;
			default:
				$this->display('welcome');
				break;
		}
		/*$summary=D('Resource')->summary($res['group_id']);//今日，当月汇总
		$status=M('Total')->where("group_id={$res['group_id']}")->find();
		$this->assign('data',$data);
		$this->assign('area',$area);
		$this->assign('group',$group);
		$this->assign('status',$status);
		$this->assign($summary);*/
		//$this->assign('total',$total);



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
