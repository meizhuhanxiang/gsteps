<?php
namespace Home\Controller;
use Think\Controller;
vendor("weibo2.config");
vendor("weibo2.saetv2");
/**
 * 棣栭〉鎺у埗鍣� * @package Home\Controller
 */
class OauthController extends Controller{
	/**
	 * 绯荤粺棣栭〉
	 */
	public function index(){
		$info = array();
		if(!$_SESSION['token']){
			$o = new \SaeTOAuthV2(WB_AKEY , WB_SKEY);
			$callback =  C("URL")."/home/oauth/callback";
			$code_url = $o->getAuthorizeURL($callback);
			$info['aurl'] = $code_url;
			$info['auth'] = 'no';
			$this->assign($info);
			$this->display();
		}else{$info['auth'] = 'yes';
			redirect(U('Index/info'));
		}
	}
	public function register(){
		$this->display();
	}
	
	public function callback(){
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = C("URL").'/home/index/callback';
			try {

				$o = new \SaeTOAuthV2( WB_AKEY , WB_SKEY );
				$token = $o->getAccessToken('code', $keys ) ;
				$_SESSION['token'] = $token;
				$c = new \SaeTClientV2(WB_AKEY, WB_SKEY , $_SESSION['token']['access_token']);
				$uid_get = $c->get_uid();
				$uid = $uid_get['uid'];
				$user_message = $c->show_user_by_id( $uid);//鏍规嵁ID鑾峰彇鐢ㄦ埛绛夊熀鏈俊鎭�				
				$_SESSION["profile"] = $user_message["avatar_large"];
				$sex = $user_message["gender"];
				if($sex=="m"){
					$sex=1;
				}else{
					$sex=0;
				}
				$_SESSION["sex"] = $sex;
				$_SESSION["idstr"] = $user_message["idstr"];
				$_SESSION['lastip'] = get_client_ip();
				$_SESSION['lasttime'] = time();
				//var_dump($user_message);
				$idstr = $user_message["idstr"];
				//$user = M('users')->where(array('idstr' => $idstr))->count();
				if($user = M('users')->where(array('idstr' => $idstr))->count()){
					if($_SESSION['last_url']){
						$this->redirect($_SESSION['last_url']);
					}else{
						$this->redirect('Index/info');
					}
				}else{
					$_SESSION['jointime'] = $_SESSION['lasttime'];
					//$this->display();
					$this->redirect('Oauth/register');
				}
			} catch (Exception $e) {
				$this->redirect('Oauth/index');
			}
		}else{
			redirect(U('Oauth/index'));
		}
	}
}