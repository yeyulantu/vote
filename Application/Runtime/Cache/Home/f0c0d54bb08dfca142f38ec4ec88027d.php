<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>设置</title>
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
		<div class="container" id="activity-form">
			<div class="row">
				<form id="create-vote-set-form" action="" method="post">
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">模板</span>
						</div>
						<div class="col-xs-12">
							<div class="img-list">
								<?php if(!empty($cfg["tpl"])): ?><img class="img-item <?php if(substr($cfg['tpl'],-5)=='1.jpg'){echo 'active';} ?>" src="<?php echo (WEB_STYLE); ?>/home/images/1.jpg" alt=""/>
								<img class="img-item <?php if(substr($cfg['tpl'],-5)=='2.jpg'){echo 'active';} ?>" src="<?php echo (WEB_STYLE); ?>/home/images/2.jpg" alt=""/>
								<img class="img-item <?php if(substr($cfg['tpl'],-5)=='3.jpg'){echo 'active';} ?>" src="<?php echo (WEB_STYLE); ?>/home/images/3.jpg" alt=""/>
								<?php else: ?>
								<img class="img-item active" src="<?php echo (WEB_STYLE); ?>/home/images/1.jpg" alt=""/>
								<img class="img-item" src="<?php echo (WEB_STYLE); ?>/home/images/2.jpg" alt=""/>
								<img class="img-item" src="<?php echo (WEB_STYLE); ?>/home/images/3.jpg" alt=""/><?php endif; ?>
							</div>
							<?php if(!empty($cfg["tpl"])): ?><input type="text" id="tpl" name="tpl" value="<?php echo ($cfg["tpl"]); ?>" style="display:none;"/>
							<?php else: ?>
							<input type="text" id="tpl" name="tpl" value="<?php echo (WEB_STYLE); ?>/home/images/1.jpg" style="display:none;"/><?php endif; ?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">投票次数限制</span>
						</div>
						<div class="col-xs-12">
							<input type="text" id="vote-count" class="form-control" name="votecount" value="<?php echo ($cfg["votecount"]); ?>" placeholder="请输入投票次数限制"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">安全等级选择<font color="red">（推荐等级4）</font></span>
						</div>
						<div class="col-xs-12">
							<select class="form-control" name="safe">
								<option value="1" <?php if(($cfg["safe"]) == "1"): ?>selected<?php endif; ?>>等级一</option>
								<option value="2" <?php if(($cfg["safe"]) == "2"): ?>selected<?php endif; ?>>等级二</option>
								<option value="3" <?php if(($cfg["safe"]) == "3"): ?>selected<?php endif; ?>>等级三</option>
								<option value="4" <?php if(($cfg["safe"]) == "4"): ?>selected<?php endif; ?>>等级四</option>
								<option value="5" <?php if(($cfg["safe"]) == "5"): ?>selected<?php endif; ?>>等级五（最高）</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input type="checkbox" id="watch" name="watch" value="0" disabled/>
							<label class="title" style="position:relative;top:8px;" for="watch">关注后投票</label>
						</div>
						<div class="col-xs-12" id="contact-worker">
							<span class="text-warning" style="color:#c00;">请联系工作人员微信号</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<input type="submit" id="btn-submit-form-activity-set1" class="btn btn-blue btn-block" value="下一步"/>
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
	</body>
</html>