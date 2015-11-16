<?php
/**
 * Created by gaorenhua.
 * User: 597170962 <597170962@qq.com>
 * Date: 2015/6/28
 * Time: 11:25
 */
namespace Home\Model;
use Think\Model;

class UsersModel extends Model {
    /**
     * 自动验证
     * self::EXISTS_VALIDATE 或者0 存在字段就验证（默认）
     * self::MUST_VALIDATE 或者1 必须验证
     * self::VALUE_VALIDATE或者2 值不为空的时候验证
     */
    protected $_validate = array(
        array('name', 'require', '姓名不能为空'),
        array('email', 'require', '邮箱不能为空'), 
        array('email', 'email', '邮箱格式不正确'),
        array('mobile', '/^1[34578]\d{9}$/', '手机号码格式不正确'),
        array('department', 'require', '部门不能为空'), 
        array('job', 'require', '职务不能为空'), 
        array('wechat', 'require', '微信不能为空'), 
        array('verify', 'verify_check', '验证码错误', 0, 'function'),
        //array('agree', 'is_agree', '请先同意网站安全协议！', 1, 'callback'), // 判断是否勾选网站安全协议
        //array('agree', 'require', '请先同意网站安全协议！', 1), // 判断是否勾选网站安全协议
    );

    /**
     * 自动完成
     */
    protected $_auto = array (
    );

    /**
     * 判断是否同意网站安全管理协议
     * @return bool
     */
    protected function is_agree()
    {
        // 获取POST数据
        $agree = I('post.agree', 0, 'intval');

        // 验证
        if ($agree) {
            return true;
        } else {
            return false;
        }
    }
}