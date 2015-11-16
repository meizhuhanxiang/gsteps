<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>完善信息</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link href="/Public/adminlte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="/Public/adminlte/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<script src="/Public/adminlte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body >

<div style="padding: 100px 100px 10px;">

<div class="span7 text-center">
<img src="<?php echo ($user["profile"]); ?>" alt="头像" class="img-circle" style="margin-left:auto; margin-right:auto;"/><br>
<?php if(is_array($signin)): $i = 0; $__LIST__ = $signin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><img src="<?php echo ($s["profile"]); ?>" alt="头像" class="img-circle" style="margin-left:auto; margin-right:auto;"/>
<?php echo ($s["name"]); ?>
<?php echo ($s["time"]); ?>
<?php echo ($s["score"]); ?>
<button type="button" class="btn btn-info" onclick="score();">打分</button>
<br><?php endforeach; endif; else: echo "" ;endif; ?>
<?php if(($user["admin"] == '1')): ?><button type="button" class="btn btn-info" onclick="create();">+</button><?php endif; ?>
</div>

            
</div>
<script>
function score(obj){
	location.href = "<?php echo U('Activity/score');?>/activity_id/"+obj.id;
}
</script>
</body>
</html>