<?php

/**
 * Created by gaorenhua.
 * User: 597170962 <597170962@qq.com>
 * Date: 2015/6/28
 * Time: 0:19
 */
namespace Home\Controller;

use Think\Controller;

/**
 * Class LoginController
 * 
 * @package Home\Controller
 */
class LoginController extends Controller {
	/**
	 * 用户登录
	 */
	public function login() {
		// 判断提交方式
		if (IS_POST) {
			// 实例化Login对象
			$login = D ( 'login' );
			
			// 自动验证 创建数据集
			if (! $data = $login->create ()) {
				// 防止输出中文乱码
				header ( "Content-type: text/html; charset=utf-8" );
				exit ( $login->getError () );
			}
			
			// 组合查询条件
			$where = array ();
			$where ['name'] = $data ['name'];
			$result = $login->where ( $where )->field ( 'password, name, id' )->find ();
			var_dump ( $data ['password'] );
			// 验证用户名 对比 密码
			if ($result && $result ['password'] == $data ['password']) {
				// 存储session
				session ( 'name', $result ['name'] ); // 当前用户名
				session ( 'id', $result ['id'] );
				// 更新用户登录信息
				$where ['name'] = session ( 'name' );
				$data ['lastip'] = get_client_ip ();
				$data ['lasttime'] = time ();
				M ( 'users' )->where ( $where )->save ( $data ); // 更新登录时间和登录ip
				$signin_uri = session ( "SIGNIN_URI" );
				if ($signin_uri) {
					session ( "SIGNIN_URI", null );
					$index = strpos ( $signin_uri, "/Home" );
					;
					if ($index) {
						var_dump ( substr ( $signin_uri, $index ) );
						$this->redirect ( substr ( $signin_uri, $index ) );
					}
					// $this->redirect($signin_uri);
				} else {
					$this->redirect ( 'Index/index' );
				}
			} else {
				$this->error ( '登录失败,用户名或密码不正确!' );
			}
		} else {
			$this->display ();
		}
	}
	/**
	 * 用户注册
	 */
	public function register() {
		// 判断提交方式 做不同处理
		if (IS_POST) {
			// 实例化User对象
			$user = D ( 'users' );
			
			// 自动验证 创建数据集
			if (! $data = $user->create ()) {
				// 防止输出中文乱码
				header ( "Content-type: text/html; charset=utf-8" );
				exit ( $user->getError () );
			} else {
			}
			
			// 插入数据库
			if ($id = $user->add ( $data )) {
				/*
				 * 直接注册用户为超级管理员,子用户采用邀请注册的模式,
				 * 遂设置公司id等于注册用户id,便于管理公司用户
				 */
				$user->where ( "userid = $id" )->setField ( 'companyid', $id );
				$this->success ( '注册成功', U ( 'Login/login' ), 2 );
			} else {
				$this->error ( '注册失败' );
			}
		} else {
			$this->display ();
		}
	}
	
	/**
	 * 用户注销
	 */
	public function logout() {
		// 清楚所有session
		$_SESSION = Array ();
		redirect ( U('Oauth/wechat_index'));
	}
	public  function post2($url, $data) { // file_get_content
		$postdata = http_build_query ($data );
		$opts = array (
				'http' => 
				array (
						'method' => 'POST',
						'header' => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata 
				)
		);
		$context = stream_context_create ( $opts );
		$result = file_get_contents ( $url, false, $context );
		return $result;
	}
	/**
	 * 验证码
	 */
	public function verify() {
		// 实例化Verify对象
		$verify = new \Think\Verify ();
		
		// 配置验证码参数
		$verify->fontSize = 14; // 验证码字体大小
		$verify->length = 4; // 验证码位数
		$verify->imageH = 34; // 验证码高度
		$verify->useImgBg = true; // 开启验证码背景
		$verify->useNoise = false; // 关闭验证码干扰杂点
		$verify->entry ();
	}
}