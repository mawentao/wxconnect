<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';
$plugin = "wxconnect";
$plugin_enabled = 0;
if(isset($_G['setting']['plugins']['available']) && in_array($plugin, $_G['setting']['plugins']['available'])){
    $plugin_enabled = 1;
}
$result = array (
    'env' => array (
        "charset"         => $_G['charset'],
        "discuz_version"  => $_G['setting']['version'],
        "php_version"     => phpversion(),
        'server_name'     => php_uname(),
        'server_software' => $_SERVER['SERVER_SOFTWARE'],
    ),  
    'site' => array (
        'siteurl'     => wxconnect_env::get_siteurl(),
        'sitename'    => wxconnect_env::get_sitename(),
        'admin_email' => wxconnect_env::get_admin_email(),
    ), 
    'wxconnect' => array(
        'plugin_version' => $_G['setting']['plugins']['version']["wxconnect"],
        'plugin_enabled' => $plugin_enabled,
    ),
);
wxconnect_env::result($result);
