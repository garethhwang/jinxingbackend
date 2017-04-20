<?php
class ModelExtensionTotalCoupon extends Model {
    public function getCoupon($code,$product_id,$customer_id) {

        $log = new Log("bbb.log");
        $status = true;

        $coupon_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE code = '" . $this->db->escape($code) . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");

        if ($coupon_query->num_rows) {
            /*if ($coupon_query->row['total'] > $this->cart->getSubTotal()) {
                $status = false;
                $log->write( "1111111111");
                $log->write( $this->cart->getSubTotal());

            }*/

            $coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");

            if ($coupon_query->row['uses_total'] > 0 && ($coupon_history_query->row['total'] >= $coupon_query->row['uses_total'])) {
                $status = false;
                //$log->write( "222222222222");
                return "1041" ;

            }

            if ($coupon_query->row['logged'] && !$customer_id) {
                $status = false;
                //$log->write( "33333333");
                return "1042" ;

            }

            if ($customer_id) {
                $coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "' AND ch.customer_id = '" . (int)$customer_id . "'");

                if ($coupon_query->row['uses_customer'] > 0 && ($coupon_history_query->row['total'] >= $coupon_query->row['uses_customer'])) {
                    $status = false;
                    //$log->write( "44444444");
                    return "1043" ;

                }
            }

            // Products
            $coupon_product_data = array();

            $coupon_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_product` WHERE coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");

            foreach ($coupon_product_query->rows as $product) {
                $coupon_product_data[] = $product['product_id'];
            }

            // Categories
            $coupon_category_data = array();

            $coupon_category_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_category` cc LEFT JOIN `" . DB_PREFIX . "category_path` cp ON (cc.category_id = cp.path_id) WHERE cc.coupon_id = '" . (int)$coupon_query->row['coupon_id'] . "'");

            foreach ($coupon_category_query->rows as $category) {
                $coupon_category_data[] = $category['category_id'];
            }

            $product_data = array();

            if ($coupon_product_data || $coupon_category_data) {

                if (in_array( $product_id , $coupon_product_data)) {
                    $product_data = $product_id;
                    //$log->write( "44444444=====".$product_data);

                }

                /*foreach ($this->cart->getProducts() as $product) {


                    if (in_array($product['product_id'], $coupon_product_data)) {
                        $product_data[] = $product['product_id'];
                        continue;
                    }

                    foreach ($coupon_category_data as $category_id) {
                        $coupon_category_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_category` WHERE `product_id` = '" . (int)$product['product_id'] . "' AND category_id = '" . (int)$category_id . "'");

                        if ($coupon_category_query->row['total']) {
                            $product_data[] = $product['product_id'];
                            continue;
                        }
                    }
                }*/

                if (!$product_data) {
                    $status = false;
                    //$log->write( "555555555");
                    return  "1044" ;

                }
            }
        } else {
            $status = false;
            //$log->write( "66666666");
        }

