<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>活动详情</title>
<meta
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
	name="viewport">

<link href="/Public/css/common.css" rel="stylesheet" type="text/css" />
<script src="/Public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"
	type="text/javascript"></script>
<script src="/Public/adminlte/bootstrap/js/bootstrap.min.js"
	type="text/javascript"></script>
</head>
<body>
	<div class="title">
		<table>
			<tr>
				<td class="left"><label onclick="index()">返回首页</label></td>
				<td class="center"><img src="/Public/img/u-img1.jpg" width="94" height="34" /></td>
				<td class="right"><label onclick="loginOut(this)"
					style="border-width: 0px;">退出</label></td>
			</tr>
		</table>
	</div>
	<div class="profile profile1">
		<table style="margin-top:10px;">
			<tr>
				<td class="left"></td>
				<td class="center"><label><?php echo ($content); ?></label></td>
				<td class="right"></td>
			</tr>
		</table>
		<div class="flexBox listbox">
			<span class="uheader">
					<img src="<?php echo ($_SESSION["profile"]); ?>"
					alt="头像" class="img-circle" style="" />
			</span>
			<span class="flex1 introduce">
				<em class="name"><?php echo ($content); ?></em>
				<em class="date"><?php echo (date('m月d日 H时i分',$time)); ?></em>
				<em class="place"><?php echo ($place); ?></em>
			</span>
			<span class="code2">
				<img src="<?php echo U('Activity/get_qrcode');?>/url/<?php echo ($url); ?>"/>
				<em class="code2big" style="display:none;">
					<img src="<?php echo U('Activity/get_qrcode');?>/url/<?php echo ($url); ?>"/>
				</em>
			</span>
		</div>
	</div>
	<div class="content ucenter">
		<table style="margin-bottom: 50px;">
			<?php if(is_array($signin)): $i = 0; $__LIST__ = $signin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><tr height="40px">
				<td><img src="<?php echo ($s["profile"]); ?>" alt="头像"
					class="img-circle" style="" /></td>
				<td><?php echo ($s["name"]); ?></td>
				<td>
				<span id="<?php echo ($s["idstr"]); ?>_score" style="display:block;"><?php echo ($s["score"]); ?>分</span>
				<span><input type='text' id="<?php echo ($s["idstr"]); ?>_score_input" style="display:none; width:50%"/></span>
				</td>
				
				<td><input type="button" id="<?php echo ($s["idstr"]); ?>_mark" onclick="mark('<?php echo ($s["idstr"]); ?>');" value="打分"/></td>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</div>
	<script>
	   function code(){
			$('.code2').click(function(){
				$(this).children('.code2big').show();
				event.stopPropagation();   
			})
		}	
		code();	
		$(".code2big").click(function(event){
			$(this).hide();
		}); 
		function loginOut() {
			var result = confirm("您确定要退出吗");
			if (result == true) {
				location.href = "<?php echo U('Login/logout');?>";
			}
		}
		function create() {
			location.href = "<?php echo U('Activity/create');?>";
		}
		function index() {
			location.href = "<?php echo U('Index/info');?>";
		}
		function score(obj) {
			location.href = "<?php echo U('Activity/score');?>/activity_id/" + obj.id;
		}
		function mark(idstr){
			var activity_id = <?php echo ($activity_id); ?>;
			var m = "#"+idstr+"_mark";
			var s = "#"+idstr+"_score";
			var s_i = "#"+idstr+"_score_input";
			var btn_val = $(m).val();
			if(btn_val=="打分"){
				$(m).val("确定");
				$(s).hide();
				$(s_i).show();
			}else{
				var r = /[1-5]/g;
				var res = r.exec($(s_i).val());
				if(res!=null){
					res = String(res)
			        $.ajax({
			            url: "<?php echo U('Activity/mark');?>",    //请求的url地址
			            dataType: "json",   //返回格式为json
			            async: true, //请求是否异步，默认为异步，这也是ajax重要特性
			            data: {"user_id":idstr, "activity_id": ''+ activity_id, "score": res},    //参数值
			            type: "POST",   //请求方式
			            beforeSend: function() {
			            },
			            success: function(req) {
							$(m).val("打分");
							$(s_i).hide();
							$(s).html(res+"分");
							$(s).show();
			            },
			            complete: function() {
			                //请求完成的处理
			            },
			            error: function(XMLHttpRequest, textStatus, errorThrown) {
			                console.info(XMLHttpRequest.status);
			                console.info(XMLHttpRequest.readyState);
			                console.info(textStatus);
			                alert("打分失败,请稍后重试");
			                //请求出错处理
			            }
			        });
				}else{
					alert("请输入1-5中的数字");
				}

			}
		}
	</script>
</body>
</html>