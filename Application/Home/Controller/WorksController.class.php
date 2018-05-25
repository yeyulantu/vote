<?php
namespace Home\Controller;
use Think\Controller;
class WorksController extends Controller {
    
	public function index(){
		$p=1;
		if(isset($_POST['p'])){
			$p=$_POST['p'];
		}
		$_GET['p']=$p;
		$res=D("Admin/Works")->getWorksList(array("pagesize"=>5,"where"=>array("user_id"=>3,"aid"=>$_GET['aid'])));
		if(!IS_POST){
			$this->assign("works",$res['works']);
			$this->display();
		}else{
			$html='';
			if(!empty($res['works'])){
				foreach($res['works'] as $key=>$value){
					$html.='<div class="activity-item">';
					$html.='<div class="activity-title media">';
					$html.='<a href="#">';
					$html.='<div class="media-left">';
					$html.='<img class="img-responsive" src="'.WEB_STYLE.'/'.json_decode($value['images'],true)[0].'"/>';
					$html.='</div>';
					$html.='<div class="media-body">';
					$html.='<p>编号：'.$value['id'].'<span class="pull-right text-pink">好评'.$value['likes'].'</span></p>';
					$html.='<p>标题'.$value['title'].'</p>';
					$html.='<p>电话'.$value['telephone'].'</p>';
					$html.='<p>单位'.$value['company'].'</p>';
					$html.='<p>地址'.$value['province'].$value['city'].'</p>';
					$html.='</div>';
					$html.='</a>';
					$html.='</div>';
					$html.='<div class="works-manage">';
					$html.='<a href="#"><i class="glyphicon glyphicon-thumbs-up active"></i>(<span class="thumbs-up-count">'.$value['likes'].'</span>)</a><a href="'.U('works/add',array('aid'=>$value['aid'],'wid'=>$value['id'])).'">编辑</a><a href="javascript:;" class="del" data-id="'.$value['id'].'">删除</a>';
					$html.='</div>';
					$html.='</div>';
				}
			}
			echo json_encode(array('p'=>$p+1,'msg'=>$html));
		}
	}
	
	public function peoplesay(){
		$p=1;
		if(isset($_POST['p'])){
			$p=$_POST['p'];
		}
		$_GET['p']=$p;
		$where=array();
		$where['user_id']=1;//模拟登录用户
		$where['aid']=$_GET['aid'];
		$where['order']='id ASC';//默认按照id升序排序
		if(isset($_GET['s'])&&($_GET['s']=='a')){
			$where['order']='likes DESC';//排序为likes降序排序
		}
		$where['aid']=$_GET['aid'];
		$res=D("Admin/Works")->getWorksList(array("pagesize"=>5,"where"=>$where));
		if(!IS_POST){
			$this->assign("works",$res['works']);
			$this->display();
		}else{
			$html='';
			if(!empty($res['works'])){
				foreach($res['works'] as $key=>$value){
					$html.='<div class="activity-item">';
					$html.='<div class="activity-title media">';
					$html.='<a href="#">';
					$html.='<div class="media-left">';
					$html.='<img class="img-responsive" src="'.WEB_STYLE.'/'.json_decode($value['images'],true)[0].'"/>';
					$html.='</div>';
					$html.='<div class="media-body">';
					$html.='<p>编号：'.$value['id'].'<span class="pull-right text-pink">好评'.$value['likes'].'</span></p>';
					$html.='<p>标题'.$value['title'].'</p>';
					$html.='<p>电话'.$value['telephone'].'</p>';
					$html.='<p>单位'.$value['company'].'</p>';
					$html.='<p>地址'.$value['province'].$value['city'].'</p>';
					$html.='</div>';
					$html.='</a>';
					$html.='</div>';
					$html.='<div class="works-manage">';
					$html.='<a href="#"><i class="glyphicon glyphicon-thumbs-up active"></i>(<span class="thumbs-up-count">'.$value['likes'].'</span>)</a><a href="'.U('works/view',array('wid'=>$value['id'])).'">浏览</a><a href="javascript:;"><i class="glyphicon glyphicon-qrcode qrcode-img" data-param="'.U('works/view',array('wid'=>$value['id'])).'"></i></a>';
					$html.='</div>';
					$html.='</div>';
				}
			}
			echo json_encode(array('p'=>$p+1,'msg'=>$html));
		}
	}
	
	public function view(){
		$wid=$_GET['wid'];
		$wkInfo=D("Admin/Works")->getWorksinfo($wid);
		if(!empty($wkInfo)){
			$wkInfo['images']=json_decode($wkInfo['images'],true);
		}
		$this->assign("wkInfo",$wkInfo);
		$this->display();
	}
	
	public function add(){
		$aid=I('get.aid',0);
		$wid=I('get.wid',0);
		$worksModel=D("Admin/Works");
		if(!IS_POST){
			$workInfo=array();
			if($wid>0){
				$workInfo=$worksModel->getWorksinfo($wid);
				//处理图片数据
				if(!empty($workInfo)){
					$workInfo['images']=json_decode($workInfo['images'],true);
				}
			}
			$this->assign("workInfo",$workInfo);
			$this->display();
		}else{
			if(!isset($_SESSION['uid'])){
				session("uid",3);//模拟登录用户
			}
			echo $worksModel->addOrSave($wid)->jsonInfo;
		}
	}
	
	public function del(){
		$wid=I("post.wid");
		$worksModel=D("Admin/Works");
		if(IS_POST){
			echo $worksModel->del($wid)->jsonInfo;
		}
	}
	
	public function upload(){
		$upload=new \Think\Upload();
		$upload->maxSize=3*1024*1024;
		$upload->exts=array('jpg','gif','png','jpeg');
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