        if ($status) {
            return array(
                'coupon_id'     => $coupon_query->row['coupon_id'],
                'code'          => $coupon_query->row['code'],
                'name'          => $coupon_query->row['name'],
                'type'          => $coupon_query->row['type'],
                'discount'      => $coupon_query->row['discount'],
                'shipping'      => $coupon_query->row['shipping'],
                'total'         => $coupon_query->row['total'],
                'product'       => $product_data,
                'date_start'    => $coupon_query->row['date_start'],
                'date_end'      => $coupon_query->row['date_end'],
                'uses_total'    => $coupon_query->row['uses_total'],
                'uses_customer' => $coupon_query->row['uses_customer'],
                'status'        => $coupon_query->row['status'],
                'date_added'    => $coupon_query->row['date_added']
            );
        }
    }

    public function getCouponListForCustomer($product_id,$customer_id) {
        $coupon_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");
        $coupon_list=array();
        $log = new Log('coupon.log');
        foreach ( $coupon_query->rows as $coupon )
        {
            $log->write('Enter getCouponListForCustomer:' . $coupon['code']);
            $status = true;
            $coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon['coupon_id'] . "'");

            if ($coupon['uses_total'] > 0 && ($coupon_history_query->row['total'] >= $coupon['uses_total'])) {
                $log->write('使用总数超限');
                $status = false;
            }

            if ($coupon['logged'] && !$customer_id) {
                $log->write('用户登录错误');
                $status = false;
            }

            if ($customer_id) {
                $coupon_history_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "coupon_history` ch WHERE ch.coupon_id = '" . (int)$coupon['coupon_id'] . "' AND ch.customer_id = '" . (int)$customer_id . "'");

                if ($coupon_query->row['uses_customer'] > 0 && ($coupon_history_query->row['total'] >= $coupon_query->row['uses_customer'])) {
                    $log->write('用户使用数量超限');
                    $status = false;
                }
            }

            // Products
            $coupon_product_data = array();

            $coupon_product_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_product` WHERE coupon_id = '" . (int)$coupon['coupon_id'] . "'");

            foreach ($coupon_product_query->rows as $product) {
                $coupon_product_data[] = $product['product_id'];
            }

            // Categories
            $coupon_category_data = array();

            $coupon_category_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_category` cc LEFT JOIN `" . DB_PREFIX . "category_path` cp ON (cc.category_id = cp.path_id) WHERE cc.coupon_id = '" . (int)$coupon['coupon_id'] . "'");

            foreach ($coupon_category_query->rows as $category) {
                $coupon_category_data[] = $category['category_id'];
            }

            $product_data = array();

            if ($coupon_product_data || $coupon_category_data) {

                if (in_array( $product_id , $coupon_product_data)) {
                    $log->write('商品过滤找到');
                    $product_data = $product_id;
                }

                foreach ($coupon_category_data as $category_id) {
                    $coupon_category_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product_to_category` WHERE `product_id` = '" . (int)$product_id . "' AND category_id = '" . (int)$category_id . "'");

                    if ($coupon_category_query->row['total']) {
                        $log->write('商品种类过滤找到');
                        $product_data = $product_id;
                        continue;
                    }
                }

                if (!$product_data) {
                    $log->write('商品过滤未找到');
                    $status = false;
                }
            } else {
                $log->write('wei she zhi product ');
                $status = false;
            }

            //customer
            $coupon_customer_data = array();

            $coupon_customer_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_customer` WHERE coupon_id = '" . (int)$coupon['coupon_id'] . "'");

            foreach ($coupon_customer_query->rows as $customer) {
                $coupon_customer_data[] = $customer['customer_id'];
            }

            //customer group
            $coupon_customergroup_data = array();

            $coupon_customergroup_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_customer_group`  WHERE coupon_id = '" . (int)$coupon['coupon_id'] . "'");

            foreach ($coupon_customergroup_query->rows as $customergroup) {
                $coupon_customergroup_data[] = $customergroup['customer_group_id'];
            }

            $customer_data = array();
            if ($coupon_customer_data || $coupon_customergroup_data) {

                if (in_array( $customer_id , $coupon_customer_data)) {
                    $customer_data = $customer_id;
                }

                foreach ($coupon_customergroup_data as $customergroup_id) {
                    $coupon_customergroup_query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE `customer_id` = '" . (int)$customer_id . "' AND customer_group_id = '" . (int)$customergroup_id . "'");

                    if ($coupon_customergroup_query->row['total']) {
                        $customer_data = $customer_id;
                        continue;
                    }
                }

                if (!$customer_data) {
                    $status = false;
                }
            } else {
                $status = false;
            }


            if ($status) {
                $coupon_list[]=$coupon;
            }
        }
        if($coupon_list){
            return $coupon_list;
        }else{
            return null;
        }
    }

/*
    public function getCouponListForCustomer($product_id,$customer_id){
	    $log=new Log('coupon.log');

        $log->write("SELECT * FROM `" . DB_PREFIX . "coupon` c LEFT JOIN " . DB_PREFIX . "coupon_customer cc ON ( customer_id = $customer_id ) WHERE cc.coupon_id = c.coupon_id AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");

        $coupon_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` c LEFT JOIN " . DB_PREFIX . "coupon_customer cc ON ( customer_id = $customer_id ) WHERE cc.coupon_id = c.coupon_id AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) AND status = '1'");
        if ($coupon_query->num_rows){
            return $coupon_query->rows;
        }else{
            return null;
        }
    }
