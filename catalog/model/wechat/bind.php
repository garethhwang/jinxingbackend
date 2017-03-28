<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:38
 */
class ModelWechatBind extends Model
{
    public function getProvinces(){
        $query=$this->db->query("SELECT province_id as id ,name FROM wechat_province");
        return $query->rows;

    }

    public function getCities($provinceid){
        $query=$this->db->query("SELECT city_id as id ,name FROM wechat_city where province_id=".$provinceid);
        return $query->rows;
    }

    public function getAllCities(){
        $query=$this->db->query("SELECT city_id as id ,name FROM wechat_city");
        return $query->rows;
    }

    public function getDistricts($cityid){
        $query=$this->db->query("SELECT district_id as id ,name FROM wechat_district where city_id=".$cityid);
        return $query->rows;
    }

    public function getAllDistricts(){
        $query=$this->db->query("SELECT district_id as id ,name FROM wechat_district");
        return $query->rows;
    }

    public function getOffice($district_id){
        $query=$this->db->query("SELECT office_id as id,name FROM wechat_office where district_id = $district_id");
        return $query->rows;
    }


}