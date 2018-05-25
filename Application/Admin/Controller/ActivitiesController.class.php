<?php
namespace Admin\Controller;
use Think\Controller;
class ActivitiesController extends Controller {
    
	public function index(){
		$where=array();
		$_string=array();
		if(isset($_GET['start'])&&!empty($_GET['start'])){
			//$where['start_time']=array("egt",strtotime($_GET['start']));
			$_string[]='start_time>='.strtotime($_GET['start']);
		}
		if(isset($_GET['end'])&&!empty($_GET['end'])){
			//$where['end_time']=array("elt",strtotime($_GET['end']));
			$_string[]='end_time<='.strtotime($_GET['end']);
		}
		if(isset($_GET['status'])&&!empty($_GET['status'])){
			if($_GET['status']=="未开始"){
				//$where['start_time']=array("gt",time());
				$_string[]='start_time>'.time();
			}
			if($_GET['status']=="进行中"){
				// $where['start_time']=array("elt",time());
				// $where['end_time']=array("egt",time());
				// $where['_logic']="AND";
				$_string[]='start_time<='.time().' AND end_time>='.time();
			}
			if($_GET['status']=="已结束"){
				//$where['end_time']=array("lt",time());
				$_string[]='end_time<'.time();
			}
		}
		if(!empty($_string)){
			$where['_string']=implode(" AND ",$_string);
		}
		if(isset($_GET['title'])&&!empty($_GET['title'])){
			$where['title']=array("like","%".trim($_GET['title'])."%");
		}
		$res=D("Activities")->getActivityList(array("where"=>$where));
		$this->assign("activities",$res['activities']);
		$this->assign("count",$res['count']);
		$this->assign("page",$res['page']->show());
		$this->display();
	}
	
	public function edit(){
		$aid=I("get.aid");
		$actModel=D("Activities");
		if(IS_POST){
			echo $actModel->addOrSave($aid)->jsonInfo;
		}else{
			$actInfo=$actModel->getActivityinfo($aid);
			$this->assign("actInfo",$actInfo);
			$this->display();
		}
	}
	
	public function del(){
		$aid=I("post.aid");
		$actModel=D("Activities");
		if(IS_POST){
			echo $actModel->del($aid)->jsonInfo;
		}
	}
	
}