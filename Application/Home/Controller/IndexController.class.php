<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
	public function index(){
//	    先注册登录用户
        session('uid',1);
//        if(isset($_SESSION['uid'])){
//            session('uid',1);
//        }
		$this->display();
	}
}