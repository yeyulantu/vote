<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>投票点赞系统-用户列表</title>
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
  
  <body class="layui-anim layui-anim-up">
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="javascript:;">会员管理</a>
        <a>
          <cite>会员列表</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
    <div class="x-body">
      <div class="layui-row">
        <form class="layui-form layui-col-md12 x-so">
          <input class="layui-input" placeholder="开始日" name="start" id="start" value="<?php echo ($_GET['start']); ?>">
          <input class="layui-input" placeholder="截止日" name="end" id="end" value="<?php echo ($_GET['end']); ?>">
          <input type="text" name="username"  placeholder="请输入用户名或真实姓名" autocomplete="off" class="layui-input" value="<?php echo ($_GET['username']); ?>">
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
            <th>昵称</th>
			<th>真实姓名</th>
            <th>性别</th>
            <th>电话</th>
            <th>邮箱</th>
            <th>地址</th>
            <th>注册时间</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
			<?php if(!empty($users)): if(is_array($users)): foreach($users as $key=>$user): ?><tr>
				<td>
					<div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='<?php echo ($user["id"]); ?>'><i class="layui-icon">&#xe605;</i></div>
				</td>
				<td><?php echo ($user["id"]); ?></td>
				<td><?php echo ($user["nickname"]); ?></td>
				<td><?php echo ($user["truename"]); ?></td>
				<td>
					<?php switch($user["sex"]): case "1": ?>男<?php break;?>
						<?php case "2": ?>女<?php break;?>
						<?php default: ?>保密<?php endswitch;?>
				</td>
				<td><?php echo ($user["telephone"]); ?></td>
				<td><?php echo ($user["email"]); ?></td>
				<td><?php echo ($user["province"]); echo ($user["city"]); echo ($user["district"]); echo ($user["address"]); ?></td>
				<td><?php echo (date('Y-m-d H:i:s',$user["time"])); ?></td>
				<td class="td-manage">
					<a title="编辑" onclick="x_admin_show('编辑','<?php echo U('users/edit',array('id'=>$user['id']),'',true);?>',600,400)" href="javascript:;">
						<i class="layui-icon">&#xe642;</i>
					</a>
					<a title="删除" onclick="member_del(this,<?php echo ($user['id']); ?>)" href="javascript:;">
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

		/*用户-删除*/
		function member_del(obj,id){
			layer.confirm('确认要删除吗？',function(index){
				//发异步删除数据
				$.ajax({
					url:"<?php echo U('users/del');?>",
					type:"post",
					dataType:"json",
					data:{id:id},
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
					url:"<?php echo U('users/del');?>",
					type:"post",
					dataType:"json",
					data:{id:data},
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