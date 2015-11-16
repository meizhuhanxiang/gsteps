<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>gsteps</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<script src="PUBLIC/adminlte/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<script src="PUBLIC/adminlte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<style type="text/css">
body{
background: #000 none repeat scroll 0% 0%;

}
.title{
background-color: #f6cb4d;
color: #ffffff;
width:100%;
text-align:center;
}
.profile{
background-color: #f2b500;
color: #ffffff;
width:100%;
height:60px;
text-align:center;
}
.content{
background-color: #000000;
	margin:5% 5%;

}
.field{
background-color: #fff;
color: #ffffff;
border-bottom-width: 1px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
border-bottom-left-radius: 10px;
border-bottom-right-radius: 10px;
text-align:left;
}
label{
color:white;
display:none;
}
input, select {
	width: 100%;
	padding: 5px;
	margin: 10px 0;
	height:30px;
	box-sizing: border-box;
	border-radius: 5px;
	background:#fff;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-webkit-border-radius: 5px;
}
button {
	width: 100%;
	padding: 5px;
	margin: 10px 0;
	height:30px;
	box-sizing: border-box;
	border-radius: 5px;
	-webkit-border-radius: 5px;
}
</style>
</head>
<body >
<div style="width: 108%;margin-left: -5%;margin-top: -3%;"><div class="title">
注册
</div>
<div class="profile">
<img src="<?php echo ($_SESSION["profile"]); ?>" alt="头像" class="img-circle" style="margin-left:auto; margin-right:auto; border-radius:25px;vertical-align:middle;margin-top:5px;" height="50px;" width="50px;" />
</div></div>
<div class="content">
   <form class=""  action="<?php echo U('Index/register');?>" method="post">
        <label>姓名</label>
		<input type="text" id="name" name="name" class="form-control field" placeholder="姓名" value="">
		<label>部门</label>
		<input type="text" id="department" name="department" class="form-control field" placeholder="部门" value="">
		<label>职务</label>
		<input type="text" id="job" name="job" class="form-control field" placeholder="职务" value="">
		<label>邮箱</label>
		<input type="text" id="email" name="email" class="form-control field" placeholder="邮箱" value="">
		<label>手机</label>
		<input type="text" id="mobile" name="mobile" class="form-control field" placeholder="手机" value="">
		<label>微信</label>
		<input type="text" id="wechat" name="wechat" class="form-control field" placeholder="微信" value="">
		<br>
      <button type="submit" class="" style="background-color:#F2B500 !important">提交</button>
   </form>
</div>
<script>
function loginOut(){
	var result = confirm("您确定要退出吗");
	if(result==true){
		location.href = "<?php echo U('Login/logout');?>";
	}
}
function create(){
	location.href = "<?php echo U('Activity/create');?>";
}

</script>
</body>
</html>