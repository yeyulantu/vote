<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>投票点赞系统-编辑活动</title>
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
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
				<label for="L_title" class="layui-form-label">
					<span class="x-red">*</span>标题
				</label>
				<div class="layui-input-inline">
					<input type="text" id="L_title" name="title" required=""
                  autocomplete="off" class="layui-input" value="<?php echo ($actInfo["title"]); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
          <div class="layui-form-item">
				<label for="L_company" class="layui-form-label">
					<span class="x-red">*</span>举办单位
				</label>
				<div class="layui-input-inline">
					<input type="text" id="L_company" name="company" required=""
                  autocomplete="off" class="layui-input" value="<?php echo ($actInfo["company"]); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
          <div class="layui-form-item">
				<label for="L_start" class="layui-form-label">
					<span class="x-red">*</span>开始时间
				</label>
				<div class="layui-input-inline">
					<input type="text" name="start" id="L_start" required=""
                  autocomplete="off" class="layui-input" value="<?php echo (date('Y-m-d H:i',$actInfo["start_time"])); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
          <div class="layui-form-item">
				<label for="L_end" class="layui-form-label">
					<span class="x-red">*</span>结束时间
				</label>
				<div class="layui-input-inline">
					<input type="text" name="end" id="L_end" required=""
                  autocomplete="off" class="layui-input" value="<?php echo (date('Y-m-d H:i',$actInfo["end_time"])); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  提交
              </button>
          </div>
      </form>
    </div>
    <script>
		layui.use(['form','layer','laydate'], function(){
			$ = layui.jquery;
			var form = layui.form
			,layer = layui.layer
			,laydate = layui.laydate;
		  
			//监听提交
			form.on('submit(add)', function(data){
				
				//收集数据
				var L_title=$("#L_title").val();
				var L_company=$("#L_company").val();
				var L_start=$("#L_start").val();
				var L_end=$("#L_end").val();
				
				if(trim(L_title).length<=0){
					$("#L_title").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写标题</span>');
					return false;
				}
				if(trim(L_company).length<=0){
					$("#L_company").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写举办单位</span>');
					return false;
				}
				if(trim(L_start).length<=0){
					$("#L_start").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须选择活动开始时间</span>');
					return false;
				}
				if(trim(L_end).length<=0){
					$("#L_end").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须选择活动结束时间</span>');
					return false;
				}
				
				var send_data={
					"title":L_title,
					"company":L_company,
					"start":L_start,
					"end":L_end
				};
				
				//发异步，把数据提交给php
				$.ajax({
					url:'',
					type:"post",
					dataType:"json",
					data:send_data,
					success:function(res){
						if(res.status==1){
							layer.alert(res.msg, {icon: 6},function () {
								// 获得frame索引
								var index = parent.layer.getFrameIndex(window.name);
								//关闭当前frame
								parent.layer.close(index);
								parent.location.reload();
							});
						}else{
							//修改失败
							var errors=res.msg;
							for(var i=0,j=errors.length;i<j;i++){
								$("#L_"+errors[i].textCode).parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* '+errors[i].msg+'</span>');
							}
						}
					}
				});
				return false;
			});
			
			
			//执行一个laydate实例
			laydate.render({
				format:'yyyy-MM-dd HH:mm',
				elem: '#L_start' //指定元素
			});

			//执行一个laydate实例
			laydate.render({
				format:'yyyy-MM-dd HH:mm',
				elem: '#L_end' //指定元素
			});
		});
		//去除字符串两边的空格
		function trim(str){
			var regExpress=/^\s*|\s*$/;
			return str.replace(regExpress,'');
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