*/

	public function getTotal($total,$code,$product_id,$customer_id)
    {
        $log = new Log("wechat.log");
        if (isset($code)) {
            $this->load->language('extension/total/coupon');

            $coupon_info = $this->getCoupon($code,$product_id,$customer_id);

            if (is_array($coupon_info)) {

                $discount_total = 0;

                /*if (!$coupon_info['product']) {
                    $sub_total = $this->cart->getSubTotal();
                } else {
                    $sub_total = 0;

                    foreach ($this->cart->getProducts() as $product) {
                        if (in_array($product['product_id'], $coupon_info['product'])) {
                            $sub_total += $product['total'];
                        }
                    }
                }

                if ($coupon_info['type'] == 'F') {
                    $coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
                }

                foreach ($this->cart->getProducts() as $product) {
                    $discount = 0;

                    if (!$coupon_info['product']) {
                        $status = true;
                    } else {
                        $status = in_array($product['product_id'], $coupon_info['product']);
                    }

                    if ($status) {
                        if ($coupon_info['type'] == 'F') {
                            $discount = $coupon_info['discount'] * ($product['total'] / $sub_total);
                        } elseif ($coupon_info['type'] == 'P') {
                            $discount = $product['total'] / 100 * $coupon_info['discount'];
                        }

                        if ($product['tax_class_id']) {
                            $tax_rates = $this->tax->getRates($product['total'] - ($product['total'] - $discount), $product['tax_class_id']);

                            foreach ($tax_rates as $tax_rate) {
                                if ($tax_rate['type'] == 'P') {
                                    $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
                                }
                            }
                        }
                    }

                    $discount_total += $discount;
                }*/
                //$log->write("id-".$couponproductid );
                //$log->write("productid-".$coupon_info['product'] );
                //$log->write("total-".$total['total']);
                if ($product_id == $coupon_info['product']) {
                    if ($coupon_info['type'] == 'F') {
                        $discount = $coupon_info['discount'];

                    } elseif ($coupon_info['type'] == 'P') {
                        $discount = $total['total'] / 100 * $coupon_info['discount'];
                        if(is_float($discount)){
                            $discount = floor($discount);
                        }
                    }

                    $discount_total += $discount;

                }

                if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
                    if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
                        $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

                        foreach ($tax_rates as $tax_rate) {
                            if ($tax_rate['type'] == 'P') {
                                $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
                            }
                        }
                    }

                    $discount_total += $this->session->data['shipping_method']['cost'];
                }

                // If discount greater than total
                if ($discount_total > $total) {
                    $discount_total = $total;
                }

                $log->write("discount_total=".$discount_total);

                if ($discount_total > 0) {

                    $total['totals'][] = array(
                        'code' => 'coupon',
                        'title' => sprintf($this->language->get('text_coupon'), $code),
                        'value' => -$discount_total,
                        'sort_order' => $this->config->get('coupon_sort_order')
                    );



                    $total['total'] -= $discount_total;

                    $log->write("_total=".$total['total']);


                }

            }
        }
       return $total;
    }

	public function confirm($order_info, $order_total) {
		$code = '';

		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$code = substr($order_total['title'], $start, $end - $start);
		}

		$query =  $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_info['order_id'] . "'");

		$product_id = $query->row['product_id'];

		if ($code) {
			$coupon_info = $this->getCoupon($code,$product_id,$order_info['customer_id']);

			if ($coupon_info) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "coupon_history` SET coupon_id = '" . (int)$coupon_info['coupon_id'] . "', order_id = '" . (int)$order_info['order_id'] . "', customer_id = '" . (int)$order_info['customer_id'] . "', amount = '" . (float)$order_total['value'] . "', date_added = NOW()");
			} else {
				return $this->config->get('config_fraud_status_id');
			}
		}
	}

	public function unconfirm($order_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_id . "'");
	}

    /*public function deleteOrderCoupon($order_id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_id . "'AND customer_id = '" . (int)$this->customer->getId() . "'");
    }*/


    public function getCouponInfo($order_id,$customer_id) {

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon_history` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . $customer_id . "'");
        $coupon_info = $query->row;
        if($coupon_info){
            $result = $this->db->query("SELECT * FROM `" . DB_PREFIX . "coupon` WHERE coupon_id = '" . (int)$coupon_info['coupon_id']."'");
            return $result ->row;
        }
    }

}
