<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';
$siteurl = wxconnect_env::get_siteurl();
$params = array(
    'siteurl'  => $siteurl,
    //'loginurl' => $siteurl.'/plugin.php?id=wxconnect:wxlogin',
    'ajaxapi'  => wxconnect_env::get_plugin_path().'/index.php?version=4&module=',
);
$tplVars = array(
    'plugin_path' => wxconnect_env::get_plugin_path(),
);
wxconnect_utils::loadtpl('z_wxmember.tpl', $params, $tplVars);
