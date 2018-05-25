<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends Controller {
    
	public function index(){
		$where=array();
		$_string=array();
		if(isset($_GET['start'])&&!empty($_GET['start'])){
			$_string[]='time>='.strtotime($_GET['start']);
		}
		if(isset($_GET['end'])&&!empty($_GET['end'])){
			$_string[]='time<='.strtotime($_GET['end']);
		}
		if(!empty($_string)){
			$where['_string']=implode(" AND ",$_string);
		}
		if(isset($_GET['username'])&&!empty($_GET['username'])){
			$where['nickname|truename']=array("like","%".trim($_GET['username'])."%");
		}
		$res=D("Users")->getUserList(array("where"=>$where));
		$this->assign("users",$res['users']);
		$this->assign("count",$res['count']);
		$this->assign("page",$res['page']->show());
		$this->display();
	}
	
	public function edit(){
		$id=I("get.id");
		$usersModel=D("Users");
		if(IS_POST){
			echo $usersModel->addOrSave($id)->jsonInfo;
		}else{
			$userInfo=$usersModel->getUserinfo($id);
			$this->assign("userInfo",$userInfo);
			$this->display();
		}
	}
	
	public function del(){
		$id=I("post.id");
		$usersModel=D("Users");
		if(IS_POST){
			echo $usersModel->del($id)->jsonInfo;
		}
	}
	
}