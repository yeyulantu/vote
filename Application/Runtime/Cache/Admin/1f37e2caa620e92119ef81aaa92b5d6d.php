<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>投票点赞系统-编辑作品</title>
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
                  autocomplete="off" class="layui-input" value="<?php echo ($wkInfo["title"]); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
		  <div class="layui-form-item">
				<label for="L_description" class="layui-form-label">
					<span class="x-red">*</span>描述
				</label>
				<div class="layui-input-inline">
					<textarea type="text" id="L_description" name="description" rows="5" required=""
                  autocomplete="off" class="layui-textarea"><?php echo ($wkInfo["description"]); ?></textarea>
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
		  <div class="layui-form-item">
				<label for="L_telephone" class="layui-form-label">
					<span class="x-red">*</span>电话
				</label>
				<div class="layui-input-inline">
					<input type="text" id="L_telephone" name="telephone" required=""
                  autocomplete="off" class="layui-input" value="<?php echo ($wkInfo["telephone"]); ?>">
				</div>
				<div class="layui-form-mid layui-word-aux">
					
				</div>
          </div>
		  <div class="layui-form-item">
				<label for="L_telephone" class="layui-form-label">
					<span class="x-red">*</span>地址
				</label>
				<div class="layui-input-inline" id="distpicker" data-toggle="distpicker">
					<select lay-ignore id="province" name="province" autocomplete="off" class="layui-select"></select>
					<select lay-ignore id="city" name="city" class="layui-select" autocomplete="off"></select>
					<select lay-ignore id="district" name="district" class="layui-select" autocomplete="off"></select>
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
                  autocomplete="off" class="layui-input" value="<?php echo ($wkInfo["company"]); ?>">
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
	<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/area/distpicker.data.min.js"></script>
	<script type="text/javascript" src="<?php echo (WEB_STYLE); ?>/home/assets/area/distpicker.min.js"></script>
    <script>
		layui.use(['form','layer'], function(){
			$ = layui.jquery;
			var form = layui.form
			,layer = layui.layer;
		  
			//监听提交
			form.on('submit(add)', function(data){
				
				//收集数据
				var L_title=$("#L_title").val();
				var L_description=$("#L_description").val();
				var L_telephone=$("#L_telephone").val();
				var L_company=$("#L_company").val();
				var province=$("#province").val();
				var city=$("#city").val();
				var district=$("#district").val();
				
				if(trim(L_title).length<=0){
					$("#L_title").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写标题</span>');
					return false;
				}
				if(trim(L_description).length<=0){
					$("#L_description").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写描述</span>');
					return false;
				}
				if(trim(L_telephone).length<=0){
					$("#L_telephone").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写电话</span>');
					return false;
				}else{
					//正则验证电话
					var telExpress=/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8})|((0\d{2}-\d{8}(-\d{1,4})?)|(0\d{3}-\d{7,8}(-\d{1,4})?))$/;
					if(!telExpress.test(trim(L_telephone))){
						$("#L_telephone").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 电话格式不正确</span>');
					}
				}
				if(trim(L_company).length<=0){
					$("#L_company").parents(".layui-form-item").find(".layui-word-aux").html('<span class="x-red">* 必须填写单位/科室</span>');
					return false;
				}
				
				var send_data={
					"title":L_title,
					"company":L_company,
					"description":L_description,
					"telephone":L_telephone,
					"province":province,
					"city":city,
					"district":district
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
			
		});
		//去除字符串两边的空格
		function trim(str){
			var regExpress=/^\s*|\s*$/;
			return str.replace(regExpress,'');
		}
  </script>
  <script>
	$("#distpicker").distpicker({
		province:'<?php echo ($wkInfo["province"]); ?>',
		city:'<?php echo ($wkInfo["city"]); ?>',
		district:'<?php echo ($wkInfo["district"]); ?>'
	});
  </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
	<style>
	#distpicker select{
		margin-bottom:15px;
	}
	#distpicker select:focus{
		border-color:rgb(29, 161, 148);
	}
	</style>
  </body>

</html>