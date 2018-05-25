<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>投票点赞系统-云南小陀山3日野炊</title>
		<link href="<?php echo (WEB_STYLE); ?>/home/css/bootstrap.min.css" rel="stylesheet"/>
		<style type="text/css">
		body{
			background-image: linear-gradient(right,#f7f7f7 5%,#f7f7f7 50%,#eee 95%);
			background-image: -webkit-linear-gradient(right,#f7f7f7 5%,#f7f7f7 50%,#eee 95%);
			background-image: -o-linear-gradient(right,#eee 5%,#f7f7f7 50%,#eee 95%);
			background-image: -moz-linear-gradient(right,#eee 5%,#f7f7f7 50%,#eee 95%);
		}
		.notice{
			padding:15px 0;
		}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="notice">
				<?php if(is_array($actInfo["images"])): foreach($actInfo["images"] as $key=>$aimg): ?><img src="<?php echo (WEB_STYLE); ?>/<?php echo ($aimg); ?>" class="img-responsive"/><?php endforeach; endif; ?>
			</div>
		</div>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/js/bootstrap.min.js"></script>
	</body>
</html>