<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>数据统计</title>
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
		<div class="container" id="my-activity" style="margin-bottom:80px;">
			<h3 class="lead level-header-title"><span>数据统计</span></h3>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>作品/选手名称</th>
						<th>票数</th>
						<th>参与人数</th>
						<th>排名</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($res["works"])): foreach($res["works"] as $rank=>$wk): ?><tr>
						<td><?php echo ($wk["title"]); ?></td>
						<td><?php echo ($wk["likes"]); ?></td>
						<td><?php echo ($wk["attends"]); ?></td>
						<td><?php echo ($rank+1); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>
			</table>
			<div class="page">
				<?php $res['page']->rollPage=3;echo $res['page']->show(); ?>
			</div>
			<div id="statistics-bar" style="height:250px;"></div>
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
		<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/echarts.simple.min.js"></script>
		<script type="text/javascript">
			var dom = document.getElementById("statistics-bar");
			var myChart = echarts.init(dom);
			var app = {};
			option = {
				color:['#3398DB'],
				tooltip:{},
				grid: {
					left: '3%',
					right: '4%',
					bottom: '3%',
					containLabel:true
				},
				xAxis:[{
					data : ['没票数','大于0票','大于50票','大于100票','大于1000票'],
					axisLabel:{
						rotate:45
					}
				}],
				yAxis:{},
				series:[
					{
						name:'作品/选手数量',
						type:'bar',
						barWidth: '60%',
						data:[<?php echo works_group($_GET['aid']);?>]
					}
				]
			};
			if (option && typeof option === "object") {
				myChart.setOption(option, true);
			}
       </script>
	</body>
</html>