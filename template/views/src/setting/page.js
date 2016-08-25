/* page.js, (c) 2016 mawentao */
define(function(require){
	function parse_callback_domain() {
		var url = jQuery("[name=wx_login_callback]").val();
		var domain = url.replace(/^http[s]?:\/\//i,'');
        var arr = domain.split('/');
        domain = arr[0];
        jQuery("#lcdomain").html(domain);
	}

    var o={};
    o.execute = function(){
        jQuery("[name=wx_app_id]").val(v.wx_app_id);
        jQuery("[name=wx_app_secret]").val(v.wx_app_secret);
        set_radio_value('pc_wxlogin_only',v.pc_wxlogin_only);
        set_radio_value('tc_wxlogin_only',v.tc_wxlogin_only);
		set_select_value('groupid-sel',v.groupid);
		jQuery("[name=wx_login_callback]").change(parse_callback_domain).val(v.wx_login_callback);
		parse_callback_domain();
		jQuery("#login_callback_resbtn").click(function(){
			jQuery("[name=wx_login_callback]").val(v.default_login_callback);
			parse_callback_domain();
			return false;
		});
    };
    return o;
});
