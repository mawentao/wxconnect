<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/class/env.class.php';
class plugin_wxconnect
{
    function plugin_wxconnect() {
		//include_once template('wxconnect:hook');
	}

    public function common()
    {
		//global $_G;
		//die(json_encode($_G['setting']));
    }
	// 微信登录按钮
	public function global_login_extra() { 
		global $_G;
		if (!$_G['uid']) {
			$url = wxconnect_env::get_wxlogin_url_pc();
			$code = '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px">'.
			          '<a href="'.$url.'"><img src="'.wxconnect_env::get_wxlogin_logo().'" class="vm"></a>'.
                    '</div>';
			return $code;
		}
	}
	// 微信帐号绑定按钮
	public function global_usernav_extra1() {
		/*
		global $_G;
		if ($_G['uid']) {
			return wxconnect_tpl_user_bar();
		}*/
	}
}

class plugin_wxconnect_member extends plugin_wxconnect {
    function logging_method() {
		global $_G;
		$url = wxconnect_env::get_wxlogin_url_pc();
		$code = '<a href="'.$url.'"><img src="'.wxconnect_env::get_wxlogin_logo().'" class="vm"></a>';
		return $code;
	}
	// 屏蔽其他登录方式(仅允许微信登录)
    function logging()
    {
		$setting = C::m('#wxconnect#wxconnect_setting')->get();
		if ($setting['pc_wxlogin_only']==0) {return;}
        global $_G;
        if ($_GET["action"]=="login" && $_G['uid']==0) {
            $loginurl = wxconnect_env::get_wxlogin_url_pc();
            // 登录对话框
            if ($_GET['inajax']) {
				wxconnect_utils::loadxml('towxlogin.xml',array('loginurl'=>$loginurl));
            }
            // 直接跳转
            header('Location: ' . $loginurl);
            exit(0);
        }
    }
	// 屏蔽注册(仅允许微信登录)
	function register()
	{
		$setting = C::m('#wxconnect#wxconnect_setting')->get();
		if ($setting['pc_wxlogin_only']==0) {return;}
        global $_G;
        if ($_G['uid']==0) {
            $loginurl = wxconnect_env::get_wxlogin_url_pc();
            // 登录对话框
            if ($_GET['inajax']) {
				wxconnect_utils::loadxml('towxlogin.xml',array('loginurl'=>$loginurl));
            }
            // 直接跳转
            header('Location: ' . $loginurl);
            exit(0);
        }
	}
}
