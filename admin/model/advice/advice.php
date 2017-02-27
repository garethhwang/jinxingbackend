<?php
/**
 * Created by PhpStorm.
 * User: renxiaopeng
 * Date: 2017/2/3
 * Time: 15:11
 */
class ModelAdviceAdvice extends Model {
    public function getAllAdvice($data = array())
    {
        $sql = "SELECT *, (SELECT c.realname FROM ph_customer c WHERE c.customer_id = o.customer_id) AS customer FROM  `" . DB_PREFIX . "advise` o WHERE o.advise_id != Null";

        if (!empty($data['filter_date_start'])) {
            $sql .= " AND DATE(o.date_add) >= '" . $this->db->escape($data['filter_date_start']) . "'";
        }

        if (!empty($data['filter_date_end'])) {
            $sql .= " AND DATE(o.date_add) <= '" . $this->db->escape($data['filter_date_end']) . "'";
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
        $log= new Log('api.log');
        $log->write($sql);
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalAdvices($data = array()) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "advise`");

        return $query->row['total'];
    }
}