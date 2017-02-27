<?php
class ModelWechatPhysicalReceipt extends Model
{

    public function getReceipt($receipt_id) {
        $receipt_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "receipt WHERE receipt_id = '" . (int)$receipt_id . "'");
        return $receipt_query->row;
    }

    public function getDateAdd($customer_id) {
        $result = $this->db->query("SELECT date_add FROM " . DB_PREFIX . "receipt_history WHERE customer_id = '" . (int)$customer_id . "'");
        return $result;
    }

    public function getRecord($customer_id) {
        $result = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "receipt_history WHERE customer_id = '" . (int)$customer_id . "'");
        return $result->row['total'];
    }

    public function addReceiptNullHistory() {
        $this->db->query("INSERT INTO " . DB_PREFIX . "receipt_history SET customer_id = '" . (int)$this->customer->getId() . "', receipt_id = '1', receipt_text = '', date_add= NOW()");

    }
    //customer_id = '" . (int)$this->customer->getId() . "'

    public function addReceiptHistory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "receipt_history SET customer_id = '" . (int)$this->customer->getId() . "', receipt_id = '" .$data['receipt_id'] . "', receipt_text = '" . $data['receipt_text'] . "', date_add= NOW()");

    }

    public function deleteReceiptHistory($receipt_history_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "receipt_history WHERE receipt_history_id = '" . (int)$receipt_history_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
    }

    public function getReceiptHistory($receipt_id) {
        $receipt_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "receipt_history WHERE receipt_id = '" . (int)$receipt_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

        return $receipt_query->row;
    }

    public function getReceiptHistories() {
        $receipt_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "receipt_history WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        foreach ($query->rows as $result) {

            $receipt_data[$result['receipt_id']] = array(
                'receipt_id'     => $result['receipt_id'],
                'date_add '      => $result['date_add '],
                'receipt_text'   => json_decode($result['receipt_text'], true)

            );
        }

        return $receipt_data;
    }

    public function getTotalReceiptHistory() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "receipt_history WHERE customer_id = '" . (int)$this->customer->getId() . "'");

        return $query->row['total'];
    }


}