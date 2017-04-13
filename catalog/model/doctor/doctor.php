<?php
class ModelDoctorDoctor extends Model
{
    public function addDoctor($data)
    {

        $this->db->query("INSERT INTO " . DB_PREFIX . "doctor SET  telephone = '" . $this->db->escape($data['telephone']) . "',ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' ,date_added = NOW()");

        $doctor_id = $this->db->getLastId();

        return $doctor_id;
    }

    public function addDoctorEvaluate($data)
    {

        $this->db->query("INSERT INTO " . DB_PREFIX . "evaluate SET  doctor_id = '" . $this->db->escape($data['doctor_id']) . "',customer_id = '" . $this->db->escape($data['customer_id']) . "' ,order_id = '" . $this->db->escape($data['order_id']) . "' , evaluate_text = '" . $this->db->escape($data['evaluate_text']) . "' ,starrating  = '" . $this->db->escape($data['starrating']) . "' , evaluate_tag  = '" . $this->db->escape($data['evaluate_tag']) . "',date_added = NOW()");

    }

    public function editDoctor($data, $doctor_id)
    {

        $this->db->query("UPDATE " . DB_PREFIX . "doctor SET name = '" . $this->db->escape($data['name']) . "', sex = '" . $this->db->escape($data['sex']) . "', img = '" . $this->db->escape($data['img']) . "',img_thumbnail = '" . $this->db->escape($data['img_thumbnail']) . "', department = '" . $this->db->escape($data['department']) . "',  district = '" . $this->db->escape($data['district']) . "',starrating = '" . $this->db->escape($data['starrating']) . "', discription = '" . $this->db->escape($data['discription']) . "' WHERE doctor_id = '" . (int)$doctor_id . "'");


    }

    public function editDoctorStarrating($starrating, $doctor_id)
    {

        $this->db->query("UPDATE " . DB_PREFIX . "doctor SET starrating = '" . $this->db->escape($starrating) . "' WHERE doctor_id = '" . (int)$doctor_id . "'");


    }

    /*public function editPassword($email, $password)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = token(9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }

    public function editCode($email, $code)
    {
        $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }

    public function editNewsletter($newsletter)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
    }*/

    public function getDoctor($doctor_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE doctor_id = '" . (int)$doctor_id . "'");

        return $query->row;
    }

    public function getDoctorEvaluate($doctor_id)
    {
        $query = $this->db->query("SELECT  FROM " . DB_PREFIX . "evaluate WHERE doctor_id = '" . (int)$doctor_id . "'");

        return $query->rows;
    }

    public function getAllDoctor()
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor ");

        return $query->rows;
    }

    public function getTelephone(){

        $result = $this->db->query("SELECT telephone FROM " . DB_PREFIX . "doctor ");

        return $result->rows;

    }

    public function getCustomerByTelephone($telephone)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE telephone = '" . (int)$telephone . "'");

        return $query->row ;
    }


    /*public function getCustomerByEmail($email)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query ;
    }

    public function getCustomerByCode($code)
    {
        $query = $this->db->query("SELECT customer_id, realname, email FROM `" . DB_PREFIX . "customer` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

        return $query->row;
    }

    public function getWechatId()
    {
        $query = $this->db->query("SELECT wechat_id FROM " . DB_PREFIX . "customer ");
        return $query;

    }

    public function updateReceiptDate($data, $adddate)
    {
        $customer_id = $this->customer->getId();
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET receiptdate = DATE_ADD('".$this->db->escape($data['lastmenstrualdate'])."',INTERVAL ".(int)$adddate." WEEK) WHERE customer_id = '" . (int)$customer_id . "'");

    }


    public function getCustomerByToken($token)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

        $this->db->query("UPDATE " . DB_PREFIX . "doctor SET token = ''");

        return $query->row;
    }

    public function getTotalCustomersByEmail($email)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row['total'];
    }
    public function getTotalCustomersByTelephone($telephone)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE telephone '" . $this->db->escape($telephone) . "'");

        return $query->row['total'];
    }

    public function getTotalNonpregnantByTelephone($telephone)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "nonpregnant WHERE telephone '" . $this->db->escape($telephone) . "'");

        return $query->row['total'];
    }

    public function getTotalCustomersByWechat($wechat_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE wechat_id = '" . (int)$wechat_id . "'");

        return $query->row['total'];
    }

    public function getTotalNonpregnantByWechat($wechat_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "nonpregnant WHERE wechat_id = '" .(int)$wechat_id . "'");

        return $query->row['total'];
    }

    public function getRewardTotal($customer_id)
    {
        $query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->row['total'];
    }

    public function getIps($customer_id)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->rows;
    }*/

    public function addLoginAttempt($telephone)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor_login WHERE telephone = '" . (int)$telephone . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

        if (!$query->num_rows) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "doctor_login SET telephone = '" . (int)$telephone . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "doctor_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
        }
    }

    public function getLoginAttempts($telephone)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "doctor_login` WHERE telephone = '" . (int)$telephone . "''");

        return $query->row;
    }

    public function deleteLoginAttempts($telephone)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "doctor_login` WHERE telephone = '" . (int)$telephone . "'");
    }


}