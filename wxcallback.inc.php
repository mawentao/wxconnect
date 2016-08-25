<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if (!isset($_GET['rui'])) {
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$siteurl = preg_replace("/\/source\/plugin.*$/i", "", $url);
	$_GET['rui'] = $siteurl;
}
$rui = urldecode($_GET["rui"]);
unset($_GET['rui']);
$sp = (strpos($rui, "?")===false) ? "?" : "&";
$rui .= $sp.toUrlParams($_GET);
Header("Location: $rui");
exit();

function toUrlParams($urlObj)
{   
	$buf = ""; 
	foreach ($urlObj as $k => $v) {
		if (strpos($v,"wxcallback")!==false) continue;
		$buff .= $k . "=" . $v . "&";
	}   
	return trim($buff, "&");
}
