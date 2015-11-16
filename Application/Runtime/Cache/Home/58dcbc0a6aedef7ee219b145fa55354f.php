<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>G-STEPS CREW</title>
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
				<td class="left"><label></label></td>
				<td class="center"><img src="/Public/img/u-img1.jpg" width="94" height="34" /></td>
				<td class="right"><label onclick="loginOut(this)"
					style="border-width: 0px;">退出</label></td>
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
	<div class="content">
		<table style="margin-bottom: 50px;">
			<?php if(is_array($score)): $i = 0; $__LIST__ = $score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$s): $mod = ($i % 2 );++$i;?><tr height="59px">
				<td class="left"><?php echo ($s["content"]); ?></td>
				<td class="left"><?php echo (date('m-d H:i',$s["time"])); ?></td>
				<td><?php if(empty($s['score'])): ?>未签到<?php else: echo ($s["score"]); ?>分<?php endif; ?>
				</td>
				<td><label id="<?php echo ($s["id"]); ?>" onclick="score(this);"
					style="color: #f2b500;">&gt;</label></td>
				<?php if($_SESSION['idstr'] == 100): ?><label id="<?php echo ($s["id"]); ?>"
					onclick="score(this);" style="color: #f2b500;">&gt;</label><?php endif; ?>
			</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>

		<?php if(($user["admin"] == '0')): ?><div>
			<img id="add_activity" src="/Public/img/add_activity.png"
				width="60px" height="60px" onclick="create();" />
		</div><?php endif; ?>
	</div>
	<script>
		function loginOut() {
			var result = confirm("您确定要退出吗");
			if (result == true) {
				
				location.href = "<?php echo U('Login/logout');?>";
				//location.href = "<?php echo U('Oauth/register');?>";
			}
		}
		function create() {
			location.href = "<?php echo U('Activity/create');?>";
		}
		function score(obj) {
			location.href = "<?php echo U('Activity/show_activity');?>/activity_id/" + obj.id;
		}
	</script>
</body>
</html>