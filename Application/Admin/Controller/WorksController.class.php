<?php
namespace Admin\Controller;
use Think\Controller;
class WorksController extends Controller {
    
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
		if(isset($_GET['title'])&&!empty($_GET['title'])){
			$where['title']=array("like","%".trim($_GET['title'])."%");
		}
		$res=D("Works")->getWorksList(array("where"=>$where));
		$this->assign("works",$res['works']);
		$this->assign("count",$res['count']);
		$this->assign("page",$res['page']->show());
		$this->display();
	}
	
	public function edit(){
		$wid=I("get.wid");
		$wkModel=D("Works");
		if(IS_POST){
			echo $wkModel->addOrSave($wid)->jsonInfo;
		}else{
			$wkInfo=$wkModel->getWorksinfo($wid);
			$this->assign("wkInfo",$wkInfo);
			$this->display();
		}
	}
	
	public function del(){
		$wid=I("post.wid");
		$wkModel=D("Works");
		if(IS_POST){
			echo $wkModel->del($wid)->jsonInfo;
		}
	}
	
}