<?php
namespace Home\Controller;
use Think\Controller;
class ActivitiesController extends Controller {
    
	public function index(){
		$aid=I('get.aid',0);
		if($aid==0){
			exit("invalid request");
		}
		$actInfo=D("Admin/Activities")->getActivityinfo($aid);
		if(empty($actInfo)){
			exit("invalid request");
		}else{
			$cfgInfo=D("Admin/Configs")->getConfigInfoByAid($aid);
			if(empty($cfgInfo)){
				exit("此活动不完整");
			}
		}
		//矫正模板路径
		$cfgInfo['value']=json_decode($cfgInfo['value'],true);
		$basePath=substr($cfgInfo['value']['tpl'],-5,1);
		$this->assign("basePath",$basePath);
		$this->assign("actInfo",$actInfo);
		$this->assign("cfgInfo",$cfgInfo);
		$this->display();
	}

    /**
     * 添加或者编辑活动
     */
	public function add(){
		$aid=I('get.aid',0);
		$actModel=D("Admin/Activities");
		if(!IS_POST){
			$actInfo=array();
			if($aid>0){
				$actInfo=$actModel->getActivityinfo($aid);
				//处理图片数据
				if(!empty($actInfo)){
					$actInfo['images']=json_decode($actInfo['images'],true);
				}
			}
			$this->assign("actInfo",$actInfo);
			$this->display();
		}else{
			if(!isset($_SESSION['uid'])){
				session("uid",1);//模拟登录用户
			}
			echo $actModel->addOrSave($aid)->jsonInfo;
		}
	}

    /**
     * 设置活动
     */
	public function set(){
		$cid=0;
		if(isset($_GET['cid'])&&!empty($_GET['cid'])){
			$cid=$_GET['cid'];
		}
		$configsModel=D("Admin/Configs");
		$config=array();
		if(!IS_POST){
			if($cid>0&&(isset($_GET['aid'])&&!empty($_GET['aid']))){
				$configInfo=$configsModel->getConfigInfo($cid);
				//检查活动信息与当前是否一致
				if($configInfo['aid']==$_GET['aid']){
					$config=json_decode($configInfo['value'],true);
				}
			}
			$this->assign("cfg",$config);
			$this->display();
		}else{
			echo $configsModel->addOrSave($cid)->jsonInfo;
		}
	}
	
	public function vote(){
		$cid=0;
		if(isset($_GET['cid'])&&!empty($_GET['cid'])){
			$cid=$_GET['cid'];
		}
		$configsModel=D("Admin/Configs");
		$config=array();
		if(!IS_POST){
			if($cid>0&&(isset($_GET['aid'])&&!empty($_GET['aid']))){
				$configInfo=$configsModel->getConfigInfo($cid);
				//检查活动信息与当前是否一致
				if($configInfo['aid']==$_GET['aid']){
					$config=json_decode($configInfo['value'],true);
				}
			}
			$this->assign("cfg",$config);
			$this->display();
		}else{
			$jsonInfo=$configsModel->addOrSave($cid)->jsonInfo;
			if(!$configsModel->isError){
				$temp=json_decode($jsonInfo,true);
				//修改跳转链接
				if(isset($_POST['openvote'])){
					$temp['url']=U('activities/me');//我的发布的活动列表
				}
				if(isset($_POST['uploaddata'])){
					$temp['url']=U('workd/index',array('aid'=>$_GET['aid'],'cid'=>$_GET['cid']));//上传资料区域
				}
				$jsonInfo=json_encode($temp);
			}
			echo $jsonInfo;
		}
	}
	
	public function me(){
		$p=1;
		if(isset($_POST['p'])){
			$p=$_POST['p'];
		}
		$_GET['p']=$p;
		$res=D("Admin/Activities")->getActivityList(array("pagesize"=>5,"where"=>array("user_id"=>session("uid"))));
		if(!IS_POST){
			$this->assign("activities",$res['activities']);
			$this->display();
		}else{
			$html='';
			if(!empty($res['activities'])){
				foreach($res['activities'] as $key=>$value){
					$html.='<div class="activity-item">';
					$html.='<div class="activity-title">';
					$html.='<a href="'.U('activities/statistics',array('aid'=>$value['id']),'',true).'">'.$value['title'].'</a>';
					$html.='</div>';
					$html.='<div class="activity-manage">';
					$html.='<a href="'.U('activities/statistics',array('aid'=>$value['id']),'',true).'">统计</a><a href="'.U('activities/add',array('aid'=>$value['id']),'',true).'">编辑</a><a href="'.U('works/index',array('aid'=>$value['id']),'',true).'">作品/选手管理</a><a href="javascript:;" class="qrcode-img" data-param="'.U('activities/index',array('aid'=>$value['id'])).'"><i class="glyphicon glyphicon-qrcode"></i></a>';
					$html.='</div>';
					$html.='</div>';
				}
			}
			echo json_encode(array('p'=>$p+1,'msg'=>$html));
		}
	}
	
	public function all(){
		$p=1;
		if(isset($_POST['p'])){
			$p=$_POST['p'];
		}
		$_GET['p']=$p;
		$res=D("Admin/Activities")->getActivityList(array("pagesize"=>5));
		if(!IS_POST){
			$this->assign("activities",$res['activities']);
			$this->display();
		}else{
			$html='';
			if(!empty($res['activities'])){
				foreach($res['activities'] as $key=>$value){
					$html.='<div class="activity-item">';
					$html.='<div class="activity-title">';
					$html.='<a href="'.U('activities/statistics',array('aid'=>$value['id']),'',true).'">'.$value['title'].'</a>';
					$html.='</div>';
					$html.='<div class="activity-info">';
					$html.='<a href="'.U('activities/index',array('aid'=>$value['id']),'',true).'">传送门</a><a href="javascript:;" class="qrcode-img" data-param="'.U('activities/index',array('aid'=>$value['id'])).'"><i class="glyphicon glyphicon-qrcode"></i></a>';
					$html.='</div>';
					$html.='</div>';
				}
			}
			echo json_encode(array('p'=>$p+1,'msg'=>$html));
		}
	}
	
	public function statistics(){
		$res=D("Admin/Works")->getWorksList(array("pagesize"=>10,"order"=>"likes DESC,attends DESC,time DESC","where"=>array("user_id"=>1,"aid"=>$_GET['aid'])));
		$this->assign("res",$res);
		$this->display();
	}
	
	public function notice(){
		$aid=I('get.aid',0);
		if($aid==0){
			exit("invalid request");
		}
		$actInfo=D("Admin/Activities")->getActivityinfo($aid);
		if(empty($actInfo)){
			exit("invalid request");
		}
		$actInfo['images']=json_decode($actInfo['images'],true);
		$this->assign("actInfo",$actInfo);
		$this->display();
	}
	
	public function upload(){
		$upload=new \Think\Upload();
		$upload->maxSize=3*1024*1024;
		$upload->exts=array('jpg','gif','png','jpeg','pdf');
		$upload->rootPath='./Public/';
		$upload->savePath='images/';
		
		$info=$upload->uploadOne($_FILES['file']);
		if(!$info) {
			$this->error($upload->getError());
		}else{
			$msg=array(
				"msg"=>"上传成功",
				'info'=>$info,
				'path'=>WEB_STYLE
			);
			$this->success($msg,'',true);
		}
	}
	
}