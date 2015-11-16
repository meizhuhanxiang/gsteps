<?php
namespace Home\Controller;
use Think\Controller;
vendor("weibo2.config");
vendor("weibo2.saetv2");
/**
 * 首页控制器
 * @package Home\Controller
 */
class IndexController extends CommonController {
	/**
	 * 系统首页
	 */
	public function register(){
		if (IS_POST) {
			$user = D('users');
			if (!$info = $user->create()) {
				header("Content-type: text/html; charset=utf-8");
				exit($user->getError());
			}
			if(!$user->where(array('idstr' => $_SESSION["idstr"]))->count()){
				$info["profile"] = $_SESSION["profile"];
				$info["sex"] = $_SESSION["sex"];
				$info["lastip"] = $_SESSION['lastip'];
				$info["lasttime"] = $_SESSION['lasttime'];
				$info["jointime"] = $_SESSION['jointime'];
				$info["idstr"] = $_SESSION["idstr"];
				if ($id = $user->add($info)) {
					if($_SESSION['last_url']){
						$this->redirect($_SESSION['last_url']);
					}else{
						$this->redirect('Index/info');
					}
				} else{
					redirect(U('Index/callback'));
				}
			}
		}else{
			redirect(U('Index/register'));
		}
		
	}
	function info(){
		$idstr = $_SESSION["idstr"];
		$user = M('users')
		->field('idstr, name, admin, jointime')
		->where(array('idstr' => $idstr))
		->find();
		
		$score = M('score as s')
		->field('s.user_id, s.admin_id, s.score, ac.time, ac.content, ac.id')
		->join("join activity as ac on s.activity_id=ac.id")
		->where(array('s.user_id' => $idstr))
		->select();
		$score = M()->query("select s.score, ac.time, ac.content, ac.id, ac.user_id from activity as ac left join (select * from score where user_id='".$idstr."') s on s.activity_id=ac.id;");
		$score = M()->query("select s.score, ac.time, ac.content, ac.id, ac.user_id from score as s left join activity as ac  on s.activity_id=ac.id where s.user_id='".$idstr."';");
		$info =  array();
		$info["user"]=$user;
		$info["score"] = $score;
		$this->assign($info);
		//var_dump($info);
		$this->display();
	}
}