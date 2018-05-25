<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>投稿</title>
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
						<li><a href="publish-activity.html">创建投票</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- 内容 -->
		<div class="container" id="works-form">
			<div class="row">
				<form id="create-works-form" action="" method="post">
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">名称</span>
						</div>
						<div class="col-xs-12">
							<input type="text" id="works-name" class="form-control" name="title" value="<?php echo ($workInfo["title"]); ?>" placeholder="请输入名称"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">简介</span>
						</div>
						<div class="col-xs-12">
							<textarea col="80" id="works-content" class="form-control" row="15" name="description" placeholder="请输入简介"><?php echo ($workInfo["description"]); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">图片</span>
						</div>
						<div class="col-xs-12">
							<div class="img-list">
								<?php if(is_array($workInfo["images"])): foreach($workInfo["images"] as $key=>$wk): ?><img src='<?php echo (WEB_STYLE); ?>/<?php echo ($wk); ?>' class="img-item" data-md5="<?php echo vote_md5($wk);?>" alt=""/><?php endforeach; endif; ?>
								<span class="upload-img" id="upload-img">+</span>
							</div>
							<div id="img-list" style="display:none;">
								<?php if(is_array($workInfo["images"])): foreach($workInfo["images"] as $key=>$wk2): ?><input type="text" value='<?php echo ($wk2); ?>' id="<?php echo vote_md5($wk2);?>" name="img[]"/><?php endforeach; endif; ?>
							</div>
						</div>
					</div>
					<!-- <div class="form-group"> -->
						<!-- <div class="col-xs-12"> -->
							<!-- <span class="title">姓名</span> -->
						<!-- </div> -->
						<!-- <div class="col-xs-12"> -->
							<!-- <input type="text" id="works-author" class="form-control" name="author" placeholder="请输入姓名"/> -->
						<!-- </div> -->
					<!-- </div> -->
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">电话</span>
						</div>
						<div class="col-xs-12">
							<input type="text" id="author-tel" class="form-control" value="<?php echo ($workInfo["telephone"]); ?>" name="telephone" placeholder="请输入电话"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">地址</span>
						</div>
						<div class="col-xs-12">
							<div class="row" id="distpicker" data-toggle="distpicker">
								<div class="col-xs-4" style="padding-right: 5px;">
									<select id="province" class="form-control" name="province"></select>
								</div>
								<div class="col-xs-4" style="padding-right: 5px;padding-left: 5px;">
									<select id="city" class="form-control" name="city"></select>
								</div>
								<div class="col-xs-4" style="padding-left: 5px;">
									<select id="district" class="form-control" name="district"></select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">单位/科室</span>
						</div>
						<div class="col-xs-12">
							<input type="text" id="author-company" value="<?php echo ($workInfo["company"]); ?>" class="form-control" name="company" placeholder="请输入单位/科室"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input type="submit" id="btn-submit-form-works" class="btn btn-blue btn-block" value="发布"/>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- 底部导航 -->
<footer class="container-fluid vote-footer-nav navbar-fixed-bottom">
	<div class="row">
		<div class="col-xs-6">
			<div class="footer-nav">
				<a href="<?php echo U('index/index','','',true);?>">
					<i class="glyphicon glyphicon-home"></i><br/><span class="">首页</span>
				</a>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="footer-nav">
				<a href="<?php echo U('activities/me','','',true);?>">
					<i class="glyphicon glyphicon-user"></i><br/><span class="">我</span>
				</a>
			</div>
		</div>
	</div>
</footer>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/layui/layui.all.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/area/distpicker.data.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/area/distpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/jquery.form.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/vote.js"></script>
		<script type="text/javascript">
			layui.use(['upload','layer'], function(){
				var upload = layui.upload;
				var layer = layui.layer;
			   
				//执行实例
				var uploadInst = upload.render({
					elem:'#upload-img',
					url:"<?php echo U('works/upload');?>",
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
			});
			
			$("#distpicker").distpicker({
				province:'<?php echo ($workInfo["province"]); ?>',
				city:'<?php echo ($workInfo["city"]); ?>',
				district:'<?php echo ($workInfo["district"]); ?>'
			});
		</script>
		<style type="text/css">
		.img-list .layui-upload-file{display:none;}
		</style>
	</body>
</html>