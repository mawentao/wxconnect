<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 插件设置 
 * C::m('#wxconnect#wxconnect_setting')->get()
 **/
class model_wxconnect_setting
{
	// 获取默认配置
    public function getDefault()
    {
		$siteurl = wxconnect_env::get_siteurl();
		$plugin_path = wxconnect_env::get_plugin_path();
		$setting = array (
			'wx_app_id' => '',
			'wx_app_secret' => '',
			'wx_login_callback' => $siteurl.'/plugin.php?id=wxconnect:wxcallback',

			'pc_wxlogin_only' => 0,
			'tc_wxlogin_only' => 0,

			'groupid' => 21,
		);
		return $setting;
    }

    // 获取配置
	public function get()
	{
		$setting = $this->getDefault();
		global $_G;
		if (isset($_G['setting']['wxconnect_config'])){
			$config = unserialize($_G['setting']['wxconnect_config']);
			foreach ($setting as $key => &$item) {
				if (isset($config[$key])) $item = $config[$key];
			}
		}
		return $setting;
	}
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
