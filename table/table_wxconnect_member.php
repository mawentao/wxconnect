<?php
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_wxconnect_member extends discuz_table 
{
	public function __construct() {
		$this->_table = 'wxconnect_member';
		$this->_pk = 'uid';
		parent::__construct();
	}

    public function getByOpenid($openid)
    {
        $sql = "SELECT * FROM ".DB::table($this->_table)." WHERE openid='$openid'";
		//wxconnect_env::getlog()->trace($sql);
        $row = DB::fetch_first($sql);
        if (!empty($row)) {
            return $row;
        }
        return array();
    }

    public function getUidByOpenid($openid)
    {
        $sql = "SELECT uid FROM ".DB::table($this->_table)." WHERE openid='$openid'";
        $row = DB::fetch_first($sql);
        if (!empty($row)) {
            return $row["uid"];
        }
        return 0;
    }

    public function updateUserinfo($uid,$userinfo)
    {
        $data = array (
            'userinfo' => $userinfo,
            'uptime'   => time(),
        );
        $this->update($uid, $data);
    }

    public function save($uid,$openid,$nickname,$userinfo)
    {
        $addtime = $uptime = time();
        $data = array (
            "uid" => $uid,
            "openid" => $openid,
            "nickname" => $nickname,
            "userinfo" => $userinfo,
            "addtime" => $addtime,
            "uptime" => $uptime,
        );
        DB::insert($this->_table,$data);
    }

    public function query()
    {
		$return = array(
            "totalProperty" => 0,
            "root" => array(),
        );
        $key    = isset($_REQUEST["key"]) ? wxconnect_utils::piconv("UTF-8",CHARSET,$_REQUEST["key"]) : "";
        $sort   = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : "addtime";
        $dir    = isset($_REQUEST["dir"]) ? $_REQUEST["dir"] : "DESC";
        $start  = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 0;
        $limit  = isset($_REQUEST["limit"]) ? $_REQUEST["limit"] : 20;

        $where = "1";
        if ($key!="") {
            if (is_numeric($key)) {
                $where.= " AND a.uid='$key'";
            } else {
				$where.= " AND (a.nickname like '%$key%' or b.username like '%$key%')";
            }
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS a.uid,a.openid,a.nickname,a.userinfo,a.addtime,a.uptime,b.username ".
               "FROM ".DB::table($this->_table)." AS a LEFT JOIN ".DB::table("common_member")." as b on a.uid=b.uid ".
               "WHERE $where ".
               "ORDER BY `$sort` $dir ".
               "LIMIT $start,$limit";
        $query = DB::query($sql);
		while($row = DB::fetch($query)) {
            $item = json_decode($row['userinfo'], true);
            $item['uid'] = $row['uid'];
            $item['username'] = wxconnect_utils::to_utf8($row["username"]);
            $item['addtime'] = date("Y-m-d H:i:s", $row["addtime"]);
            $item['uptime'] = date("Y-m-d H:i:s", $row["uptime"]);
			$return["root"][] = $item;
		}
        $query = DB::query("select FOUND_ROWS() AS total");
        if ($row = DB::fetch($query)) {
            $return["totalProperty"] = $row["total"];
        }
        return $return;
    }
}
// vim600: sw=4 ts=4 fdm=marker syn=php

?>
