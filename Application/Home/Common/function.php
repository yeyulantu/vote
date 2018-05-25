<?php

/**
 * md5函数
 * @param $str 参数
 * @return String
 */
function vote_md5($str){
	return md5($str.time());
}

/**
 * 分组统计作品数据
 * @param $aid 作品id
 * @return String
 */
function works_group($aid){
	$counts=D("Admin/Works")->worksVoteGroup($aid);
	return implode(",",$counts);
}
?>