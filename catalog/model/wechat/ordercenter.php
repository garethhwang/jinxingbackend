<?php

/**
 * Created by PhpStorm.
 * User: xiaopren
 * Date: 2017/01/14
 * Time: 21:38
 */
class ModelWechatOrdercenter extends Model
{
    public function getCustomeridByOpenid($openid) {
        $wechat_query = $this->db->query("select *,  (SELECT customer_id FROM " . DB_PREFIX . "customer c WHERE c.wechat_id = o.wechat_id) AS customer_id from wechat_user o where o.openid='".$openid."' ");

        $log=new Log('api.log');
        $log->write("select *,  (SELECT customer_id FROM " . DB_PREFIX . "customer c WHERE c.wechat_id = o.wechat_id) AS customer_id from wechat_user o where o.openid='".$openid."'");
        if ($wechat_query->num_rows) {
            $this->session->data['customer_id'] = $wechat_query->row['customer_id'];

            $customer_id = $wechat_query->row['customer_id'];
            return $customer_id;
        } else {
            return 0;
        }
    }

    public function getAllPendingOrderid($customer_id) {
        $order_status_id_query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order_status WHERE name = 'Pending' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        if($order_status_id_query->num_rows){
            $order_status_id = $order_status_id_query->row['order_status_id'];
        } else {
            return;
        }

        $all_orderid_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = $customer_id AND order_status_id = $order_status_id ORDER BY date_modified DESC");

        return $all_orderid_query->rows;
    }

    public function getAllPaidOrderid($customer_id) {
        $order_status_id_query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order_status WHERE name = 'Processed' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        if($order_status_id_query->num_rows){
            $order_status_id = $order_status_id_query->row['order_status_id'];
        } else {
            return;
        }

        $all_orderid_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = $customer_id AND order_status_id = $order_status_id ORDER BY date_modified DESC");

        return $all_orderid_query->rows;
    }

    public function UpdateOrderStatusToPaid($order_id){
        if(isset($order_id)){
            $this->db->query("UPDATE " . DB_PREFIX . "order set order_status_id = '15' WHERE order_id = '" . $order_id . "'");
        }
    }

    public function UpdateOrderStatusToComplete($order_id){
        if(isset($order_id)){
            $this->db->query("UPDATE " . DB_PREFIX . "order set order_status_id = '5' WHERE order_id = '" . $order_id . "'");
        }
    }

    public function getAllCompletedOrderid($customer_id) {
        $order_status_id_query = $this->db->query("SELECT order_status_id FROM " . DB_PREFIX . "order_status WHERE name = 'Complete' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        if($order_status_id_query->num_rows){
            $order_status_id = $order_status_id_query->row['order_status_id'];
        } else {
            return;
        }

        $all_orderid_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = $customer_id AND order_status_id = $order_status_id ORDER BY date_modified DESC");

        return $all_orderid_query->rows;
    }

