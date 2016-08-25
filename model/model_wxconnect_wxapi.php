<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class model_wxconnect_wxapi
{
    private $_app_id = '';
    private $_app_secret = '';
    private $_callback_url = '';

    public function __construct()
    {
        $setting = C::m("#wxconnect#wxconnect_setting")->get(); 
        $this->_app_id = $setting['wx_app_id'];
        $this->_app_secret = $setting['wx_app_secret'];
        $this->_callback_url = $setting['wx_login_callback'];
    }

    // 获取微信用户基本信息（授权登录）
    public function getWxUserInfo()
    {
        if (!isset($_GET['code'])) {
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
            $url = $this->createOauthUrlForCode($baseUrl, 'snsapi_userinfo');
			wxconnect_env::getlog()->trace("wxlogin_createOauthUrlForCode [Location: $url]");
            Header("Location: $url");
            exit();
        } else {
            $url = $this->createOauthUrlForOpenid($_GET['code']);
            $res = $this->jsonrpc($url);
			wxconnect_env::getlog()->trace("wxlogin_createOauthUrlForOpenid [rpc: $url] [res: ".json_encode($res)."]");
            $openid = $res['openid'];
            $access_token = $res['access_token'];
            $userinfo = $this->getUserInfoByAuth($access_token, $openid);
            return $userinfo;
        }
    }

    // 获取微信用户的OpenId（不包括userinfo）
    public function getOpenId()
    {
        if (!isset($_GET['code'])) {
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
            $url = $this->createOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            $url = $this->createOauthUrlForOpenid($_GET['code']);
            $res = $this->jsonrpc($url);
            return $res['openid'];
        }
    }

    // 获取微信用户授权信息
    private function getUserInfoByAuth($access_token, $openid, $lang = 'zh_CN') 
    {/*{{{*/
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=$lang";
		$data = $this->jsonrpc($url);
		wxconnect_env::getlog()->trace("wxlogin_getUserInfoByAuth [rpc: $url] [res: ".json_encode($data)."]");
        return $data;
    }/*}}}*/

    private function createOauthUrlForCode($baseUrl, $scope='snsapi_base')
    {/*{{{*/
        $sp = strpos($this->_callback_url, '?')===false ? '?' : '&';
        $redirect_uri = $this->_callback_url.$sp."rui=".$baseUrl;

        $urlObj = array (
            'appid'         => $this->_app_id,
            'redirect_uri'  => urlencode($redirect_uri),
            'response_type' => 'code',
			'scope'         => $scope,
            'state'         => "STATE"."#wechat_redirect",
        );
        $bizString = $this->toUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }/*}}}*/

    private function createOauthUrlForOpenid($code)
    {/*{{{*/
		$urlObj["appid"]      = $this->_app_id;
		$urlObj["secret"]     = $this->_app_secret;
		$urlObj["code"]       = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = $this->toUrlParams($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }/*}}}*/

    private function toUrlParams($urlObj)
    {/*{{{*/
        $buf = "";
        foreach ($urlObj as $k => $v) {
		    $buff .= $k . "=" . $v . "&";
		}
		return trim($buff, "&");
    }/*}}}*/

    private function jsonrpc($url, $post=false)
    {
		$result = dfsockopen($url);
		return json_decode($result, true);
    }
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
