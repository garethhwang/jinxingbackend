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
        $this->db->query("UPDATE  wechat_info SET accesstoken = '" . $accesstoken . "', deadline = '" . $deadline."'");

    }

    public function getAccesstoken(){
        $query=$this->db->query("SELECT * FROM wechat_info LIMIT 1");
        return $query->row;
    }
}