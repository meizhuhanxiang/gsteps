<?php
/**
 * Created by gaorenhua.
 * User: 597170962 <597170962@qq.com>
 * Date: 2015/6/29
 * Time: 21:28
 */

namespace Home\Controller;
use Think\Controller;

/**
 * 通用控制器
 * 主要用于验证是否登陆 以及 用户权限
 * @package Home\Controller
 */
class CommonController extends Controller {

	/**
	 * 自动执行
	 */
	public function _initialize()
	{
		// 判断用户是否登录
		if ($_SESSION['token']) {
		} else {
			$_SESSION['last_url'] = $this->get_url();
           	$this->redirect('Oauth/wechat_index');
        }
    }
    function get_url() {
    	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    	$php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    	$path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    	$relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
    }

}