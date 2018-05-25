<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>投票点赞系统</title>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/bootstrap.min.css" rel="stylesheet"/>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/index.css" rel="stylesheet"/>
	</head>
	<body>
		<div class="bg-vote2">
			<img src="<?php echo (WEB_STYLE); ?>/home/images/vote2.png" class="img-responsive"/>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-4 col-xs-push-2">
					<div class="btn-activity">
						<a href="<?php echo U('activities/add','','',true);?>">
							<img src="<?php echo (WEB_STYLE); ?>/home/images/vote-user.png" class="img-responsive"/>
						</a>
						<a href="<?php echo U('activities/add','','',true);?>">举办活动</a>
					</div>
				</div>
				<div class="col-xs-4 col-xs-push-2">
					<div class="btn-activity">
						<a href="<?php echo U('activities/all','','',true);?>">
							<img src="<?php echo (WEB_STYLE); ?>/home/images/vote-list.png" class="img-responsive"/>
						</a>
						<a href="<?php echo U('activities/all','','',true);?>">所有活动</a>
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