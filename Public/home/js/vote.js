/*!
 * vote.js
 * Time:2018/5/18
*/
$(function(){
	
	//ajax 提交表单
	$("#btn-submit-form-activity").click(function(){
		
		// 表单数据验证
		var $activityTitle=$("#activity-title").val();
		var $activityCompany=$("#activity-company").val();
		var $startsDate=$("#start-date").val();
		var $endDate=$("#end-date").val();
		
		if(trim($activityTitle).length<=0){layer.msg("请填写活动标题");return false;}
		if(trim($activityCompany).length<=0){layer.msg("请填写举办单位");return false;}
		if(trim($startsDate).length<=0){layer.msg("请选择活动开始时间");return false;}
		if(trim($endDate).length<=0){layer.msg("请选择活动结束时间");return false;}
		
		//ajax提交
		var options = {
			success:successTip,
			dataType:'json',
			resetForm:false
		};
		// $('#create-activity-form').submit(function() {
		   // $(this).ajaxSubmit(options); 
		   // return false;
		// });
		$('#create-activity-form').ajaxForm(options);
	});
	
	$("#btn-submit-form-activity-set1").click(function(){
		
		// 表单数据验证
		var $tpl=$("#tpl").val();
		var $voteCount=trim($("#vote-count").val());
		
		if(trim($tpl).length<=0){layer.msg("请选择模板");return false;}
		if($voteCount.length<=0){
			layer.msg("请填写投票次数限制");
			return false;
		}else{
			if(!/^\d+/.test($voteCount)){
				layer.msg("投票次数限制需要是数字");
				return false;
			}
		}
		
		//ajax提交
		var options = {
			success:successTip,
			dataType:'json',
			resetForm:false
		};
		// $('#create-vote-set-form').submit(function() {
		   // $(this).ajaxSubmit(options); 
		   // return false;
		// });
		$('#create-vote-set-form').ajaxForm(options);
	});
	
	$("#btn-submit-form-activity-set2").click(function(){
		
		//ajax提交
		var options = {
			success:successTip,
			dataType:'json',
			resetForm:false
		};
		// $('#create-vote-set-form2').submit(function() {
		   // $(this).ajaxSubmit(options); 
		   // return false;
		// });
		$('#create-vote-set-form2').ajaxForm(options);
	});
	
	$("#btn-submit-form-works").click(function(){
		
		// 表单数据验证
		var $worksName=$("#works-name").val();
		var $worksContent=$("#works-content").val();
		//var $worksAuthor=$("#works-author").val();
		var $authorTel=$("#author-tel").val();
		var $authorCompany=$("#author-company").val();
		
		if(trim($worksName).length<=0){layer.msg("请填写标题");return false;}
		if(trim($worksContent).length<=0){layer.msg("请填写简介");return false;}
		//if(trim($worksAuthor).length<=0){layer.msg("请填写姓名");return false;}
		if(trim($authorTel).length<=0){
			layer.msg("请填写电话");return false;
		}else{
			//正则验证电话
			var telExpress=/^(((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\d{8})|((0\d{2}-\d{8}(-\d{1,4})?)|(0\d{3}-\d{7,8}(-\d{1,4})?))$/;
			if(!telExpress.test(trim($authorTel))){
				layer.msg("电话格式不正确");return false;
			}
		}
		if(trim($authorCompany).length<=0){layer.msg("请填写单位/科室");return false;}
		
		//ajax提交
		var options = {
			success:successTip,
			dataType:'json',
			resetForm:false
		};
		// $('#create-works-form').submit(function() {
		   // $(this).ajaxSubmit(options); 
		   // return false;
		// });
		$('#create-works-form').ajaxForm(options);
	});
	
	//成功后回调函数
	function successTip(responseText,statusText){
		if(responseText.status==1){
			layer.msg(responseText.msg);
			location.href=responseText.url;
		}else{
			layer.msg(responseText.msg[0].msg);
		}
	}
	
	//去除字符串两边的空格
	function trim(str){
		var regExpress=/^\s*|\s*$/;
		return str.replace(regExpress,'');
	}
	
	//模板选择
	$("#create-vote-set-form").on("click",".img-item",function(){
		if($(this).hasClass("active")){
			//$(this).removeClass("active");
		}else{
			$(this).addClass("active").siblings(".img-item").removeClass("active");
			$("#tpl").val($(this).attr('src'));
		}
	});
	
	//关注后投票
	$("#watch").click(function(){
		if($("#watch").prop("checked")){
			$("#contact-worker").show();
		}else{
			$("#contact-worker").hide();
		}
	});
	
	//选手报名开启设置
	$("#open-vote").click(function(){
		if($("#open-vote").prop("checked")){
			$("#vote-time").slideDown();
			//取消上传资料的选中
			if($("#upload-data").prop("checked")){
				$("#upload-data").click();
			}
			//改变按钮的文字
			$("#btn-submit-form-vote-set").val("发布");
		}else{
			$("#vote-time").slideUp();
			// 选中上传资料
			$("#upload-data").click();
		}
	});
	
	//上传资料
	$("#upload-data").click(function(){
		if($("#upload-data").prop("checked")){
			$("#contact-worker").show();
			//取消选手报名的选中
			if($("#open-vote").prop("checked")){
				$("#open-vote").click();
			}
			//改变按钮的文字
			$("#btn-submit-form-vote-set").val("下一步");
		}else{
			$("#contact-worker").hide();
			//选手报名开启设置
			$("#open-vote").click();
		}
	});
	
	//发布设置表单
	$("#btn-submit-form-vote-set").click(function(){
		if($("#upload-data").prop("checked")){
			location.href="works-list.html";
		}else{
			layer.msg("发布成功",{time:1500},function(){
				location.href="me.html";
			});
		}
		return false;
	});
	
	//展示二维码弹出框
	$("#my-activity,#works-show").on("click",".qrcode-img",function(){
		var $url=$(this).attr("data-param");
		//打开弹出层
		layer.open({
			type:1,
			title:false,
			closeBtn:false,
			area:'50%',
			shade:0.3,
			id:'qrcode-alert',
			btn:["关闭"],
			btnAlign:'c',
			moveType:1,
			content:'<div id="qrcodeCanvas"></div>',
			success:function(layero){
				//创建二维码
				new QRCode("qrcodeCanvas",{
					text:$url,
					width:256,
					height:256
				});
			}
		});
	});
	
	//删除作品/选手
	$("#my-activity").on("click",".del",function(){
		//if(confirm("确定要删除吗？")!=true)return false;
		var $this=$(this);
		layer.open({
			type: 1,
			offset:'c',
			area:'80%',
			id:'works-del',
			content: '<div style="padding:10px;text-align:center;">确定要删除吗？</div>',
			btn:['是','否'],
			btnAlign:'c',
			shade:0.3,
			yes:function(){
				del($this);
			}
		});
		
		function del(obj){
			var dataId=obj.attr("data-id");
			//layer.msg("删除成功");obj.parents(".activity-item").eq(0).remove();return false;//测试
			$.ajax({
				url:delurl,
				type:"post",
				dataType:"json",
				data:{wid:dataId},
				success:function(res){
					if(res.status=='1'){
						layer.msg(res.msg,{time:1000},function(){
							layer.closeAll();
							obj.parents(".activity-item").eq(0).remove();
						});
					}
				}
			});
		}
	});
	
});