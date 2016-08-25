<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_wxconnect_login_qrcode extends discuz_table 
{
	public function __construct() {
		$this->_table = 'wxconnect_login_qrcode';
		$this->_pk = 'qrid';
		parent::__construct();
	}

	// 生成qrcode_id,通过插入一条空记录
	public function genQrCodeId() {
		$data = array (
			'uid' => 0,
			'openid' => '',
			'isdel' => 0,
		);
        return DB::insert($this->_table, $data, true);
	}

	// 更新记录
	public function save($qrid,$uid,$openid) {
		$data = array (
			'uid' => $uid,
			'openid' => $openid,
		);
		$this->update($qrid,$data);
	}

	// 根据qrid获取uid
	public function getUidByQrid($qrid) {
		$sql = "SELECT uid FROM ".DB::table($this->_table)." WHERE qrid=$qrid AND isdel=0";
        $row = DB::fetch_first($sql);
        if (!empty($row)) {
            return $row["uid"];
        }
        return 0;
	}

	// 删除qrid
	public function deleteByQrid($qrid) {
		$data = array (
			'isdel' => 1,
		);
		$this->update($qrid,$data);
	}
}
// vim600: sw=4 ts=4 fdm=marker syn=php

?>
