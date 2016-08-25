<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 微信登录入口
 **/
require_once dirname(__FILE__)."/class/env.class.php";

// qrid
$qrid = isset($_GET['qrid']) ? $_GET['qrid'] : 0;
$landurl = isset($_GET['landurl']) ? urldecode($_GET['landurl']) : wxconnect_env::get_siteurl();

// 如果没有登录，直接微信登录（新用户自动注册）
if(!$_G['uid']){
    //1. 获取微信授权用户信息
    $userinfo = C::m("#wxconnect#wxconnect_wxapi")->getWxUserInfo();
    $openid = $userinfo['openid'];
    $row = C::t("#wxconnect#wxconnect_member")->getByOpenid($openid);
    //2. 老用户直接登录
    if (!empty($row)) {
        $uid = $row['uid'];
        // 定期更新微信用户信息和头像
        $timeout = 86400;
        $dlt = time()-$row['uptime'];
        if ($dlt>$timeout) {
            C::t("#wxconnect#wxconnect_member")->updateUserinfo($uid, json_encode($userinfo));
            if (isset($userinfo['headimgurl'])) {
                C::m("#wxconnect#wxconnect_uc")->sync_avatar($uid, $userinfo['headimgurl']);
            }
        }
        C::m("#wxconnect#wxconnect_uc")->dologin($uid);
    }
    //3. 新用户自动注册
    else {
        $nickname = diconv($userinfo['nickname'], 'UTF-8', CHARSET);
        $uid = C::m("#wxconnect#wxconnect_uc")->regist($nickname);
        C::t("#wxconnect#wxconnect_member")->save($uid,$openid,$nickname,json_encode($userinfo));
        if (isset($userinfo['headimgurl'])) {
            C::m("#wxconnect#wxconnect_uc")->sync_avatar($uid, $userinfo['headimgurl']);
        }
    }
	//wxconnect_env::getlog()->trace("wxlogin_succ\t$uid|$openid|".json_encode($userinfo));
	if ($qrid!=0) 
		C::t('#wxconnect#wxconnect_login_qrcode')->save($qrid,$uid,$openid);
}
// 若已经登录,且带qrid,说明PC端在微信登录
else {
	if ($qrid!=0) 
		C::t('#wxconnect#wxconnect_login_qrcode')->save($qrid,$_G['uid'],'');
}

// 跳转（默认首页）
header("Location: ".$landurl);
