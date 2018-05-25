<?php
namespace Admin\Model;
use Think\Model;
/**
 * 活动模型
 */
class ActivitiesModel extends Model {
	
	public $jsonInfo='';
	public $isError=false;
	public $errors=array();
	
    /**
	 * 活动列表
	 * @param $args 参数
	 * @return Array
	 */
	public function getActivityList($args=array()){
		
		//默认配置
		$defaults=array(
			"pagesize"=>1,//每页显示10
			"order"=>"time DESC",//排序方式
			"where"=>array(),//默认条件
		);
		$r=array_merge($defaults,$args);
		
		$res=array();
		$page=null;
		
		$count=$this->where($r['where'])->count();
		$page=new \Think\Page($count,$r['pagesize']);
		
		$infos=$this->where($r['where'])->order($r['order'])->limit($page->firstRow.",".$page->listRows)->select();
		
		$data=array(
			"activities"=>$infos,
			"page"=>$page,
			"config"=>$r,
			"count"=>$count
		);
		return $data;
	}
	
	/**
	 * 查找一条活动根据id
	 * @param $id 活动id
	 * @return Array
	 */
	public function getActivityinfo($id){
		return $this->where(array('id'=>$id))->find();
	}
	
	/**
	 * 增加或修改活动
	 * @param $id 活动id
	 * @return Array
	 */
	public function addOrSave($id=0){
		
		//获取数据
		$data=I('post.');
		$errors=array();
		$msg='';
		
		// 检查数据
		if(strlen($data['title'])<=0){
			$errors[]=array("textCode"=>'title','msg'=>"必须填写标题");
		}
		if(strlen($data['company'])<=0){
			$errors[]=array("textCode"=>'company','msg'=>"必须填写举办单位");
		}
		if(strlen($data['start'])<=0){
			$errors[]=array("textCode"=>'start','msg'=>"必须选择活动开始时间");
		}
		if(strlen($data['end'])<=0){
			$errors[]=array("textCode"=>'end','msg'=>"必须选择活动结束时间");
		}
		if(strtotime($data['start'])>=strtotime($data['end'])){
			$errors[]=array("textCode"=>'end','msg'=>"活动开始时间需要小于活动结束时间");
		}
		if(isset($data['img'])){
			if(empty($data['img'])||count($data['img'])<=0){
				$errors[]=array("textCode"=>'img','msg'=>"请上传至少一张图片");
			}
		}
		if(isset($data['logo'])){
			if(empty($data['logo'])){
				$errors[]=array("textCode"=>'img','msg'=>"请上传一张logo图片");
			}
		}
		
		if(!empty($errors)){
			$this->errors=$errors;
			$this->isError=true;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
			return $this;
		}
		
		$secureData=array(
			"title"=>trim($data['title']),
			"company"=>trim($data['company']),
			"start_time"=>strtotime($data['start']),
			"end_time"=>strtotime($data['end']),
		);
		if(isset($data['img'])){
			$secureData["images"]=json_encode($data['img']);//兼容后台处理
		}
		if(isset($data['logo'])){
			$secureData["logo"]=$data['logo'];//兼容后台处理
		}
		if($id>0){
			$res=$this->where(array("id"=>$id))->save($secureData);
			$msg="更新数据";
			$cid=D("Admin/Configs")->getConfigId($id);
			if(!empty($cid)){
				$url=U('Home/activities/set',array('aid'=>$id,'cid'=>$cid));
			}else{
				$url=U('Home/activities/set',array('aid'=>$id));
			}
		}else{
			$secureData['time']=time();
			$secureData['user_id']=session("uid");
			$res=$this->add($secureData);
			$msg="增加数据";
			$url=U('Home/activities/set',array('aid'=>$res));
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
	
	/**
	 * 删除活动
	 * @param (Int|Array) $id 活动id
	 * @return Object
	 */
	public function del($id=0){
		
		if(is_array($id)){
			$where['id']=array("in",implode(",",$id));
		}else{
			$where['id']=$id;
		}
		
		$res=$this->where($where)->delete();
		if($res!==false){
			$this->jsonInfo=json_encode(array('status'=>1,'msg'=>"删除成功"));
		}else{
			$this->errors=array('status'=>0,'msg'=>"删除失败");
			$this->isError=true;
			$this->jsonInfo=json_encode($this->errors);
		}
		return $this;
	}
}