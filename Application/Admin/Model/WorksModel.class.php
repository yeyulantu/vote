<?php
namespace Admin\Model;
use Think\Model;
/**
 * 作品模型
 */
class WorksModel extends Model {
	
	public $jsonInfo='';
	public $isError=false;
	public $errors=array();
	
    /**
	 * 作品列表
	 * @param $args 参数
	 * @return Array
	 */
	public function getWorksList($args=array()){
		
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
			"works"=>$infos,
			"page"=>$page,
			"config"=>$r,
			"count"=>$count
		);
		return $data;
	}
	
	/**
	 * 查找一条作品根据id
	 * @param $id 作品id
	 * @return Array
	 */
	public function getWorksinfo($id){
		return $this->where(array('id'=>$id))->find();
	}
	
	/**
	 * 增加或修改作品
	 * @param $id 作品id
	 * @return Array
	 */
	public function addOrSave($id=0){
		
		//获取数据
		$data=I('post.');
		$errors=array();
		$msg='';
		
		if(!isset($_GET['aid'])){
			$errors[]=array("textCode"=>'illegal','msg'=>"非法操作");
		}
		
		// 检查数据
		if(strlen($data['title'])<=0){
			$errors[]=array("textCode"=>'title','msg'=>"请填写标题");
		}
		if(strlen($data['description'])<=0){
			$errors[]=array("textCode"=>'description','msg'=>"请填写简介");
		}
		if(isset($data['img'])){
			if(empty($data['img'])||count($data['img'])<=0){
				$errors[]=array("textCode"=>'img','msg'=>"请上传至少一张图片");
			}
		}
		if(strlen($data['telephone'])<=0){
			$errors[]=array("textCode"=>'telephone','msg'=>"必须填写电话");
		}else{
			if(!preg_match("/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8})|((0\d{2}-\d{8}(-\d{1,4})?)|(0\d{3}-\d{7,8}(-\d{1,4})?))$/",$data['telephone'])){
				$errors[]=array("textCode"=>'telephone','msg'=>"电话格式不正确");
			}
		}
		// if(strlen($data['province'])<=0){
			// $errors[]=array("textCode"=>'province','msg'=>"请选择省份");
		// }
		// if(strlen($data['city'])<=0){
			// $errors[]=array("textCode"=>'city','msg'=>"请选择城市");
		// }
		// if(strlen($data['district'])<=0){
			// $errors[]=array("textCode"=>'district','msg'=>"请填写县区");
		// }
		if(strlen($data['company'])<=0){
			$errors[]=array("textCode"=>'company','msg'=>"请填写单位科室");
		}
		
		if(!empty($errors)){
			$this->errors=$errors;
			$this->isError=true;
			$this->jsonInfo=json_encode(array('status'=>0,"msg"=>$this->errors));
			return $this;
		}
		
		$secureData=array(
			"title"=>trim($data['title']),
			"description"=>trim($data['description']),
			"telephone"=>trim($data['telephone']),
			"province"=>trim($data['province']),
			"city"=>trim($data['city']),
			"district"=>trim($data['district']),
			"company"=>trim($data['company']),
		);
		if(isset($data['img'])){
			$secureData["images"]=json_encode($data['img']);//兼容后台处理
		}
		if($id>0){
			$res=$this->where(array("id"=>$id))->save($secureData);
			$msg="更新数据";
			//$url=$_SERVER['HTTP_REFERER'];//从哪来回哪去
			$url=U("works/index",array('aid'=>$_GET['aid']),'',true);
		}else{
			$secureData['time']=time();
			$secureData['user_id']=session("uid");
			$secureData['aid']=$_GET['aid'];
			$res=$this->add($secureData);
			$msg="增加数据";
			//$url=U('Home/activities/set',array('aid'=>$res));
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
	 * 删除作品
	 * @param (Int|Array) $id 作品id
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
	
	/**
	 * 分组统计作品票数
	 * @param (Int|Array) $aid 作品id
	 * @return Object
	 */
	public function worksVoteGroup($aid){
		$grpInfo=M("Works")
			->field("count(id) as cnt")
			->where(array("user_id"=>session('uid'),"aid"=>$aid))
			->group("elt(interval(likes,0,1,51,101,1001),'t1','t2','t3','t4','t5')")
			->select();
		
		$counts=array();
		foreach($grpInfo as $key=>$val){
			$counts[]=$val['cnt'];
		}
		return $counts;
	}
}