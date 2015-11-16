<?php
namespace Home\Controller;
use Think\Controller;


/**
 * 首页控制器
 * @package Home\Controller
 */
class ActivityController extends CommonController {
	function create(){
		$this->display();
	}
	function create_ajax(){
		$activity = M('activity');
			$data=Array();
			$data["content"]=$_GET["content"];
			$data["place"]=$_GET["place"];
			$time = $_GET["time"];
			$data["time"] = strtotime($time);
			$data["user_id"] = session("idstr");
			$data["create_time"] = time();
			$data["activity_id"] = M("activity")->add($data);
			$score = array();
			$score["user_id"] = session("idstr");
			$score["admin_id"] = session("idstr");
			$score["activity_id"] = $data["activity_id"];
			M("score")->add($score);
			$data["result"] = "true";
			$this->redirect('Activity/show_activity', $data);
	}
	function show_activity(){
		$data=Array();
		if (IS_POST) {
			$activity_id=$_POST["activity_id"];
			$result = $_POST["result"];
		}else if(IS_GET){
			$activity_id=$_GET["activity_id"];
		}
	
		$activity = M()->query("select * from activity where id=".$activity_id);
		if($activity){
			$activity = $activity[0];
			$url =C('URL').U('Activity/signin').'/user_id/'.$activity["user_id"].'/activity_id/'.$activity["id"];
			$activity['url'] = base64_encode($url);
			$signin = M()->query("select u.profile, u.name, u.idstr, s.score from 
					(select * from score where score.activity_id=".$activity_id.") as s join users as u on s.user_id=u.idstr
					");
			$activity['is_signin'] = false;
			if($signin){
				foreach ($signin as $s){
					if($s['idstr']==session('idstr')){
						$activity['is_signin'] = true;
					}
				}
			}
			$activity['activity_id'] = $activity_id;
			$activity["signin"] = $signin;
			$this->assign($activity);
			$this->display();
		}


	}
	function signin(){
		$token = session("token");
		if($token){
			$data = array();
			$data["activity_id"] = $_GET["activity_id"];
			$data["admin_id"] = $_GET["user_id"];
			$data["user_id"] = session("idstr");
			if (!$data["activity_id"] || !$data["admin_id"]){
				$data["result"] = "activity_id或admin_id参数不完整";
			}
			$admin_user = M('users as u')->where(array('u.idstr'=>$data["admin_id"]))->select();
			$activity = M('activity as ac')->where(array('ac.id'=>$data["activity_id"]))->select();
			if(count($admin_user)<1||count($activity)<1){
				$data["result"] = "activity_id或admin_id参数错误";
			}
			$score = M('score as s')->where(array('s.activity_id'=>$data["activity_id"],'s.admin_id'=>$data["admin_id"],'s.user_id'=>$data["user_id"]))->select();
			if(count($score)>0){
				$data["result"] = "您已经签到过";
			}else{
				$data["score_id"] = D("score")->add($data);
				$data["result"] = "签到成功";
			}
			$this->redirect('Activity/show_activity', $data, 3, $data["result"].",正在为你跳转中。。。");
		}else{
			session("SIGNIN_URI", $_SERVER['REQUEST_URI']);
			$this->redirect('Oauth/index');
		}
	}
	function mark(){
		$data = array();
		$data["user_id"] = $_POST["user_id"];
		$data["activity_id"] = $_POST["activity_id"];
		M("score")->where("user_id=".$data["user_id"]." and activity_id=".$data["activity_id"])->setField("score", $_POST["score"]);
		$data["score"] = $_POST["score"];
		$data["result"] = "success";
		//$data['where'] = "user_id=".$data["user_id"]." and activity_id=".$data["activity_id"];
		$this->ajaxReturn($data);
	}
	function score(){

		$activity_id = $_GET["activity_id"];
		$user = M('activity as ac')
		->field('u.name, u.jointime, u.profile')
		->join('users as u on ac.user_id=u.idstr')
		->where(array('ac.id' => $activity_id))
		->find();
		
		$signin = M('activity as ac')
		->field('u.name, u.profile, ac.time, s.score')
		->join(array('score as s ON s.activity_id = ac.id', 'users as u ON u.idstr = s.user_id'))
		->where(array('ac.id' => $activity_id))
		->select();
		$info =  array();
		$info["user"]=$user;
		$info["signin"] = $signin;
		$this->assign($info);
		$this->display();
	}
	 /**
	 * 获取当前页面完整URL地址
	 */
	 function get_url() {
	    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	 }
	 function get_qrcode(){
	 	vendor("phpqrcode.phpqrcode");
	 	$url =base64_decode($_GET["url"]);
	 	// 纠错级别：L、M、Q、H
	 	$level = 'L';
	 	// 点的大小：1到10,用于手机端4就可以了
	 	$size = 10;
	 	// 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
	 	// 生成的文件名
	 	\QRcode::png($url,false, $level, $size);
	 }
	
}