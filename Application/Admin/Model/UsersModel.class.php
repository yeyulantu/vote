<?php
namespace Admin\Model;
use Think\Model;
/**
 * 用户模型
 */
class UsersModel extends Model {

    /**
	 * 用户列表
	 * @param $args 参数
	 * @return Array
	 */
	public function getUserList($args=array()){
		
		//默认配置
		$defaults=array(
			"pagesize"=>10,//每页显示10
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
			"users"=>$infos,
			"page"=>$page,
			"config"=>$r,
			"count"=>$count
		);
		return $data;
	}
	
	/**
	 * 查找一条用户根据id
	 * @param $id 用户id
	 * @return Array
	 */
	public function getUserinfo($id){
		return $this->where(array('id'=>$id))->find();
	}
	
	/**
	 * 增加或修改用户
	 * @param $id 活动id
	 * @return Array
	 */
	public function addOrSave($id=0){
		
		//获取数据
		$data=I('post.');
		$errors=array();
		$msg='';
		
		// 检查数据
		if(strlen($data['nickname'])<=0){
			$errors[]=array("textCode"=>'nickname','msg'=>"必须填写昵称");
		}
		if(strlen($data['truename'])<=0){
			$errors[]=array("textCode"=>'truename','msg'=>"必须填写真实姓名");
		}
		if(strlen($data['telephone'])<=0){
			$errors[]=array("textCode"=>'telephone','msg'=>"必须填写电话");
		}else{
			if(!preg_match("/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8})|((0\d{2}-\d{8}(-\d{1,4})?)|(0\d{3}-\d{7,8}(-\d{1,4})?))$/",$data['telephone'])){
				$errors[]=array("textCode"=>'telephone','msg'=>"电话格式不正确");
			}
		}
		if(strlen($data['email'])<=0){
			$errors[]=array("textCode"=>'email','msg'=>"必须填写邮箱");
		}else{
			if(!preg_match("/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/",$data['email'])){
				$errors[]=array("textCode"=>'email','msg'=>"邮箱格式不正确");
			}
		}
		
		if(!empty($errors)){
			$this->errors=$errors;
			$this->isError=true;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
			return $this;
		}
		
		$secureData=array(
			"nickname"=>trim($data['nickname']),
			"truename"=>trim($data['truename']),
			"telephone"=>trim($data['telephone']),
			"email"=>trim($data['email']),
		);
		if($id>0){
			$res=$this->where(array("id"=>$id))->save($secureData);
			$msg="更新数据";
		}else{
			$secureData['time']=time();
			$res=$this->add($secureData);
			$msg="增加数据";
		}
		
		if($res!==false){
			$this->jsonInfo=json_encode(array('status'=>1,'msg'=>$msg."成功"));
		}else{
			$errors[]=array("textCode"=>'exception',"msg"=>$msg."失败");
			$this->isError=true;
			$this->errors=$errors;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
		}
		return $this;
	}
	
	/**
	 * 删除用户
	 * @param (Int|Array) $id 用户id
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