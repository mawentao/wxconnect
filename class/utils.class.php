<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
class wxconnect_utils
{
    public static function to_utf8($str) {
        return self::piconv(CHARSET, "UTF-8", $str);
    }

/*
    public static function to_site_charset($str_utf8)
    {   
        return self::piconv("UTF-8",CHARSET,$str_utf8);
    }
*/

    public static function piconv($from_charset, $to_charset, $str)
    {
		if(function_exists('iconv')){
			$str = @iconv($from_charset, $to_charset.'//ignore', $str);
		}else{
			$str = @mb_convert_encoding($str, $to_charset, $from_charset);
		}
		return $str;
    }

    public static function loadxml($xml,$vars=null)
    {
        $tplfile = dirname(__FILE__)."/../template/xml/$xml";
        $content = @file_get_contents($tplfile);
        if (false === $content) { 
			$content = $tplfile." 不存在或无权限读取";
        } else {
			// 替换变量
			if (is_array($vars)) {
		    	foreach($vars as $key => $value){
                	$content = str_replace("<%".$key."%>",$value,$content);
            	}
        	}
		}
        $charset = strtolower(CHARSET);
        if (is_string($content) && $charset!='utf-8' && $charset!='utf8') {
            $content = self::piconv('UTF-8', CHARSET, $content);
        }
		echo $content;
		exit(0);
    }

    public static function loadtpl($tpl, $vars ,$tplVars=null)
    {
		$tplfile = dirname(__FILE__)."/../template/views/$tpl";
        $content = @file_get_contents($tplfile);
        if (false === $content) {
            return false;
        }
        $json = json_encode($vars);
        $js_script = '<script type="text/javascript"> v = eval(\'(' . $json . ")');</script>\n";
        $charset = strtolower(CHARSET);
        if (is_string($content) && $charset!='utf-8' && $charset!='utf8') {
            $content = self::piconv('UTF-8', CHARSET, $content);
        }
		$tplVars['js_script'] = $js_script;
		$tplVars['app_charset'] = CHARSET;
		if (is_array($tplVars)) {
		    foreach($tplVars as $key => $value){
                $content = str_replace("<%".$key."%>",$value,$content);
                $content = str_replace("<% ".$key." %>",$value,$content);
            }
        }
		echo $content;
    }
    // 整型id加密
    public static function encodeId($intid) 
    {   
        if (!is_int($intid) && !is_numeric($intid)) {
            return $intid;
        }   
        $id = ($intid & 0x0000ff00) << 16; 
        $id += (($intid & 0xff000000) >> 8) & 0x00ff0000;
        $id += ($intid & 0x000000ff) << 8;
        $id += ($intid & 0x00ff0000) >> 16; 
        $id ^= 457854;
        return $id;
    }   

    // 整型id解密
    public static function decodeId($intid) 
    {   
        if (!is_int($intid) && !is_numeric($intid)) {
            return $intid;
        }   
        $intid ^= 457854;
        $id = ($intid & 0x00ff0000) << 8;
        $id += ($intid & 0x000000ff) << 16; 
        $id += (($intid & 0xff000000) >> 16) & 0x0000ff00;
        $id += ($intid & 0x0000ff00) >> 8;
        return $id;
    }

}
?>
