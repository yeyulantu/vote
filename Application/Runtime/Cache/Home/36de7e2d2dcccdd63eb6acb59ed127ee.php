<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>大众评选</title>
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
		<div class="container my-works" id="my-activity" style="margin-bottom:50px;">
			<div class="row">
				<div class="col-xs-4">
					<a href="<?php echo U('activities/index',array('aid'=>$_GET['aid']),'',true);?>" class="btn btn-blue btn-block btn-sm" style="margin-bottom:15px;">首页</a>
				</div>
				<div class="col-xs-4">
					<a href="<?php echo U('works/peoplesay',array('aid'=>$_GET['aid'],'s'=>'a'),'',true);?>" class="btn btn-blue btn-block btn-sm" style="margin-bottom:15px;">排行榜</a>
				</div>
				<div class="col-xs-4">
					<a href="<?php echo U('activities/notice',array('aid'=>$_GET['aid']),'',true);?>" class="btn btn-blue btn-block btn-sm" style="margin-bottom:15px;">活动通知</a>
				</div>
			</div>
			<!-- <a href="form.html" class="btn btn-blue btn-block" style="margin-bottom:15px;">新增作品/选手资料</a> -->
			<div class="activity-list" data-page="2">
				<?php if(is_array($works)): foreach($works as $key=>$wk): ?><div class="activity-item">
					<div class="activity-title media">
						<div class="media-left">
							<a href="<?php echo U('works/view',array('wid'=>$wk['id']),'',true);?>">
								<img class="img-responsive" src="<?php echo (WEB_STYLE); ?>/<?php echo (array_shift(json_decode($wk['images'],true))); ?>"/>
							</a>
						</div>
						<div class="media-body">
							<p>编号:<?php echo ($wk["id"]); ?><span class="pull-right text-pink">好评<?php echo ($wk["likes"]); ?></span></p>
							<p>标题:<?php echo ($wk["title"]); ?></p>
							<p>电话:<?php echo ($wk["telephone"]); ?></p>
							<p>单位:<?php echo ($wk["company"]); ?></p>
							<p>地址:<?php echo ($wk["province"]); echo ($wk["city"]); ?></p>
						</div>
					</div>
					<div class="works-manage">
						<a href="#"><i class="glyphicon glyphicon-thumbs-up active"></i>(<span class="thumbs-up-count"><?php echo ($wk["likes"]); ?></span>)</a><a href="<?php echo U('works/view',array('wid'=>$wk['id']),'',true);?>">浏览</a><a href="javascript:;"><i data-param="<?php echo U('works/view',array('wid'=>$wk['id']),'',true);?>" class="glyphicon glyphicon-qrcode qrcode-img"></i></a>
					</div>
				</div><?php endforeach; endif; ?>
			</div>
		</div>
		<!-- 底部导航 -->
		<!-- <footer class="container-fluid vote-footer-nav navbar-fixed-bottom"> -->
			<!-- <div class="row"> -->
				<!-- <div class="col-xs-6"> -->
					<!-- <div class="footer-nav"> -->
						<!-- <a href="index.html"> -->
							<!-- <i class="glyphicon glyphicon-home"></i><br/><span class="">首页</span> -->
						<!-- </a> -->
					<!-- </div> -->
				<!-- </div> -->
				<!-- <div class="col-xs-6"> -->
					<!-- <div class="footer-nav"> -->
						<!-- <a href="me.html"> -->
							<!-- <i class="glyphicon glyphicon-user"></i><br/><span class="">我</span> -->
						<!-- </a> -->
					<!-- </div> -->
				<!-- </div> -->
			<!-- </div> -->
		<!-- </footer> -->
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/layui/layui.all.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/qrcode/qrcode.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/dropload/js/dropload.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/vote.js"></script>
		<script type="text/javascript">
			//下拉加载更多活动
			$(".my-works").dropload({
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
							layer.msg('Ajax error!',{time:1000},function(){
								// 即使加载出错，也得重置
								me.resetload();
							});
						}
					});
				}
			});
		</script>
	</body>
</html>