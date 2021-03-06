<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/13
 * Time: 14:52
 */

class ModelDoctorIdentification extends Model
{
    public function addIdentification($data)
    {

        $this->db->query("INSERT INTO " . DB_PREFIX . "physicalidentification SET customer_id = '" . $this->db->escape($data['customer_id']) . "' ,identification_text = '" . $this->db->escape($data['identification_text']) . "',face_img = '" . $this->db->escape($data['face_img']) . "' ,tongue_img = '" . $this->db->escape($data['tongue_img']) . "' ,face_img_thumbnail = '" . $this->db->escape($data['face_img_thumbnail']) . "',tongue_img_thumbnail = '" . $this->db->escape($data['tongue_img_thumbnail']) . "',date_added = NOW()");

    }

    public function getIdentification($customer_id){

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "physicalidentification WHERE customer_id ='" . (int)$customer_id . "' ");
        return $query->rows;

    }

}