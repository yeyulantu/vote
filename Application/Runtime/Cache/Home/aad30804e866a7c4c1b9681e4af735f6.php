<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>作品详情-<?php echo ($wkInfo["title"]); ?></title>
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
		
		<!-- 作品内容 -->
		<div class="container" id="works-show" style="margin-top:70px;margin-bottom:50px;">
			<div class="works-content">
				<div class="works-no-likes">
					<a href="javascript:;" class="btn btn-default border-pink">编号：<?php echo ($wkInfo["id"]); ?></a>
					<span class="pull-right works-likes"><i data-param="<?php echo U('works/view',array('wid'=>$wkInfo['id']),'',true);?>" class="glyphicon glyphicon-qrcode qrcode-img"></i></span>
					<span class="pull-right text-pink works-likes"><i class="glyphicon glyphicon-thumbs-up"></i><?php echo ($wkInfo["likes"]); ?></span>
				</div>
				<div class="works-main-content">
					<p>标题：<?php echo ($wkInfo["title"]); ?></p>
					<p>电话：<?php echo ($wkInfo["telephone"]); ?></p>
					<p>单位/科室：<?php echo ($wkInfo["company"]); ?></p>
					<p>地址：<?php echo ($wkInfo["province"]); echo ($wkInfo["city"]); ?></p>
					<div class="works-des-img">
						<p style="text-indent:25px;"><?php echo ($wkInfo["description"]); ?></p>
						<?php if(is_array($wkInfo["images"])): foreach($wkInfo["images"] as $key=>$wimg): ?><img class="img-responsive" src="<?php echo (WEB_STYLE); ?>/<?php echo ($wimg); ?>"/><?php endforeach; endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- 底部导航 -->
		<footer class="container-fluid vote-footer-nav navbar-fixed-bottom">
			<div class="row">
				<div class="col-xs-3">
					<div class="footer-nav">
						<a href="<?php echo U('activities/index',array('aid'=>$wkInfo['aid']),'',true);?>">
							<i class="glyphicon glyphicon-home"></i><br/><span class="">首页</span>
						</a>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="footer-nav">
						<a href="<?php echo U('activities/notice',array('aid'=>$wkInfo['aid']),'',true);?>">
							<i class="glyphicon glyphicon-file"></i><br/><span class="">通知</span>
						</a>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="footer-nav">
						<a href="<?php echo U('works/peoplesay',array('aid'=>$wkInfo['aid']),'',true);?>">
							<i class="glyphicon glyphicon-tasks"></i><br/><span class="">评选</span>
						</a>
					</div>
				</div>
				<div class="col-xs-3">
					<div class="footer-nav">
						<a href="<?php echo U('works/peoplesay',array('aid'=>$wkInfo['aid'],'s'=>'a'),'',true);?>">
							<i class="glyphicon glyphicon-signal"></i><br/><span class="">排行榜</span>
						</a>
					</div>
				</div>
			</div>
		</footer>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/layui/layui.all.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/qrcode/qrcode.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/vote.js"></script>
	</body>
</html>