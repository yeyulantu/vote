<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>投票点赞系统</title>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo (WEB_STYLE); ?>/home/assets/layui/css/layui.mobile.css" rel="stylesheet"/>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/vote.css" rel="stylesheet"/>
	</head>
	<body>
		<!-- 导航 -->
		<nav class="navbar navbar-fixed-top vote">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#vote-nav">
						<span class="sr-only">toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index.html" class="navbar-brand">投票点赞系统</a>
				</div>
				<div id="vote-nav" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="<?php echo U('activities/add');?>">创建投票</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- 内容 -->
		<div class="container" id="activity-form">
			<div class="row">
				<form id="create-activity-form" action="" method="post">
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">活动标题</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php echo ($actInfo["title"]); ?>" id="activity-title" class="form-control" name="title" placeholder="请输入活动标题"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">举办单位</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php echo ($actInfo["company"]); ?>" id="activity-company" class="form-control" name="company" placeholder="请输入举办单位"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">活动开始时间</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php if(!empty($actInfo["start_time"])): echo (date('Y-m-d H:i',$actInfo["start_time"])); endif; ?>" class="form-control" id="start-date" data-options="{'type':'YYYY-MM-DD hh:mm','beginYear':2010,'endYear':2088}" name="start" placeholder="请选择活动开始时间"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">活动结束时间</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php if(!empty($actInfo["end_time"])): echo (date('Y-m-d H:i',$actInfo["end_time"])); endif; ?>" class="form-control" id="end-date" data-options="{'type':'YYYY-MM-DD hh:mm','beginYear':2010,'endYear':2088}" name="end" placeholder="请选择活动结束时间"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">活动通知</span>
						</div>
						<div class="col-xs-12">
							<div class="img-list">
								<?php if(is_array($actInfo["images"])): foreach($actInfo["images"] as $key=>$act): ?><img src='<?php echo (WEB_STYLE); ?>/<?php echo ($act); ?>' class="img-item" data-md5="<?php echo vote_md5($act);?>" alt=""/><?php endforeach; endif; ?>
								<span class="upload-img" id="upload-img">+</span>
							</div>
							<div id="img-list" style="display:none;">
								<?php if(is_array($actInfo["images"])): foreach($actInfo["images"] as $key=>$act2): ?><input type="text" value='<?php echo ($act2); ?>' id="<?php echo vote_md5($act2);?>" name="img[]"/><?php endforeach; endif; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">logo</span>
						</div>
						<div class="col-xs-12">
							<div class="img-list">
								<?php if(!empty($actInfo["logo"])): ?><img src='<?php echo (WEB_STYLE); ?>/<?php echo ($actInfo["logo"]); ?>' class="img-item" alt=""/><?php endif; ?>
								<span class="upload-img" id="upload-img2">+</span>
							</div>
							<div id="img-list2" style="display:none;">
								<?php if(!empty($actInfo["logo"])): ?><input type="text" value='<?php echo ($actInfo["logo"]); ?>' name="logo"/><?php endif; ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input type="submit" id="btn-submit-form-activity" class="btn btn-blue btn-block" value="下一步"/>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		
		
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/layui/layui.all.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/jquery.date.js"></script>
		<script type="text/javascript">
			$.date('#start-date');
			$.date('#end-date');
		</script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/vote.js"></script>
		<script type="text/javascript">
			layui.use(['upload','layer'], function(){
				var upload = layui.upload;
				var layer = layui.layer;
			   
				//执行实例
				var uploadInst = upload.render({
					elem:'#upload-img',
					url:"<?php echo U('activities/upload');?>",
					done:function(res){
						var info=res.info;
						if(res.status==1){
							var imgstr='<img class="img-item" data-md5="'+info.info.md5+'" src="'+info.path+'/'+info.info.savepath+info.info.savename+'">';
							var inpstr='<input type="text" name=img[] id="'+info.info.md5+'" value="'+info.info.savepath+info.info.savename+'">';
							this.item.before(imgstr);
							$("#img-list").append(inpstr);
						}
						layer.msg(info.msg,{time:1000});
					},
					error:function(){
						
					}
				});
				
				//执行实例
				var uploadInst = upload.render({
					elem:'#upload-img2',
					url:"<?php echo U('activities/upload');?>",
					done:function(res){
						var info=res.info;
						if(res.status==1){
							var imgstr='<img class="img-item" src="'+info.path+'/'+info.info.savepath+info.info.savename+'">';
							var inpstr='<input type="text" name="logo" value="'+info.info.savepath+info.info.savename+'">';
							this.item.parent().find("img").remove();//清除以前的图片
							this.item.before(imgstr);
							$("#img-list2").html(inpstr);
						}
						layer.msg(info.msg,{time:1000});
					},
					error:function(){
						
					}
				});
			});
		</script>
		<style type="text/css">
		.img-list .layui-upload-file{display:none;}
		</style>
	</body>
</html>