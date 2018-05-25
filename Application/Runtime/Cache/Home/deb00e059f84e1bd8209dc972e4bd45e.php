<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>报名设置</title>
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
		<div class="container" id="vote-set">
			<form id="create-vote-set-form2" action="" method="post">
				<div class="form-group">
					<div class="col-xs-12">
						<input type="checkbox" <?php if(($cfg['uploaddata']==0)||($cfg['openvote']==1)){echo 'checked';} ?> id="open-vote" name="openvote" value="1"/>
						<label class="title" style="position:relative;top:8px;" for="open-vote">开启选手报名</label>
					</div>
				</div>
				<div id="vote-time" <?php if(!(($cfg['uploaddata']==0)||($cfg['openvote']==1))){echo "style='display:none;'";} ?>>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">报名开始时间</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php if(!empty($cfg["sdate"])): echo ($cfg["sdate"]); endif; ?>" class="form-control" id="start-date" data-options="{'type':'YYYY-MM-DD hh:mm','beginYear':2010,'endYear':2088}" name="sdate" placeholder="请选择报名开始时间"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<span class="title">报名结束时间</span>
						</div>
						<div class="col-xs-12">
							<input type="text" value="<?php if(!empty($cfg["edate"])): echo ($cfg["edate"]); endif; ?>" class="form-control" id="end-date" data-options="{'type':'YYYY-MM-DD hh:mm','beginYear':2010,'endYear':2088}" name="edate" placeholder="请选择报名结束时间"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<input type="checkbox" id="upload-data" name="uploaddata" value="1" <?php if(($cfg["uploaddata"]) == "1"): ?>checked<?php endif; ?>/>
						<label class="title" style="position:relative;top:8px;" for="upload-data">上传资料</label>
					</div>
					<div class="col-xs-12" id="contact-worker" <?php if(($cfg["uploaddata"]) != "1"): ?>style="display:none;"<?php endif; ?>>
						<span class="text-success">如果想批量上传，请联系工作人员</span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-12">
						<input type="submit" id="btn-submit-form-activity-set2" class="btn btn-blue btn-block" value="发布"/>
					</div>
				</div>
			</form>
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