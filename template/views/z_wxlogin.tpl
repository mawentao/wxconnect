<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<%plugin_path%>/template/libs/mwt/3.2/mwt.min.css"/>
  <style>
  input[type='text'] {background:#fff;}
  </style>
  <script src="<%plugin_path%>/template/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<%plugin_path%>/template/libs/qrcode.js"></script>
  <script src="<%plugin_path%>/template/libs/requirejs/2.1.9/require.js"></script>
  <script src="<%plugin_path%>/template/libs/mwt/3.2/mwt.min.js"></script>
  <%js_script%>
  <script>
    function genqrcode(domid,url,width) {
		var qrcode = new QRCode(document.getElementById(domid), {
            width  : width,
            height : width
        }); 
        qrcode.makeCode(url);
	}
	function genlandurl()
    {
		var landurl = get_text_value("landurl");
		var lourl = v.loginurl+"&landurl="+encodeURIComponent(landurl);
		var acode = '<a href="'+lourl+'" style="color:red;" target="_blank">'+lourl+'</a>';
		jQuery("#landurl_div").html(acode);
		genqrcode('landurl_qrcode',lourl,150);
	}
    var jq=jQuery.noConflict();
    jq(document).ready(function($) {
		var acode = '<a href="'+v.loginurl+'" style="color:red;" target="_blank">'+v.loginurl+'</a>';
		jQuery("#lasdwaa").html(acode);
		genqrcode('qrdiv',v.loginurl,150);
        jQuery("#landurl_btn").click(genlandurl);
    });
  </script>
</head>
<body>
  <table class="tb tb2">
    <tr><th colspan="3" class="partition">微信入口说明</th></tr>
    <tr><td class="tipsblock" s="1">
      <ul>
        <li>微信公众号的菜单链接可以使用以下微信入口，一键登录论坛；</li>
        <li>微信登录后默认跳转到论坛首页，您可以使用url生成工具，生成带跳转页面的入口地址；</li>
        <li>微信入口地址：<span id="lasdwaa"></span></li>
        <li>（请在手机微信APP中扫描此二维码）<div id="qrdiv" style="padding:5px 20px;"></div></li>
      </ul>
    </td></tr>
  </table>
  <table class="tb tb2">
    <tr><th colspan="3" class="partition">指定微信登录后的跳转地址</th></tr>
    <tr>
      <td width='100'>登录后跳转地址：</td>
      <td width='420'><input id="landurl" value="" type="text" class="txt" style='width:400px;'></td>
      <td class='tips2'><button id='landurl_btn' class='btn'>生成登录URL</button></td>
    </tr>
    <tr><td colspan="3">
      <div id="landurl_div"></div>
      <div id="landurl_qrcode" style="padding:5px 0px;"></div>
    </td></tr>
  </table>
</body>
</html>
