<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>我</title>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo (WEB_STYLE); ?>/home/assets/layui/css/layui.mobile.css" rel="stylesheet"/>
		<link href="<?php echo (WEB_STYLE); ?>/home/assets/dropload/css/dropload.css" rel="stylesheet"/>
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
		<div class="container my-activity" id="my-activity" style="margin-bottom:50px;">
			<div class="activity-list" data-page="2">
				<?php if(is_array($activities)): foreach($activities as $key=>$act): ?><div class="activity-item">
					<div class="activity-title">
						<a href="<?php echo U('activities/index',array('aid'=>$act['id']),'',true);?>"><?php echo ($act["title"]); ?></a>
					</div>
					<div class="activity-info">
						<a href="<?php echo U('activities/index',array('aid'=>$act['id']),'',true);?>">传送门</a><a href="javascript:;" class="qrcode-img" data-param="<?php echo U('activities/index',array('aid'=>$act['id']),'',true);?>"><i class="glyphicon glyphicon-qrcode"></i></a>
					</div>
				</div><?php endforeach; endif; ?>
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
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/qrcode/qrcode.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/dropload/js/dropload.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/vote.js"></script>
		<script type="text/javascript">
			//下拉加载更多活动
			$(".my-activity").dropload({
				scrollArea: window,
				loadDownFn: function(me){
					$.ajax({
						url:'',
						type:'post',
						data:{p:$(".activity-list").attr("data-page")},
						dataType: 'json',
						success: function(res){
							$(".activity-list").attr("data-page",res.p);
							if(res.msg==''){
								me.lock();
								me.noData();
							}else{
								$(".activity-list").append(res.msg);
							}
							me.resetload();
						},
						error: function(xhr, type){
							layer.msg('Ajax error!');
							// 即使加载出错，也得重置
							me.resetload();
						}
					});
				}
			});
		</script>
	</body>
</html>