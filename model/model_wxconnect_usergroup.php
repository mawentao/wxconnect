<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//
class model_wxconnect_usergroup
{
	// 参考 source/admincp/admincp_usergroups.php 中的代码
	public function usergroupselect()
	{
		$groupselect = array();
        foreach(C::t('common_usergroup')->fetch_all_not(array(6, 7), true) as $group) {
            $group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
            $groupselect[$group['type']] .= "<option value=\"$group[groupid]\">$group[grouptitle]</option>\n";
        }    
        $groupselect = '<option value="0">'.wxconnect_utils::piconv('UTF-8',CHARSET,'空').'</option>'.
			'<optgroup label="'.lang('admincp','usergroups_member').'">'.$groupselect['member'].'</optgroup>'.
            ($groupselect['special'] ? '<optgroup label="'.lang('admincp','usergroups_special').'">'.$groupselect['special'].'</optgroup>' : ''). 
            ($groupselect['specialadmin'] ? '<optgroup label="'.lang('admincp','usergroups_specialadmin').'">'.$groupselect['specialadmin'].'</optgroup>': '').
            '<optgroup label="'.lang('admincp','usergroups_system').'">'.$groupselect['system'].'</optgroup>'.
			'';
        //$usergroupselect = '<select name="target[]" size="10" multiple="multiple">'.$groupselect.'</select>';
        $usergroupselect = '<select id="groupid-sel" name="groupid">'.$groupselect.'</select>';
		return $usergroupselect;
	}
}
// vim600: sw=4 ts=4 fdm=marker syn=php
?>
