<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>投票点赞系统-活动列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo (WEB_STYLE); ?>/admin/css/font.css">
    <link rel="stylesheet" href="<?php echo (WEB_STYLE); ?>/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/admin/js/xadmin.js"></script>
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body>
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="<?php echo U('index/index','','',true);?>">首页</a>
        <a href="javascript:;">活动管理</a>
        <a>
          <cite>活动列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
			<input class="layui-input" placeholder="开始日" name="start" id="start" value="<?php echo ($_GET['start']); ?>">
			<input class="layui-input" placeholder="截止日" name="end" id="end" value="<?php echo ($_GET['end']); ?>">
			<div class="layui-input-inline">
				<select name="status">
					<option <?php if(($_GET['status']) == ""): ?>selected<?php endif; ?>></option>
					<option <?php if(($_GET['status']) == "未开始"): ?>selected<?php endif; ?>>未开始</option>
					<option <?php if(($_GET['status']) == "进行中"): ?>selected<?php endif; ?>>进行中</option>
					<option <?php if(($_GET['status']) == "已结束"): ?>selected<?php endif; ?>>已结束</option>
				</select>
			</div>
			<input type="text" name="title"  placeholder="请输入活动标题" autocomplete="off" class="layui-input" value="<?php echo ($_GET['title']); ?>">
			<button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <span class="x-right" style="line-height:40px">共有数据：<?php echo ($count); ?> 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>ID</th>
            <th>活动标题</th>
            <th>举办单位</th>
            <th>活动开始时间</th>
            <th>活动结束时间</th>
            <th>活动状态</th>
            <th>添加时间</th>
            <th >操作</th>
            </tr>
        </thead>
        <tbody>
			<?php if(!empty($activities)): if(is_array($activities)): foreach($activities as $key=>$act): ?><tr>
				<td>
				  <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?php echo ($act["id"]); ?>'><i class="layui-icon">&#xe605;</i></div>
				</td>
				<td><?php echo ($act["id"]); ?></td>
				<td><?php echo ($act["title"]); ?></td>
				<td><?php echo ($act["company"]); ?></td>
				<td><?php echo (date("Y-m-d H:i",$act["start_time"])); ?></td>
				<td><?php echo (date("Y-m-d H:i",$act["end_time"])); ?></td>
				<td>
					<?php if($act['start_time']>time()){ echo "未开始"; }else if($act['end_time']<time()){ echo "已结束"; }else{ echo "进行中"; } ?>
				</td>
				<td><?php echo (date("Y-m-d H:i",$act["time"])); ?></td>
				<td class="td-manage">
					<a title="编辑"  onclick="x_admin_show('编辑','<?php echo U('activities/edit',array('aid'=>$act['id']),'',true);?>',600,400)" href="javascript:;">
						<i class="layui-icon">&#xe642;</i>
					</a>
					<a title="删除" onclick="member_del(this,<?php echo ($act['id']); ?>)" href="javascript:;">
						<i class="layui-icon">&#xe640;</i>
					</a>
				</td>
			</tr><?php endforeach; endif; ?>
			<?php else: endif; ?>
        </tbody>
      </table>
      <div class="page">
        <div>
          <?php echo ($page); ?>
        </div>
      </div>

    </div>
    <script>
		layui.use('laydate', function(){
			var laydate = layui.laydate;
        
			//执行一个laydate实例
			laydate.render({
			elem: '#start' //指定元素
			});

			//执行一个laydate实例
			laydate.render({
			elem: '#end' //指定元素
			});
		});

		/*活动-删除*/
		function member_del(obj,id){
			layer.confirm('确认要删除吗？',function(index){
				//发异步删除数据
				$.ajax({
					url:"<?php echo U('activities/del');?>",
					type:"post",
					dataType:"json",
					data:{aid:id},
					success:function(res){
						if(res.status==1){
							$(obj).parents("tr").remove();
						}
						layer.msg(res.msg,{icon:1,time:1000});
					}
				});
				
			});
		}
		
		function delAll (argument) {

			var data = tableCheck.getData();
  
			layer.confirm('确认要删除吗？'+data,function(index){
				//捉到所有被选中的，发异步进行删除
				$.ajax({
					url:"<?php echo U('activities/del');?>",
					type:"post",
					dataType:"json",
					data:{aid:data},
					success:function(res){
						if(res.status==1){
							$(".layui-form-checked").not('.header').parents('tr').remove();
						}
						layer.msg(res.msg,{icon:1,time:1000});
					}
				});
				
			});
		}
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
  </body>

</html>