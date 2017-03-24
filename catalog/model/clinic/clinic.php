<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/15
 * Time: 15:53
 */
class ModelClinicClinic extends Model
{
    public function getOffices($data = array()) {
        $sql = "SELECT * FROM wechat_office ";

        $implode = array();
        /*
                if (isset($data['office_id']) && !is_null($data['office_id'])) {
                    $implode[] = "office_id = '" . (int)$data['office_id'] . "'";
                }

                if (!empty($data['name'])) {
                    $implode[] = "name LIKE '%" . $this->db->escape($data['name']) . "%'";
                }

                if (isset($data['city_id']) && !is_null($data['city_id'])) {
                    $implode[] = "city_id = '" . (int)$data['city_id'] . "'";
                }

                if (isset($data['district_id']) && !is_null($data['district_id'])) {
                    $implode[] = "district_id = '" . (int)$data['district_id'] . "'";
                }
        */
        if (isset($data['filter_province_id']) && !is_null($data['filter_province_id'])) {
            $implode[] = "province_id = '" . (int)$data['filter_province_id'] . "'";
        }

        if ($implode) {
            " WHERE " . implode(" AND ", $implode);
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
            $sql .= " ORDER BY name";
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


    public function getProvince($province_id)
    {
        $query = $this->db->query("SELECT name FROM wechat_province WHERE province_id ='" . (int)$province_id . "'");
        if($query->row){
            return $query->row["name"];
        }
    }


    public function getDistrict($district_id)
    {
        $query = $this->db->query("SELECT name FROM wechat_district WHERE district_id ='" . (int)$district_id . "'");
        if($query->row){
            return $query->row["name"];
        }
    }



    public function getCity($city_id)
    {
        $query = $this->db->query("SELECT name FROM wechat_city WHERE city_id ='" . (int)$city_id . "'");
        if($query->row){
            return $query->row["name"];
        }
    }

    //get office info
    public function getOfficeName($office_id){
        $query=$this->db->query("SELECT name  FROM wechat_office where office_id ='" . (int)$office_id . "'");
        return $query->row;
    }

    //get office info
    public function getOffice($district_id){
        $query=$this->db->query("SELECT office_id as id,name FROM wechat_office where district_id = $district_id");
        return $query->rows;
    }

}