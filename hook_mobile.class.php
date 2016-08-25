<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once dirname(__FILE__).'/class/env.class.php';

class mobileplugin_wxconnect
{
    function common()
    {
    }

	function global_wxconnect()
	{
	}
}

class mobileplugin_wxconnect_member extends mobileplugin_wxconnect 
{
	function logging_bottom_mobile() 
	{
		global $_G;
		$loginurl = $_G['siteurl']."/plugin.php?id=wxconnect:wxlogin";
		$imgsrc = $_G['siteurl']."/source/plugin/wxconnect/template/libs/site/wechat.png";
        $btntxt = lang('plugin/wxconnect', 'wxlogin');
		$str = <<<EOF
<a href="$loginurl" style="display:block;text-decoration:none;color:#fff;background:#5eb95e;width:100%;text-align:center;
padding:6px 0;font-size:16px;border-radius:4px;">
  <img src="$imgsrc" style="height:30px;display:inline;vertical-align:bottom;margin:0 0 -2px;"> $btntxt
</a>
EOF;
		return $str;
	}
	// 屏蔽其他登录方式(仅允许微信登录)
	function logging()
	{
		$setting = C::m('#wxconnect#wxconnect_setting')->get();
		if ($setting['tc_wxlogin_only']==0) {return;}
        global $_G;
		if ($_G['uid']==0) {
			$loginurl = $_G['siteurl']."/plugin.php?id=wxconnect:wxlogin";
			header('Location: ' . $loginurl);
			exit(0);
		}
	}
	// 屏蔽注册(仅允许微信登录)
	function register()
	{
		$setting = C::m('#wxconnect#wxconnect_setting')->get();
		if ($setting['tc_wxlogin_only']==0) {return;}
        global $_G;
		if ($_G['uid']==0) {
			$loginurl = $_G['siteurl']."/plugin.php?id=wxconnect:wxlogin";
			header('Location: ' . $loginurl);
			exit(0);
		}
	}
}
