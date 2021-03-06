<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Think\Exception;

/**
 * 后台权限管理
 */
class RuleController extends AdminBaseController{

//******************权限***********************
    /**
     * 权限列表
     */
    public function index(){
        $data=D('AuthRule')->getTreeData('tree','id','title');
        $assign=array(
            'data'=>$data
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加权限
     */
    public function add(){
        try{
            $data=I('post.');
            unset($data['id']);
            if(empty($data['title'])) throw new Exception('权限名不能为空');
            if(empty($data['name'])) throw new Exception('权限不能为空');
            $name=trim($data['name']);
            $res=M('AuthRule')->where("name='{$name}'")->select();
            if($res) throw new Exception('该权限已经存在了');

            $result=D('AuthRule')->addData($data);
            if ($result) {
                $this->success('添加成功',U('Admin/Rule/index'));
            }else{
                $this->error('添加失败');
            }

        }catch(Exception $e){

            $message=$e->getMessage();
            $this->error($message);
        }

    }

    /**
     * 修改权限
     */
    public function edit(){
        $data=I('post.');
        $map=array(
            'id'=>$data['id']
            );
        $result=D('AuthRule')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',U('Admin/Rule/index'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除权限
     */
    public function delete(){
        $id=I('get.id');
        $map=array(
            'id'=>$id
            );
        $result=D('AuthRule')->deleteData($map);
        if($result){
            $this->success('删除成功',U('Admin/Rule/index'));
        }else{
            $this->error('请先删除子权限');
        }

    }
//*******************用户组**********************
    /**
     * 用户组列表
     */
    public function group(){
        $data=D('AuthGroup')->select();
        $area=M('Area')->select();

        $assign=array(
            'data'=>$data,
            'area'=>$area
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户组
     */
    public function add_group(){
        $data=I('post.');
        unset($data['id']);
        //判断是否存在
        $title=trim($data['title']);

        $data=M('AuthGroup')->where("title='{$title}'")->select();

        if($data){
            $this->error('该用户组已存在了！');
            exit;
        }

        $area_id='';
        $arr=I('post.check');
        if(!empty($arr)){
            foreach($arr as $key=>$val){
                $area_id .=$val.',';
            }
            $area_id=trim($area_id,',');
        }
        $map['title']=$title;
        $map['area_id']=$area_id;

        $result=M('AuthGroup')->add($map);
        if ($result) {
            $this->success('添加成功',U('Admin/Rule/group'));
        }else{
            $this->error('添加失败');
        }
    }

    /**
     * 修改用户组
     */
    public function edit_group(){
        $data=I('post.');
        $area_id='';
        if(!empty($data['check2'])){
            foreach($data['check2'] as $key=>$value){
                $area_id .=$value.',';
            }
            $area_id=trim($area_id,',');

        }
        $map['title']=trim($data['title']);
        $map['area_id']=$area_id;
        /*$map=array(
            'id'=>$data['id'],
            );*/
        $result=M('AuthGroup')->where("id={$data['id']}")->save($map);
//        $result=D('AuthGroup')->editData($map,$data);
        if ($result) {
            $this->success('修改成功',U('Admin/Rule/group'));
        }else{
            $this->error('修改失败');
        }
    }

    /**
     * 删除用户组
     */
    public function delete_group(){
        $id=I('get.id',0,'intval');
        $map=array(
            'id'=>$id
            );
        $result=D('AuthGroup')->deleteData($map);
        if ($result) {
            $this->success('删除成功',U('Admin/Rule/group'));
        }else{
            $this->error('删除失败');
        }
    }

//*****************权限-用户组*****************
    /**
     * 分配权限
     */
    public function rule_group(){
        if(IS_POST){
            $data=I('post.');
            $map=array(
                'id'=>$data['id']
                );
            $data['rules']=implode(',', $data['rule_ids']);
            $result=D('AuthGroup')->editData($map,$data);
            if ($result) {
                $this->success('操作成功',U('Admin/Rule/group'));
            }else{
                $this->error('操作失败');
            }
        }else{
            $id=I('get.id');
            // 获取用户组数据
            $group_data=M('Auth_group')->where(array('id'=>$id))->find();
            $group_data['rules']=explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data=D('AuthRule')->getTreeData('level','id','title');
//            p($rule_data);
            $assign=array(
                'group_data'=>$group_data,
                'rule_data'=>$rule_data
                );
            $this->assign($assign);
            $this->display();
        }

    }
//******************用户-用户组*******************
    /**
     * 添加成员
     */
    public function check_user(){
        $username=I('get.username','');
        $group_id=I('get.group_id');
        $group_name=M('Auth_group')->getFieldById($group_id,'title');
        $uids=D('AuthGroupAccess')->getUidsByGroupId($group_id);
        // 判断用户名是否为空
        if(empty($username)){
            $user_data='';
        }else{
            $user_data=M('Users')->where(array('username'=>$username))->select();
        }
        $assign=array(
            'group_name'=>$group_name,
            'uids'=>$uids,
            'user_data'=>$user_data,
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加用户到用户组
     */
    public function add_user_to_group(){
        $data=I('get.');
        $map=array(
            'uid'=>$data['uid'],
            'group_id'=>$data['group_id']
            );
        $count=M('AuthGroupAccess')->where($map)->count();
        if($count==0){
            D('AuthGroupAccess')->addData($data);
        }
        $this->success('操作成功',U('Admin/Rule/check_user',array('group_id'=>$data['group_id'],'username'=>$data['username'])));
    }

    /**
     * 将用户移除用户组
     */
    public function delete_user_from_group(){
        $map=I('get.');
        $result=D('AuthGroupAccess')->deleteData($map);
        if ($result) {
            $this->success('操作成功',U('Admin/Rule/admin_user_list'));
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * 管理员列表
     */
    public function admin_user_list(){
        $data=D('AuthGroupAccess')->getAllData();
        foreach($data as $key=>&$val){
            $company=M('Company')->alias('c')->join('bt_users as u  on  c.cid=u.id')->where("uid={$val['id']}")->select();
            if(!empty($company)){
                $val['company_name']=$company[0]['company'];
            }
        }
        $assign=array(
            'data'=>$data
            );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 添加管理员
     */
    public function add_admin(){
        if(IS_POST){
            $data=I('post.');
            $map['username']=$data['username'];
            if(!empty($data['phone'])){
                $map['phone']=$data['phone'];
            }
            $map['email']=$data['email'];
//            $map['company']='';
            $map['password']=md5($data['password']);
            $map['status']=$data['status'];
            $map['level']=$data['level']+0;
            $map['register_time']=time();

            //查询是否存在
            $res=M('Users')->where("username='{$data['username']}'")->find();
            if($res){
                $this->error('该用户名已经存在了！');
                exit;
            }

            $result=M('Users')->data($map)->add();
            if($result){
                if (!empty($data['group_ids'])) {
                    foreach ($data['group_ids'] as $k => $v) {
                        $group=array(
                            'uid'=>$result,
                            'group_id'=>$v
                            );
                        D('AuthGroupAccess')->addData($group);
                    }                   
                }

                if($data['company_id'] > 0){
                    M('Company')->add(array('uid'=>$result,'cid'=>$data['company_id']));
                }

                // 操作成功
                $this->success('添加成功',U('Admin/Rule/admin_user_list'));
            }else{
                $error_word=D('Users')->getError();
                // 操作失败
                $this->error($error_word);
            }
        }else{
            $data=D('AuthGroup')->select();

            //获取所属公司
            $company=M('Users')->where('level=3')->select();


            $assign=array(
                'data'=>$data,
                'company'=>$company
                );
            $this->assign($assign);
            $this->display();
        }
    }

    /**
     * 修改管理员
     */
    public function edit_admin(){
        if(IS_POST){
            $data=I('post.');
//            dump($data);exit;
            // 组合where数组条件
            $uid=$data['id'];
            $map=array(
                'id'=>$uid
                );

            // 修改权限
            D('AuthGroupAccess')->deleteData(array('uid'=>$uid));
            foreach ($data['group_ids'] as $k => $v) {
                $group=array(
                    'uid'=>$uid,
                    'group_id'=>$v
                    );
                D('AuthGroupAccess')->addData($group);
            }
            $data=array_filter($data);
            // 如果修改密码则md5
            if (!empty($data['password'])) {
                $data['password']=md5($data['password']);
            }

            $User = M("Users");

            $result=$User->where($map)->save($data);

            $company=M('Company')->where("uid={$uid}")->find();
            $company_id=$data['company_id']+0;
            if(empty($company)){//添加
                if($company_id > 0){
                    M('Company')->add(array('uid'=>$uid,'cid'=>$company_id));
                }
            }else{//修改
                M('Company')->where("id={$company['id']}")->save(array('cid'=>$company_id));
            }

            $this->success('编辑成功',U('Admin/Rule/admin_user_list',array('id'=>$uid)));

           /* if($result){
                // 操作成功
                $this->success('编辑成功',U('Admin/Rule/admin_user_list',array('id'=>$uid)));
            }else{
                $error_word=D('Users')->getError();
                if (empty($error_word)) {
                    $this->success('编辑失败',U('Admin/Rule/admin_user_list',array('id'=>$uid)));
                }else{
                    // 操作失败
                    $this->error($error_word);                  
                }

            }*/
        }else{
            $id=I('get.id',0,'intval');
            // 获取用户数据
            $user_data=M('Users')->find($id);
            // 获取已加入用户组
            $group_data=M('AuthGroupAccess')
                ->where(array('uid'=>$id))
                ->getField('group_id',true);
            // 全部用户组
            $data=D('AuthGroup')->select();

            //获取所属公司
            $company=M('Users')->where('level=3')->select();

            //
            $comp=M('Company')->where("uid={$id}")->find();

            $assign=array(
                'data'=>$data,
                'user_data'=>$user_data,
                'group_data'=>$group_data,
                'company'=>$company,
                'comp'=>$comp
                );
            $this->assign($assign);
            $this->display();
        }
    }

    /*
     * 删除管理员
     * */
    public function delete_user()
    {
        $id=I('get.id');
        $result=M('Users')->where("id={$id}")->delete();
        if ($result) {
            $this->success('删除成功',U('Admin/Rule/admin_user_list'));
        }else{
            $this->error('删除失败');
        }
    }

    /*
     * 添加公司账号（电销）用来查看部门所属公司的资源情况
     * */
    public function add_company()
    {
        if(IS_POST){

            $data=I('post.');
            $map['username']=$data['username'];
            if(!empty($data['phone'])){
                $map['phone']=$data['phone'];
            }
            $map['email']=$data['email'];
            $map['company']=$data['company'];
            $map['password']=md5($data['password']);
            $map['status']=$data['status'];
            $map['register_time']=time();
            $map['level']=3;

            //查询是否存在
            $res=M('Users')->where("username='{$data['username']}'")->find();
            if($res){
                $this->error('该用户名已经存在了！');
                exit;
            }

            $result=M('Users')->data($map)->add();
            if($result){
                if (!empty($data['group_ids'])) {
                    foreach ($data['group_ids'] as $k => $v) {
                        $group=array(
                            'uid'=>$result,
                            'group_id'=>$v
                        );
                        D('AuthGroupAccess')->addData($group);
                    }
                }
                // 操作成功
                $this->success('添加成功',U('Admin/Rule/admin_user_list'));
            }else{
                $error_word=D('Users')->getError();
                // 操作失败
                $this->error($error_word);
            }


        }else{
            $data=D('AuthGroup')->select();
            $assign=array(
                'data'=>$data
            );
            $this->assign($assign);
            $this->display();
        }

    }

    /*
     * 部门列表 （新）
     * */
    public function department()
    {
        if(IS_POST){

            try{
                $name=I('post.name');
                $parent_id=I('post.parent_id');
                $description=I('post.description');//描述
                $check2=I('post.check2');
                $group_id=I('post.group_id');
                if($parent_id == 'top'){
                    $map['parent_id'] = 0;
                }
                if(!empty($check2)){
                    $map['area_id']=implode($check2,',');
                }

                $map['name']=$name;
                $map['parent_id']=$parent_id;
                $map['description']=$description;
                $map['group_id']=$group_id;

                //判断是否存在
                $arr['name']=$name;
                $count=M('RoleDepartment')->where($arr)->find();
                if(!empty($count)) throw new Exception('该部门名称已经存在');

                $res=M('RoleDepartment')->add($map);
                if(empty($res)) throw new Exception('添加失败');

                $this->success('添加成功',U('Admin/Rule/department'));

            }catch (Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }

        }else{
            $area=M('Area')->select();
            $depart=M('RoleDepartment')->select();
            $data=\Org\Nx\Data::tree($depart,'name','id','parent_id');
            $group=M('AuthGroup')->select();

            $this->assign('area',$area);
            $this->assign('data',$data);
            $this->assign('group',$group);
            $this->display('department');
        }

    }

    /*
     * 删除部门
     * 2017-11-04 15:20
     * */
    public function del_bumen()
    {
        try{

            D('RoleDepartment')->delData();

            $this->success('删除成功',U('Admin/Rule/department'));
        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }
    }

    /*
     * 修改部门
     * */
    public function editbumen()
    {
        try{

            D('RoleDepartment')->editData();
            $this->success('修改成功',U('Admin/Rule/department'));
        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }

    }


    /*
     * 添加用户  （改）
     * @param date 2017-11-03 09:35
     * */
    public function adduser()
    {
        if(IS_POST){//添加用户
            try{
                $this->handler_user();
                $this->success('添加成功',U('Admin/Rule/adduser'));
            }catch(Exception $e){
                $message=$e->getMessage();
                $this->error($message);
            }



        }else{//用户列表
            //$data=D('AuthGroupAccess')->getAllData();
            $data=M('Users')->select();
            foreach($data as $key=>&$val){
                /*$company=M('Company')->alias('c')->join('bt_users as u  on  c.cid=u.id')->where("uid={$val['id']}")->select();
                if(!empty($company)){
                    $val['company_name']=$company[0]['company'];
                }*/

                $depart=M('RoleDepartment')->where("id={$val['department_id']}")->find();
                if(!empty($depart)){
                    $val['department_name']=$depart['name'];
                }else{
                    $val['department_name']='';
                }

            }

            $depart=M('RoleDepartment')->select();
            $departdata=\Org\Nx\Data::tree($depart,'name','id','parent_id');

            $assign=array(
                'data'=>$data,
                'departdata'=>$departdata
            );
            $this->assign($assign);
            $this->display();
        }

    }


    public function handler_user()
    {
        $name=trim(I('post.name'));
        $phone=trim(I('post.phone'));
        $email=trim(I('post.email'));
        $pass=trim(I('post.pass'));
        $department_id=I('post.department_id');
        $level=I('post.level');
        $remarks=trim(I('post.remarks'));
        $status=I('post.status')+0;

        if(empty($name)) throw new Exception('用户名不能为空');
        if(empty($pass)) throw new Exception('初始密码不能为空');
        if(empty($department_id)) throw new Exception('请选择部门');
        if(empty($level)) throw new Exception('请选择用户类别');

        $map['department_id']=$department_id;
        $map['username']=$name;
        $map['password']=md5($pass);
        $map['email']=$email;
        $map['phone']=$phone;
        $map['register_time']=time();
        $map['level']=$level;
        $map['remarks']=$remarks;
        $map['status']=$status;
        $map['encrypt_pass']=encrypt_encode($pass);

        //判断是否存在
        $arr['username']=$name;
        $count=M('Users')->where($arr)->find();
        if(!empty($count)) throw new Exception('该用户名已经注册过了');

        $res=M('Users')->add($map);

        if(empty($res)) throw new Exception('添加失败');

        return true;
    }

    /*
    * 删除管理员
    * @Param date 2017-11-03 10:31
    * */
    public function del_user()
    {
        $id=I('get.id');
        $result=M('Users')->where("id={$id}")->delete();
        if ($result) {
            $this->success('删除成功',U('Admin/Rule/adduser'));
        }else{
            $this->error('删除失败');
        }
    }
    /*
     * 修改
     * */
    public function edit_user()
    {
        try{
            $edit_name=trim(I('post.edit_name'));
            $user_id=I('post.user_id')+0;
            $edit_phone=trim(I('post.edit_phone'));
            $edit_pass=trim(I('post.edit_pass'));
            $edit_department_id=trim(I('post.edit_department_id'));
            $edit_level=trim(I('post.edit_level'));
            $edit_remarks=trim(I('post.edit_remarks'));
            $edit_email=trim(I('post.edit_email'));
            $status=trim(I('post.status'));

            if(empty($user_id)) throw new Exception('刷新重试');
            if(empty($edit_name)) throw new Exception('用户名不能为空');
            if(empty($edit_department_id)) throw new Exception('请选择部门');
            if(empty($edit_level)) throw new Exception('请选择用户类别');

            if(!empty($edit_pass)){
                $map['password']=md5($edit_pass);
                $map['encrypt_pass']=encrypt_encode($edit_pass);
            }
            $map['department_id']=$edit_department_id;
            $map['username']=$edit_name;
            $map['email']=$edit_email;
            $map['phone']=$edit_phone;
            $map['level']=$edit_level;
            $map['remarks']=$edit_remarks;
            $map['status']=$status;

            //判断是否存在
            $arr['username']=$edit_name;
            $arr['id']=array('NEQ',$user_id);
            $count=M('Users')->where($arr)->find();
            if(!empty($count)) throw new Exception('该用户名已经注册过了');

            $res=M('Users')->where("id={$user_id}")->save($map);
            if(empty($res)) throw new Exception('修改失败');

            $this->success('修改成功',U('Admin/Rule/adduser'));
        }catch(Exception $e){
            $message=$e->getMessage();
            $this->error($message);
        }
    }


}
