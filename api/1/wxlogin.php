<?php
if (!defined('IN_WXCONNECT_API')) {
    exit('Access Denied');
}

require './source/class/class_core.php';
$discuz = C::app();
$discuz->init();
require_once PLUGIN_PATH.'/class/env.class.php';

////////////////////////////////////
// action的用户组列表（空表示全部用户组）
$actionlist = array(
    'check' => array(),
);
////////////////////////////////////
$uid = $_G['uid'];
$username = $_G['username'];
$groupid = $_G["groupid"];
$action = isset($_GET['action']) ? $_GET['action'] : "check";

try {
    if (!isset($actionlist[$action])) {
        throw new Exception('unknow action');
    }
    $groups = $actionlist[$action];
    if (!empty($groups) && !in_array($groupid, $groups)) {
        throw new Exception('illegal request');
    }
    $res = $action();
    wxconnect_env::result(array('data'=>$res));
} catch (Exception $e) {
    wxconnect_env::result(array('retcode'=>100010,'retmsg'=>$e->getMessage()));
}

// PC端微信登录轮询检查
function check()
{
	global $uid;
	if ($uid==0) {
	    $qrid = $_GET['qrid'];
	    $uid = C::t("#wxconnect#wxconnect_login_qrcode")->getUidByQrid($qrid);
	    if ($uid!=0) {
			C::m("#wxconnect#wxconnect_uc")->dologin($uid);
			C::t("#wxconnect#wxconnect_login_qrcode")->deleteByQrid($qrid);
	    }
	}
    $ret = array (
		'uid' => $uid,
	);
    return $ret;
}
?>
