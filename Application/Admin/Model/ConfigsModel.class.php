<?php
namespace Admin\Model;
use Think\Model;
/**
 * 活动配置模型
 */
class ConfigsModel extends Model {
	
	public $jsonInfo='';
	public $isError=false;
	public $errors=array();
	
	/**
	 * 查找一条活动配置
	 * @param $id 配置id
	 * @return Array
	 */
	public function getConfigInfo($id){
		return $this->where(array('id'=>$id))->find();
	}
	
	/**
	 * 查找一条活动配置
	 * @param $aid 活动id
	 * @return Array
	 */
	public function getConfigInfoByAid($aid){
		$info=$this->where(array('aid'=>$aid))->find();
		return $info;
	}
	
	/**
	 * 查找一条活动配置
	 * @param $id 活动id
	 * @return Int
	 */
	public function getConfigId($id){
		$cid=0;
		$info=$this->where(array('aid'=>$id))->find();
		if(!empty($info)){
			$cid=$info['id'];
		}
		return $cid;
	}
	
	/**
	 * 增加或修改活动配置
	 * @param $id 配置id
	 * @return Array
	 */
    public function addOrSave($id=0){
		
		//默认配置
		$defaults=array(
			"tpl"=>'',//模板默认为空
			"votecount"=>0,//0次
			"safe"=>1,
			"watch"=>0,
			"openvote"=>0,
			"sdate"=>0,
			"edate"=>0,
			"uploaddata"=>0
		);
		$cfg=array();
		if($id>0){
			$cfgInfo=$this->getConfigInfo($id);
			$cfg=json_decode($cfgInfo['value'],true);
		}
		$r=array_merge($defaults,$cfg,I('post.'));//合并配置
		
		$errors=array();
		$aid=I("get.aid");
		
		//检查数据
		if(strlen(trim($r['tpl']))<=0){
			$errors[]=array("textCode"=>"tpl","msg"=>"请选择模板");
		}
		if(strlen(trim($r['votecount']))<=0){
			$errors[]=array("textCode"=>"vote-count","msg"=>"请填写投票次数限制");
		}else{
			if(!preg_match("/^\d+$/",trim($r['votecount']))){
				$errors[]=array("textCode"=>"vote-count","msg"=>"投票次数限制需要是数字");
			}
		}
		if(isset($_POST['openvote'])){
			if(strlen($_POST['sdate'])<=0){
				$errors[]=array("textCode"=>'sdate','msg'=>"必须选择报名开始时间");
			}
			if(strlen($_POST['edate'])<=0){
				$errors[]=array("textCode"=>'edate','msg'=>"必须选择报名结束时间");
			}
			if(strtotime($_POST['sdate'])>=strtotime($_POST['edate'])){
				$errors[]=array("textCode"=>'edate','msg'=>"活动开始时间需要小于活动结束时间");
			}
			//验证报名时间的有效性
			//$activityInfo=D("Admin/Activities")->getActivityinfo($aid);
			$r['uploaddata']=0;
		}
		if(isset($_POST['uploaddata'])){
			//重置报名时间
			$r['sdate']=0;
			$r['edate']=0;
			$r['openvote']=0;
		}
		if(!empty($errors)){
			$this->errors=$errors;
			$this->isError=true;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
			return $this;
		}
		
		$secureData=array(
			"value"=>json_encode(array(
				"tpl"=>trim($r['tpl']),
				"votecount"=>$r['votecount'],
				"safe"=>$r['safe'],
				"watch"=>$r['watch'],
				"openvote"=>$r['openvote'],
				"sdate"=>$r['sdate'],
				"edate"=>$r['edate'],
				"uploaddata"=>$r['uploaddata'],
			)),
			"aid"=>$aid
		);
		if($id>0){
			$res=$this->where(array("id"=>$id))->save($secureData);
			$msg="更新数据";
			$url=U('Home/activities/vote',array('aid'=>$aid,"cid"=>$id));
		}else{
			$res=$this->add($secureData);
			$msg="增加数据";
			$url=U('Home/activities/vote',array('aid'=>$aid,"cid"=>$res));
		}
		
		if($res!==false){
			$this->jsonInfo=json_encode(array('status'=>1,'msg'=>$msg."成功",'url'=>$url));
		}else{
			$errors[]=array("textCode"=>'exception',"msg"=>$msg."失败");
			$this->isError=true;
			$this->errors=$errors;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
		}
		return $this;
	}
	
}