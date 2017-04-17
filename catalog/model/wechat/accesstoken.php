<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/9
 * Time: 21:46
 */
class ModelWechatAccesstoken extends Model
{
    public function editAccesstoken($accesstoken, $deadline) {
        $sql = "insert into wechat_info(accesstoken, deadline) VALUES ('".$accesstoken."','".$deadline."') ON DUPLICATE KEY UPDATE accesstoken = '" . $accesstoken . "', deadline = '" . $deadline."'";
        $this->db->query($sql);
    }

    public function getAccesstoken(){
        $query=$this->db->query("SELECT * FROM wechat_info LIMIT 1");
        return $query->row;
    }

    public function editJSAPIAccesstoken($accesstoken, $deadline) {
        $sql = "insert into wechat_jsapi_info(ticket, deadline) VALUES ('".$accesstoken."','".$deadline."') ON DUPLICATE KEY UPDATE ticket = '" . $accesstoken . "', deadline = '" . $deadline."'";
        $this->db->query($sql);
    }

    public function getJSAPIAccesstoken(){
        $query=$this->db->query("SELECT * FROM wechat_jsapi_info LIMIT 1");
        return $query->row;
    }

}
