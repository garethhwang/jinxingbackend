<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:38
 */
class ModelClinicClinic extends Model
{

    public function getOffices($data = array()) {
        $sql = "SELECT * FROM wechat_office ";

        $implode = array();

        if (isset($data['province_id']) && !is_null($data['province_id'])) {
            $implode[] = "province_id = '" . (int)$data['province_id'] . "'";
        }

        if (isset($data['city_id']) && !is_null($data['city_id'])) {
            $implode[] = "city_id = '" . (int)$data['city_id'] . "'";
        }

        if (isset($data['district_id']) && !is_null($data['district_id'])) {
            $implode[] = "district_id = '" . (int)$data['district_id'] . "'";
        }

        if (isset($data['office_id']) && !is_null($data['office_id'])) {
            $implode[] = "office_id = '" . (int)$data['office_id'] . "'";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'province_id',
            'city_id',
            'district_id',
            'office_id'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY office_id";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProvinces(){
        $query=$this->db->query("SELECT * FROM wechat_province");
        return $query->rows;
    }

    public function GetProvinceNameByProvinceId($province_id){
        $query=$this->db->query("SELECT * FROM wechat_province WHERE province_id = '" . $province_id . "'");
        if($query->row){
            return $query->row['name'];
        }

    }

    public function getProvinceidByProvinceName($province_name){
        if(isset($province_name) && !is_null($province_name))
        {
            $query=$this->db->query("SELECT * FROM wechat_province WHERE name = '" . $province_name . "'");
        }else{
            return null;
        }
        return $query->row['province_id'];
    }

    //get city info
    public function getCitiesByProvinceId($ProvinceId){
        $query=$this->db->query("SELECT * FROM wechat_city WHERE province_id = '" . $ProvinceId . "'");
        return $query->rows;
    }

    public function GetCityNameByCityId($city_id){
        $query=$this->db->query("SELECT * FROM wechat_city WHERE city_id = '" . $city_id . "'");
        if($query->row){
            return $query->row['name'];
        }
    }

    public function getCityidByCityName($city_name){
        if(isset($city_name) && !is_null($city_name))
        {
            $query=$this->db->query("SELECT * FROM wechat_city WHERE name = '" . $city_name . "'");
        }else{
            return null;
        }
        return $query->row['city_id'];
    }

    // get district info
    public function getDistrictByCityId($city_id){
        $query=$this->db->query("SELECT * FROM wechat_district where city_id = '" . $city_id . "'");
        return $query->rows;
    }

    public function getDistrictidByDistrictName($district_name){
        if(isset($district_name) && !is_null($district_name))
        {
            $query=$this->db->query("SELECT * FROM wechat_district WHERE name = '" . $district_name . "'");
        }else{
            return null;
        }
        return $query->row['district_id'];
    }

    public function getDistrictinfoByDistrictName($district_name){
        if(isset($district_name) && !is_null($district_name))
        {
            $query=$this->db->query("SELECT * FROM wechat_district WHERE name = '" . $district_name . "'");
        }else{
            return null;
        }
        return $query->row;
    }


    public function GetDistrictNameByDistrictId($district_id){
        $query=$this->db->query("SELECT * FROM wechat_district WHERE district_id = '" . $district_id . "'");
        if($query->row){
            return $query->row['name'];
        }
    }


    public function addDistrict($district_id,$city_id,$district_name){
        $this->db->query("INSERT INTO wechat_district(district_id,city_id,name) VALUES ('" . $district_id . "','". $city_id . "','" . $district_name . "')");
    }

    public function deleteDistrict($district_id){
        $this->db->query("DELETE FROM wechat_district WHERE district_id = '" . $district_id . "'");
    }

    public function updateDistrict($district_id,$city_id,$district_name){
        $this->db->query("UPDATE  wechat_district SET  city_id = '" . $city_id . "', name = '" . $district_name . "' WHERE district_id = '" . $district_id . "'");
    }

    //get office info
    public function getOffice($district_id){
        $query=$this->db->query("SELECT * FROM wechat_office where district_id = $district_id");
        return $query->rows;
    }

    public function GetOfficeInfoByOfficeId($office_id){
        $query = $this->db->query("SELECT * FROM wechat_office where office_id = '" . $office_id . "'");
        return $query->row;
    }

    public function updateOffice($data){
        if (isset($data['office_id']))
        {
            $office_id = $data['office_id'];
        }

        if (isset($data['office_name']))
        {
            $office_name = $data['office_name'];
        }

        if (isset($data['district_id']))
        {
            $district_id = $data['district_id'];
        }

        if (isset($data['city_id']))
        {
            $city_id = $data['city_id'];
        }

        if (isset($data['province_id']))
        {
            $province_id = $data['province_id'];
        }

        $this->db->query("UPDATE wechat_office SET name = '" . $office_name. "', city_id = '" . $city_id . "', province_id = '" . $province_id . "', district_id = '" . $district_id . "'" . " WHERE office_id = '" . $office_id . "'");

        $log = new Log('clinic.log');
        $log->write("UPDATE wechat_office SET name = '" . $office_name. "', city_id = '" . $city_id . "', province_id = '" . $province_id . "', district_id = '" . $district_id . "'" . " WHERE office_id = '" . $office_id . "'");
        //return ("UPDATE wechat_office SET name = '" . $office_name. "', city_id = '" . $city_id . "', province_id = '" . $province_id . "', district_id = '" . $district_id . "'" . " WHERE office_id = '" . $office_id . "'");
    }

    public function addOffice($data){
        if (isset($data['office_name']))
        {
            $office_name = $data['office_name'];
        }

        $district_id = $data['district_id'];
        $province_id = $data['province_id'];
        $city_id = $data['city_id'];

       $this->db->query("INSERT INTO wechat_office SET name = '" . $office_name. "', city_id = '" . $city_id . "', province_id = '" . $province_id . "', district_id = '" . "$district_id'");

    }

    public function deleteOffice($office_id){
        $this->db->query("DELETE FROM wechat_office WHERE office_id = '" . $office_id . "'");
        $log = new Log('delete.log');
        $log->write("DELETE FROM wechat_office WHERE office_id = '" . $office_id . "'");
    }

}