<?php

/**
 * NewsAction.class.php
 * 接口文件
 * @author 正侠客 <lookcms@gmail.com>
 * @copyright 2012- http://www.dingcms.com http://www.dogocms.com All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version dogocms 1.0 2012-11-5 11:20
 * @package  Controller
 */
class NewsAction extends BaseApiAction {

    /**
     * sendEmail
     * 发送邮件-邮箱接口
     * @param string $email 接收电子邮件地址
     * @param string $subject 邮件主题
     * @param string $body 邮件信息
     * @return boolean
     * @version dogocms 1.0
     * @todo 权限验证
     */
    public function sendEmail($email, $subject, $body)
    {
        vendor('PHPMailer.PHPmail', '', '.class.php');
        $mail = new PHPmail();
        $option = array(
            'host' => 'smtp.qq.com', //发送邮件服务器
            'username' => '335499289@qq.com', //账户名
            'password' => 'dingji850521F4DD', //密码
            'from' => '335499289@qq.com', //发送电子邮件地址
            'fromname' => 'www.qiuyuntech.com', //发送邮件名称
            'reply' => '335499289@qq.com', //回复电子邮件地址
        );
        $mail->set_smtp_config($option);
        $rs = $mail->send_mail($email, $subject, $body);
        if ($rs == true) {//发送成功返回真
            return true;
        } else {//发送失败返回假
            return false;
        }
    }
     /**
     * getPwd
     * 生成密码
     * @param string $uname 用户名
     * @param string $pwd 密码明文
     * @return string
     * @version dogocms 1.0
     * @todo 禁止随意修改
     */
    public function getPwd($uname,$pwd)
    {
        return $this->getPassword($uname,$pwd);
    }
    /*
     * getCfg
     * 获取站点配置
     * @param string $name 参数名称
     * @return string
     * @version dogocms 1.0
     */

    public function getCfg($name)
    {
        $m = M('Setting');
        if ($name) {
            $condition['sys_name'] = array('eq', $name);
            $rs = $m->field('sys_value')->where($condition)->find();
            if($rs){
                return $rs['sys_value'];
            }
        } else {
            return false;
        }
    }
}
