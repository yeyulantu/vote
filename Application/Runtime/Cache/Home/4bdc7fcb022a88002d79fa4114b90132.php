<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>投票点赞系统-<?php echo ($actInfo["title"]); ?></title>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/bootstrap.min.css" rel="stylesheet"/>
		<style type="text/css">
		body{
			background:url("<?php echo (WEB_STYLE); ?>/home/images/tpl/<?php echo ($basePath); ?>/1.png") no-repeat;
			background-size: cover;
			-webkit-background-size: cover;
			-o-background-size: cover;
			background-position:center center;
			background-attachment: fixed;
		}
		.bg-vote2{
			padding:22% 10% 20%;
			text-align:center;
		}
		.bg-vote2>a{
			display:inline-block;
			max-width:50%;
		}
		.bg-vote2 p{
			color:#fff;
			font-size:3rem;
			margin-top:1rem;
			<!-- overflow:hidden; -->
			<!-- text-overflow:ellipsis; -->
			<!-- white-space:nowrap; -->
		}
		.btn-activity{
			text-align:center;
		}
		.btn-activity>a{
			color:#fff;
		}
		.technology-support{
			position:fixed;
			bottom:0;
			text-align:center;
			color:#fff;
			width:100%;
			padding-bottom:10px;
		}
		.technology-support a{
			color:#fff;
		}
		</style>
	</head>
	<body>
		<div class="bg-vote2">
			<a href="<?php echo U('activities/index',array('aid'=>$actInfo['id']),'',true);?>">
				<img src="<?php echo (WEB_STYLE); ?>/<?php echo ($actInfo["logo"]); ?>" class="img-responsive"/>
			</a>
			<p><?php echo ($actInfo["title"]); ?></p>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-4" style="padding-left:30px;padding-right:0;">
					<div class="btn-activity">
						<a class="img-icon" href="<?php echo U('activities/notice',array('aid'=>$actInfo['id']),'',true);?>">
							<img src="<?php echo (WEB_STYLE); ?>/home/images/tpl/<?php echo ($basePath); ?>/tpl-1.png" class="img-responsive"/>
						</a>
						<a href="<?php echo U('activities/notice',array('aid'=>$actInfo['id']),'',true);?>">活动通知</a>
					</div>
				</div>
				<div class="col-xs-4">
					<div class="btn-activity">
						<a class="img-icon" href="<?php echo U('works/peoplesay',array('aid'=>$actInfo['id']),'',true);?>">
							<img src="<?php echo (WEB_STYLE); ?>/home/images/tpl/<?php echo ($basePath); ?>/tpl-2.png" class="img-responsive"/>
						</a>
						<a href="<?php echo U('works/peoplesay',array('aid'=>$actInfo['id']),'',true);?>">大众评选</a>
					</div>
				</div>
				<div class="col-xs-4" style="padding-left:0;padding-right:30px;">
					<div class="btn-activity">
						<a class="img-icon" href="<?php echo U('works/peoplesay',array('aid'=>$actInfo['id'],'s'=>'a'),'',true);?>">
							<img src="<?php echo (WEB_STYLE); ?>/home/images/tpl/<?php echo ($basePath); ?>/tpl-3.png" class="img-responsive"/>
						</a>
						<a href="<?php echo U('works/peoplesay',array('aid'=>$actInfo['id'],'s'=>'a'),'',true);?>">排行榜</a>
					</div>
				</div>
			</div>
		</div>
		<div class="technology-support">
			<span>技术支持：<a href="http://www.h13.cn/">健康榜</a></span>
		</div>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
	</body>
</html>