    public function getAllOrderid($customer_id) {
        $all_orderid_query = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE customer_id = $customer_id ORDER BY date_modified DESC");

        return $all_orderid_query->rows;
    }

    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.realname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");
        $log=new Log('api.log');
        $log->write("SELECT *, (SELECT CONCAT(c.realname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

        if ($order_query->num_rows) {
            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            $reward = 0;

            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

            foreach ($order_product_query->rows as $product) {
                $reward += $product['reward'];
            }

            if ($order_query->row['affiliate_id']) {
                $affiliate_id = $order_query->row['affiliate_id'];
            } else {
                $affiliate_id = 0;
            }
/*
            $this->load->model('marketing/affiliate');

            $affiliate_info = $this->model_marketing_affiliate->getAffiliate($affiliate_id);

            if ($affiliate_info) {
                $affiliate_realname = $affiliate_info['realtname'];
            } else {
                $affiliate_realname = '';

            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];
            } else {
                $language_code = $this->config->get('config_language');
            }
*/
            return array(
                'order_id'                => $order_query->row['order_id'],
                'invoice_no'              => $order_query->row['invoice_no'],
                'invoice_prefix'          => $order_query->row['invoice_prefix'],
                'store_id'                => $order_query->row['store_id'],
                'store_name'              => $order_query->row['store_name'],
                'store_url'               => $order_query->row['store_url'],
                'customer_id'             => $order_query->row['customer_id'],
                'customer'                => $order_query->row['customer'],
                'customer_group_id'       => $order_query->row['customer_group_id'],
                'realname'               => $order_query->row['realname'],
                'email'                   => $order_query->row['email'],
                'telephone'               => $order_query->row['telephone'],
                'fax'                     => $order_query->row['fax'],
                'custom_field'            => json_decode($order_query->row['custom_field'], true),
                'payment_realname'       => $order_query->row['payment_realname'],
                'payment_company'         => $order_query->row['payment_company'],
                'payment_address_1'       => $order_query->row['payment_address_1'],
                'payment_address_2'       => $order_query->row['payment_address_2'],
                'payment_postcode'        => $order_query->row['payment_postcode'],
                'payment_city'            => $order_query->row['payment_city'],
                'payment_zone_id'         => $order_query->row['payment_zone_id'],
                'payment_zone'            => $order_query->row['payment_zone'],
                'payment_zone_code'       => $payment_zone_code,
                'payment_country_id'      => $order_query->row['payment_country_id'],
                'payment_country'         => $order_query->row['payment_country'],
                'payment_iso_code_2'      => $payment_iso_code_2,
                'payment_iso_code_3'      => $payment_iso_code_3,
                'payment_address_format'  => $order_query->row['payment_address_format'],
                'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
                'payment_method'          => $order_query->row['payment_method'],
                'payment_code'            => $order_query->row['payment_code'],
                'shipping_realname'      => $order_query->row['shipping_realname'],
                'shipping_company'        => $order_query->row['shipping_company'],
                'shipping_address_1'      => $order_query->row['shipping_address_1'],
                'shipping_date'      => $order_query->row['shipping_date'],
                'shipping_address_2'      => $order_query->row['shipping_address_2'],
                'shipping_postcode'       => $order_query->row['shipping_postcode'],
                'shipping_city'           => $order_query->row['shipping_city'],
                'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
                'shipping_zone'           => $order_query->row['shipping_zone'],
                'shipping_zone_code'      => $shipping_zone_code,
                'shipping_country_id'     => $order_query->row['shipping_country_id'],
                'shipping_country'        => $order_query->row['shipping_country'],
                'shipping_iso_code_2'     => $shipping_iso_code_2,
                'shipping_iso_code_3'     => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
                'shipping_method'         => $order_query->row['shipping_method'],
                'shipping_code'           => $order_query->row['shipping_code'],
                'comment'                 => $order_query->row['comment'],
                'total'                   => $order_query->row['total'],
                'reward'                  => $reward,
                'order_status_id'         => $order_query->row['order_status_id'],
                'order_status'            => $order_query->row['order_status'],
                'affiliate_id'            => $order_query->row['affiliate_id'],
//                'affiliate_realname'     => $affiliate_realname,
                'commission'              => $order_query->row['commission'],
                'language_id'             => $order_query->row['language_id'],
 //               'language_code'           => $language_code,
                'currency_id'             => $order_query->row['currency_id'],
                'currency_code'           => $order_query->row['currency_code'],
                'currency_value'          => $order_query->row['currency_value'],
                'ip'                      => $order_query->row['ip'],
                'forwarded_ip'            => $order_query->row['forwarded_ip'],
                'user_agent'              => $order_query->row['user_agent'],
                'accept_language'         => $order_query->row['accept_language'],
                'date_added'              => $order_query->row['date_added'],
                'date_modified'           => $order_query->row['date_modified'],
                'doctor_id'                => $order_query->row['doctor_id'],
            );
        } else {
            return;
        }
    }

    public function getOrderProducts($order_id) {
        $log =new Log("api.log");


        $log->write("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

        return $query->rows;
    }

    public function getOrderOptions($order_id, $order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

        return $query->rows;
    }

    public function getUploadByCode($code) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "upload WHERE code = '" . $this->db->escape($code) . "'");

        return $query->row;
    }

    public function getOrderTotals($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

        return $query->rows;
    }

    public function getCustomerTelephone($customer_id){
        $info_query = $this->db->query("SELECT telephone, realname FROM " . DB_PREFIX . "customer WHERE customer_id = '" . $customer_id . "'");
        return $info_query->row;
    }

    public function getOrderEvaluate($order_id){
        $info_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "evaluate WHERE order_id = '" . (int)$order_id . "'");
        return $info_query->row;
    }
}