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
	public function wechat_index(){
		$info = array();
		if(!$_SESSION['token']){
			$callback =  C("URL")."/home/oauth/wechat_callback";
			$code_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".C("APPID")."&redirect_uri=".urlencode($callback)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
			$info['aurl'] = $code_url;
			$info['auth'] = 'no';
			$this->assign($info);
			$this->display();
		}else{$info['auth'] = 'yes';
			redirect(U('Index/info'));
		}
	}
	public function wechat_callback(){
		$state = $_GET["state"];
		$code = $_GET["code"];
		if($code){
			$code_url = 
			"https://api.weixin.qq.com/sns/oauth2/access_token?appid=".C("APPID")."&secret=".C("SECRET")."&code=".$code."&grant_type=authorization_code";
			$res = file_get_contents($code_url);
			$res = json_decode($res, true);
			if(array_key_exists("access_token", $res)){
				$access_token = $res["access_token"];
				$openid = $res["openid"];
				$info_url =
				"https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$access_token."&lang=zh_CN";
				$info = file_get_contents($info_url);
				$info = json_decode($info, true);
				if(array_key_exists("openid", $info)){
					$_SESSION['token'] = $access_token;
					$_SESSION["sex"] = $info["sex"];
					$_SESSION["idstr"] = $info["openid"];
					$_SESSION['lastip'] = get_client_ip();
					$_SESSION['lasttime'] = time();
					$_SESSION["profile"] = $info["headimgurl"];
					if($user = M('users')->where(array('idstr' => $_SESSION["idstr"]))->count()){
						if($_SESSION['last_url']){
							$this->redirect($_SESSION['last_url']);
						}else{
							$this->redirect('Index/info');
						}
					}else{
						$_SESSION['jointime'] = $_SESSION['lasttime'];
						//$this->display();
						var_dump($info["sex"]);
						$this->redirect('Oauth/register');
					}
				}
			}else{
				$this->redirect('Oauth/wechat_index');
			}
			
		}else{
			$this->redirect('Oauth/wechat_index');
		}
		
	}
	public function wechat_oauth()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";
                	$contentStr = "Welcome to wechat world!";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{

        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = "mzhxguo";
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}