<?php
namespace Cart;
class Doctor {
	private $doctor_id;
	private $name;
	private $telephone;
	private $sex;
    private $discription ;
    private $department;
    private $district;



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

	public function login($telephone, $password, $override = false) {
		if ($override) {
			$doctor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE telelphone = '" . (int)$telephone . "' AND status = '1'");
		} else {
			$doctor_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "doctor WHERE telelphone = '" . (int)$telephone . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
		}

		if ($doctor_query->num_rows) {

            //token//$this->session->data['customer_id'] = $doctor_query->row['customer_id'];

			$this->doctor_id = $doctor_query->row['doctor_id'];
			$this->name = $doctor_query->row['name'];
			$this->telephone = $doctor_query->row['telephone'];
			$this->sex = $doctor_query->row['sex'];
			$this->discription = $doctor_query->row['discription'];
            $this->district = $doctor_query->row['district'];
            $this->department = $doctor_query->row['department'];


			$this->db->query("UPDATE " . DB_PREFIX . "customer SET  ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE doctor_id = '" . (int)$this->doctor_id . "'");

			return true;
		} else {
			return false;
		}
	}


	public function logout() {

		//token//unset($this->session->data['customer_id']);

		$this->doctor_id = '';
		$this->name = '';
		$this->telephone = '';
		$this->sex = '';
		$this->discription = '';
		$this->department = '';
        $this->district = '';

	}

	public function isLogged() {
		return $this->doctor_id;
	}

	public function getId() {
		return $this->doctor_id;
	}

	public function getName() {
		return $this->name;
	}


	public function getTelephone() {
		return $this->telephone;
	}



}
