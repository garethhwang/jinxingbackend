<?php
class ModelAccountDoctor extends Model
{
    public function addDoctor($data)
    {

        $this->db->query("INSERT INTO " . DB_PREFIX . "docter SET  telephone = '" . $this->db->escape($data['telephone']) . "', date_added = NOW()");

        $doctor_id = $this->db->getLastId();

        return $doctor_id;
    }


    public function editDoctor($data, $doctor_id)
    {

        $this->db->query("UPDATE " . DB_PREFIX . "doctor SET realname = '" . $this->db->escape($data['realname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', barcode = '" . $this->db->escape($data['barcode']) . "', birthday = '" . $this->db->escape($data['birthday']) . "', department = '" . $this->db->escape($data['department']) . "', pregnantstatus = '1', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "',receiptdate = DATE_ADD( '".$this->db->escape($data['lastmenstrualdate'])."',INTERVAL 10 WEEK),ispregnant = '1' WHERE customer_id = '" . (int)$customer_id . "'");


    }

    public function editPassword($email, $password)
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
    }

    public function getDoctor($doctor_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$doctor_id . "'");

        return $query->row;
    }


    public function getCustomerByEmail($email)
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
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

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
    }

    public function addLoginAttempt($email)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_login WHERE email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

        if (!$query->num_rows) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_login SET email = '" . $this->db->escape(utf8_strtolower((string)$email)) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', total = 1, date_added = '" . $this->db->escape(date('Y-m-d H:i:s')) . "', date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "'");
        } else {
            $this->db->query("UPDATE " . DB_PREFIX . "customer_login SET total = (total + 1), date_modified = '" . $this->db->escape(date('Y-m-d H:i:s')) . "' WHERE customer_login_id = '" . (int)$query->row['customer_login_id'] . "'");
        }
    }

    public function getLoginAttempts($email)
    {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row;
    }

    public function deleteLoginAttempts($email)
    {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "customer_login` WHERE email = '" . $this->db->escape(utf8_strtolower($email)) . "'");
    }


}