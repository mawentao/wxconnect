<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';
$params = C::m('#wxconnect#wxconnect_setting')->get();
// 保存设置
if (isset($_POST["wx_app_id"])) { 
    foreach ($params as $key => &$item) {
		if (isset($_POST[$key])) $item = $_POST[$key];
	}
	C::t('common_setting')->update_batch(array("wxconnect_config"=>$params));
	updatecache('setting');
    $landurl = 'action=plugins&operation=config&do='.$pluginid.'&identifier=wxconnect&pmod=z_setting';
	cpmsg('plugins_edit_succeed', $landurl, 'succeed');
}
$params['default_login_callback'] = wxconnect_env::get_siteurl()."/plugin.php?id=wxconnect:wxcallback";
$tplVars = array(
    'siteurl' => wxconnect_env::get_siteurl(),
    'plugin_path' => wxconnect_env::get_plugin_path(),
    'usergroupselect' => C::m('#wxconnect#wxconnect_usergroup')->usergroupselect(),
);
wxconnect_utils::loadtpl('z_setting.tpl', $params, $tplVars);
