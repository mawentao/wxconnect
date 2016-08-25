<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__)."/class/env.class.php";
$mod = isset($_GET['mod']) ? $_GET['mod'] : 'wxlogin';
// variables
$siteurl=wxconnect_env::get_siteurl();
//$bbname=wxconnect_env::get_bbname();
$plugin_path=wxconnect_env::get_plugin_path();
$template_path=$plugin_path."/template";
$ajaxapi = $plugin_path."/index.php?version=4&module=";

// PC端微信扫码登录
if ($mod=='wxlogin') {
	// 已经登录直接跳首页
	if ($_G['uid']!=0) {
		header("Location: $siteurl");
		exit();
	}
	// PC端微信登录页面变量
	$qrid = C::t('#wxconnect#wxconnect_login_qrcode')->genQrCodeId();
	$qrurl=$siteurl."/plugin.php?id=wxconnect:wxlogin&qrid=".$qrid;
	// 语言包变量
    $lang = array (
        'title' => lang('plugin/wxconnect', 'wxlogin'), 
        'tip'   => lang('plugin/wxconnect', 'wxlogin_tip').'<br>'.$_G["setting"]["bbname"],
    );
}

include template("wxconnect:wxlogin");
