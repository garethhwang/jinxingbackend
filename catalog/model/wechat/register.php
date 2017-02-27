<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/11
 * Time: 21:48
 */
class ModelWechatRegister
{
    public function add($data){
        $this->db->query("INSERT INTO  wechat_user(id,) VALUES ()");
    }

    public function isUserValid($data){
        return 0;
    }

    //update info when user unsubscribe
    public function unSubscribe(){

    }



}