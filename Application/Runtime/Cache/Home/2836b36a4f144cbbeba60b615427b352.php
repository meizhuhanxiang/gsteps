<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

<title>创建活动</title>

<script src="/Public/datetime/js/jquery.1.7.2.min.js" type="text/javascript"></script>
<script src="/Public/datetime/js/mobiscroll_002.js" type="text/javascript"></script>

<script src="/Public/datetime/js/mobiscroll.js" type="text/javascript"></script>
<script src="/Public/datetime/js/mobiscroll_003.js" type="text/javascript"></script>
<link href="/Public/css/common.css" rel="stylesheet" type="text/css" >

<style type="text/css">
body{
	background: #262626 none repeat scroll 0% 0%;
	margin: 0;
	height: 100%;
}
.title {
	background-color: #f6cb4d;
	color: #ffffff;
	padding: 10px;
	text-align: center;
	font-size: 17px;
}

.profile {
	background-color: #f2b500;
	color: #ffffff;
	padding: 10px;
	text-align: center;
}
.profile .img-circle{
	width: 80px;
	height: 80px;
	overflow: hidden;
	border: 4px solid #f5c433;
	border-radius: 50px;
}
.content{
	padding: 10px;
	background-color: #262626;
	height: 100%;
}
.registercont p{
	padding: 17px 0;
	margin:0;
	clear: both;
	font-family: 0;
	border-bottom: 1px solid #474747;
	text-align: left;
}
.registercont label{
	color: #999;
	font-size: 16px;
	display: inline-block;
}
.registercont input{
	width: 80%;
	display: inline-block;
	color: #999;
	border-radius: 0;
	border: 0;
	background: none;
	font-size: 15px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	outline: none;
}
.registercont button{
	margin-top: 21px;
	width: 100%;
	height: 47px;
	line-height: 47px;
	border: 1px solid #f2b500;
	border-radius: 3px;
	background:transparent;
	color: #f2b500;
	font-size: 18px;
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
}
label{
color:white;
display:none;
}

</style>
</head>

<body>
<div class="title">
		<table>
			<tr>
				<td class="left"><label></label></td>
				<td class="center"><img src="/Public/img/u-img1.jpg" width="94" height="34" /></td>
				<td class="right"><label onclick="loginOut(this)"
					style="border-width: 0px;display:inline-block;">退出</label></td>
			</tr>
		</table>
	</div>
	<div class="profile">
		<table>
			<tr>
				<td colspan="3" class="center"><img src="<?php echo ($_SESSION["profile"]); ?>"
					alt="头像" class="img-circle" style="" /></td>
			</tr>
			<tr>
				<td class="left" valign="bottom"><font size="2">已上<?php echo (count($score)); ?>节课</font></td>
				<td class="center" valign="bottom"><font size="4"><?php echo ($user["name"]); ?></font></td>
				<td class="right" valign="bottom"><font size="2"><?php echo (date('Y-m-d',$user["jointime"])); ?>加入</font></td>
			</tr>
		</table>
	</div>
	<div class="content registercont">
		<p>
	        <label for="name">名称:</label>
			<input type="text" id="name" minlength="3" placeholder="请输入名称" required/>
		</p>	
		<p>
	        <label>时间:</label>
			<input id="poluoluo_datetime" name="poluoluo.com" type="datetime-local"/>
		</p>
		<p>
	        <label for="place">地点:</label>
			<input type="text" id="place" placeholder="请输入地点" required/>
		</p>		
		<button type="button" name="confirm" onclick="create_ajax();">确定</button>
	</div>
	<script>
	function create_ajax(){
		var name = $("#name").val();
		var time = $("#poluoluo_datetime").val();
		var place = $("#place").val();
		var url = "<?php echo U('Activity/create_ajax');?>/content/"+name+"/time/"+time+"/place/"+place;
		alert(url);
		location.href=url;
	}
	</script>
</body>
</html>