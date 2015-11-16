<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>gsteps</title>
<meta property="wb:webmaster" content="6bfbaf7e9f5f1843" />
<link href="/Public/adminlte/bootstrap/css/bootstrap.min.css"
	rel="stylesheet" type="text/css" />
<script src="/Public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js"
	type="text/javascript"></script>
<script src="/Public/adminlte/bootstrap/js/bootstrap.min.js"
	type="text/javascript"></script>
<style>
body {
	background-color: #000000;
}

.vertical-center {
	position: absolute;
	top: 30%;
	text-align:center;
	width:100%;
}
</style>
</head>
<body>
	<?php if(($auth == 'no')): ?><a class="vertical-center"
		href="<?php echo ($aurl); ?>"><img src="/Public/img/logo.png"></img></a><?php endif; ?>
	<?php if(($auth == 'yes')): ?>yes<?php endif; ?>

	<script>
		function loginOut() {
			var result = confirm("您确定要退出吗");
			if (result == true) {
				location.href = "<?php echo U('Login/logout');?>";
			}
		}
		function create() {
			location.href = "<?php echo U('Activity/create');?>";
		}
	</script>
</body>
</html>