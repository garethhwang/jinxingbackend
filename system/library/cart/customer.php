<?php
namespace Cart;
class Customer {
	private $customer_id;
	private $realname;
	private $customer_group_id;
	private $email;
	private $telephone;
	private $fax;
	private $newsletter;
	private $address_id;
    private $physical_id ;
    private $department;
    private $wechat_id;
    private $pregnantstatus;


    public function __construct($registry) {

        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');


        if (isset($this->session->data['customer_id'])) {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

            if ($customer_query->num_rows) {
                $this->customer_id = $customer_query->row['customer_id'];
                $this->realname = $customer_query->row['realname'];
                $this->customer_group_id = $customer_query->row['customer_group_id'];
                $this->email = $customer_query->row['email'];
                $this->telephone = $customer_query->row['telephone'];
                $this->fax = $customer_query->row['fax'];
                $this->newsletter = $customer_query->row['newsletter'];
                $this->address_id = $customer_query->row['address_id'];


                $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

                if (!$query->num_rows) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
                }
            } else {
                $this->logout();
            }
        }
    }

	/*public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['customer_id'])) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
				$this->realname = $customer_query->row['realname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
		}
	}*/

	public function login($email, $password, $override = false) {
		if ($override) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];

			$this->customer_id = $customer_query->row['customer_id'];
			$this->realname = $customer_query->row['realname'];
            $this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->fax = $customer_query->row['fax'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->address_id = $customer_query->row['address_id'];
            $this->physical_id = $customer_query->row['physical_id'];
            $this->department = $customer_query->row['department'];
            $this->wechat_id = $customer_query->row['wechat_id'];
            $this->pregnantstatus = $customer_query->row['pregnantstatus'];



			$this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}
	}


    public function wechatlogin($openid) {


            $wechat_query = $this->db->query("select * from wechat_user, " . DB_PREFIX . "customer where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id AND status = '1'");

        if ($wechat_query->num_rows) {
            $this->session->data['customer_id'] = $wechat_query->row['customer_id'];
            $this->customer_id = $wechat_query->row['customer_id'];
            $this->realname = $wechat_query->row['realname'];
            $this->customer_group_id = $wechat_query->row['customer_group_id'];
            $this->email = $wechat_query->row['email'];
            $this->telephone = $wechat_query->row['telephone'];
            $this->babybirth = $wechat_query->row['babybirth'];
            //$this->fax = $wechat_query->row['fax'];
            //$this->newsletter = $wechat_query->row['newsletter'];
            $this->address_id = $wechat_query->row['address_id'];
            $this->physical_id = $wechat_query->row['physical_id'];
            $this->department = $wechat_query->row['department'];
            $this->wechat_id = $wechat_query->row['wechat_id'];
            $this->pregnantstatus = $wechat_query->row['pregnantstatus'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->customer_id . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

            if (!$query->num_rows) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->customer_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
            }

            $this->db->query("UPDATE " . DB_PREFIX . "customer_ip SET date_added = NOW()  WHERE customer_id = '" . (int)$this->customer_id . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");


            return true;
        } else {
            return false;
        }
    }

    public function weblogin($telephone) {


        $web_query = $this->db->query("select * from  " . DB_PREFIX . "customer where telephone='".(int)$telephone."'AND status = '1'");

        if ($web_query->num_rows) {

            $this->customer_id = $web_query->row['customer_id'];
            $this->customer_group_id = $web_query->row['customer_group_id'];
            $this->telephone = $web_query->row['telephone'];
            $this->pregnantstatus = $web_query->row['pregnantstatus'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->customer_id . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

            if (!$query->num_rows) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->customer_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
            }

            $this->db->query("UPDATE " . DB_PREFIX . "customer_ip SET date_added = NOW()  WHERE customer_id = '" . (int)$this->customer_id . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");


            return true;
        } else {
            return false;
        }
    }


    /*public function nonpregnantlogin($openid) {

    $nonpregnant_query = $this->db->query("select * from wechat_user, " . DB_PREFIX . "customer where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id AND status = '1'");

    if ($nonpregnant_query->num_rows) {
        $this->session->data['customer_id'] = $nonpregnant_query->row['customer_id'];

        $this->customer_id = $nonpregnant_query->row['customer_id'];
        $this->realname = $nonpregnant_query->row['realname'];
        $this->telephone = $nonpregnant_query->row['telephone'];
        $this->address_id = $nonpregnant_query->row['address_id'];
        $this->wechat_id = $nonpregnant_query->row['wechat_id'];
        $this->pregnantstatus = $nonpregnant_query->row['pregnantstatus'];

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");


        return true;
    } else {
        return false;
    }
}

    public function puerperalogin($openid) {

        $puerpera_query = $this->db->query("select * from wechat_user, " . DB_PREFIX . "customer where openid='".$openid."' and wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id AND status = '1'");

        if ($puerpera_query->num_rows) {
            $this->session->data['customer_id'] = $puerpera_query->row['customer_id'];

            $this->customer_id = $puerpera_query->row['customer_id'];
            $this->realname = $puerpera_query->row['realname'];
            $this->telephone = $puerpera_query->row['telephone'];
            $this->babybirth = $puerpera_query->row['babybirth'];
            $this->telephone = $puerpera_query->row['telephone'];
            $this->wechat_id = $puerpera_query->row['wechat_id'];
            $this->pregnantstatus = $puerpera_query->row['pregnantstatus'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET language_id = '" . (int)$this->config->get('config_language_id') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");



            return true;
        } else {
            return false;
        }
    }*/





	public function logout() {
		unset($this->session->data['customer_id']);

		$this->customer_id = '';
		$this->realname = '';
		$this->customer_group_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}

	public function getRealName() {
		return $this->realname;
	}

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getFax() {
		return $this->fax;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getAddressId() {
		return $this->address_id;
	}

    public function getPhysicalId() {
        return $this->physical_id;
    }


	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}

	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}
}
