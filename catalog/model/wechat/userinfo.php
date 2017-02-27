<?php


class ModelWechatUserinfo extends Model
{
    public function getUserInfo($openid){
        $result=$this->db->query("select * from wechat_user where openid='".$openid."'");
        return $result->row;
    }
    public function getCustomerByWechat($openid) {
        $result = $this->db->query("select * from wechat_user, " . DB_PREFIX . "customer, " . DB_PREFIX . "physical where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id and " . DB_PREFIX . "customer.customer_id = " . DB_PREFIX . "physical.customer_id ");
        return $result->row;
    }


    public function addWechatUser($data){
        $this->db->query("insert into wechat_user(subscribe,openid,nickname,sex,city,country,province,wlanguage,headimgurl) values('1','".$data["openid"]."','".$data["nickname"]."','".$data["sex"]."','".$data["city"]."','".$data["country"]."','".$data["province"]."','".$data["language"]."','".$data["headimgurl"]."')");
        $result=$this->db->query("select * from wechat_user where openid='".$data["openid"]."'");
        return $result->row["wechat_id"];
    }

    public function isUserValid($openid){
        $result=$this->db->query("select * from wechat_user where openid='".$openid."'");
        if($result->row){
            return $result->row["wechat_id"];
        }
    }

    public function addAdvise($data,$customer_id){
        $this->db->query("INSERT INTO " . DB_PREFIX . "advise SET customer_id = '" . (int)$customer_id . "', advise_text= '" . $this->db->escape($data['advisetext']) . "', date_add=NOW()");
    }

    public function subscribe($openid){
        $this->db->query("update wechat_user set subscribe=1 where openid='".$openid."'");
    }

    public function unsubscribe($openid){
        $this->db->query("update wechat_user set subscribe=0 where openid='".$openid."'");
    }

    public function getCityName($cityid){
        $result=$this->db->query("select name from wechat_city where city_id='".$cityid."'");
        if($result->row){
            return $result->row["name"];
        }
    }

    public function getDistrictName($districtid){
        $result=$this->db->query("select name from wechat_district where district_id='".$districtid."'");
        if($result->row){
            return $result->row["name"];
        }
    }

    public function getOfficeName($officeid){
        $result=$this->db->query("select name from wechat_office where office_id='".$officeid."'");
        if($result->row){
            return $result->row["name"];
        }
    }



}