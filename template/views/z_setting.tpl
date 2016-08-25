<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<%plugin_path%>/template/libs/mwt/3.2/mwt.min.css"/>
  <script src="<%plugin_path%>/template/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="<%plugin_path%>/template/libs/requirejs/2.1.9/require.js"></script>
  <%js_script%>
  <script>
    var jq=jQuery.noConflict();
    jq(document).ready(function($) {
        require.config({
            baseUrl: "<%plugin_path%>/template/views/src/",
            packages: [
                {name:'mwt', location:'<%plugin_path%>/template/libs/mwt/3.2', main:'mwt.min'}
            ]
        });
        require(["setting/page","mwt"],function(mainpage){
            mainpage.execute(); 
        });
    });
  </script>
</head>
<body>
  <table class="tb tb2">
    <tr><th colspan="3" class="partition">使用说明</th></tr>
    <tr><td class="tipsblock" s="1">
      <ul>
        <li>本插件需要微信认证服务号支持；</li>
        <li>在使用过程中遇到任何问题，请随时与我们联系，QQ: 492108207</li>
      </ul>
    </td></tr>
  </table>

  <form method="post" action="admin.php?action=plugins&operation=config&identifier=wxconnect&pmod=z_setting">
  <table class="tb tb2">
    <tr><th colspan="3" class="partition">参数设置</th></tr>
    <tr>
      <td width='90'>微信应用ID：</td>
      <td width='200'>
        <input name="wx_app_id" value="" type="text" class="txt" style='width:400px;'>
      </td>
      <td class='tips2'>微信应用ID（AppID）</td>
    </tr>
    <tr>
      <td>微信应用密钥：</td>
      <td><input name="wx_app_secret" value="" type="text" class="txt" style='width:400px;'></td>
      <td class='tips2'>微信应用密钥（AppSecret）</td>
    </tr>
    <tr>
      <td>登录回调地址：</td>
      <td><input name="wx_login_callback" value="" type="text" class="txt" style='width:400px;'></td>
      <td class='tips2'><button id='login_callback_resbtn' class='btn'>设为默认地址</button> &nbsp;微信登录后的回调地址</td>
    </tr>
    <tr>
      <td></td>
      <td colspan='2' class='tips2'>
        请将微信网页授权回调页面域名设为：<b style="color:red;" id='lcdomain'></b>
        <a href="<%plugin_path%>/template/libs/site/wxlogin_help.png" target="_blank" style="margin-left:10px;">如何设置?</a>
      </td>
    </tr>
    <tr><th colspan="3" class="partition">偏好设置</th></tr>
    <tr>
      <td colspan="2">
        PC端只能使用微信登录：
        <label><input type="radio" name="pc_wxlogin_only" value="1">是</label>&nbsp;&nbsp;
        <label><input type="radio" name="pc_wxlogin_only" value="0">否</label>
      </td>
      <td>选择 "是" 将屏蔽PC端其他登录方式</td>
    </tr>
    <tr>
      <td colspan="2">
        移动端只能使用微信登录：
        <label><input type="radio" name="tc_wxlogin_only" value="1">是</label>&nbsp;&nbsp;
        <label><input type="radio" name="tc_wxlogin_only" value="0">否</label>
      </td>
      <td>选择 "是" 将屏蔽移动端其他登录方式（这意味着你的站点只能在微信APP中访问时才能登录）</td>
    </tr>
    <tr>
      <td colspan="2">
        微信注册用户默认用户组：
        <%usergroupselect%>
      </td>
      <td>微信注册用户的默认用户组，留空表示使用默认注册用户组</td>
    </tr>
    <tr>
      <td colspan="3">
        <input type="submit" id='subbtn' class='btn' value="提交"/>
      </td>
    </tr>
  </table>
  </form>
</body>
</html>
