 <?php
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
		$log = new Log("wechat.log");
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/register');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$customer_id = $this->model_account_customer->addCustomer($this->request->post);

			// Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
            $this->customer->login($this->request->post['email'], $this->request->post['password']);

			unset($this->session->data['guest']);


			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $this->request->post['realname']
				);

				$this->model_account_activity->addActivity('register', $activity_data);
			}

			$this->response->redirect($this->url->link('wechat/registersuccess', '', true));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_register'),
			'href' => $this->url->link('account/register', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', true));
		$data['text_your_details'] = $this->language->get('text_your_details');
		$data['text_your_address'] = $this->language->get('text_your_address');
		$data['text_your_password'] = $this->language->get('text_your_password');
        $data['text_your_physical'] = $this->language->get('text_your_physical');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
        $data['entry_productiondate'] = $this->language->get('entry_productiondate');
        $data['entry_department']  = $this->language->get('entry_department');
        $data['entry_pregnantstatus']  = $this->language->get('entry_pregnantstatus');
        $data['entry_realname']  = $this->language->get('entry_realname');
        $data['entry_barcode']  = $this->language->get('entry_barcode');
        $data['entry_birthday']  = $this->language->get('entry_birthday');
        $data['entry_householdregister']  = $this->language->get('entry_householdregister');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address');
		//$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');

        $data['entry_height'] = $this->language->get('entry_height');
        $data['entry_weight'] = $this->language->get('entry_weight');
        $data['entry_bmiindex'] = $this->language->get('entry_bmiindex');
        $data['entry_bmitype'] = $this->language->get('entry_bmitype');
        $data['entry_lastmenstrualdate'] = $this->language->get('entry_lastmenstrualdate');
        $data['entry_edc'] = $this->language->get('entry_edc');
        $data['entry_gravidity'] = $this->language->get('entry_gravidity');
        $data['entry_vaginaldelivery'] = $this->language->get('entry_vaginaldelivery');
        $data['entry_parity'] = $this->language->get('entry_parity');
        $data['entry_aesarean'] = $this->language->get('entry_aesarean');
        $data['entry_spontaneousabortion'] = $this->language->get('entry_spontaneousabortion');
        $data['entry_drug_inducedabortion'] = $this->language->get('entry_drug_inducedabortion');
        $data['entry_fetal'] = $this->language->get('entry_fetal');
        $data['entry_highrisk'] = $this->language->get('entry_highrisk');
        $data['entry_highriskfactor'] = $this->language->get('entry_highriskfactor');


		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

        if (isset($this->error['realname'])) {
            $data['error_realname'] = $this->error['realname'];
        } else {
            $data['error_realname'] = '';
        }

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

        if (isset($this->error['productiondate'])) {
            $data['productiondate'] = $this->error['productiondate'];
        } else {
            $data['error_productiondate'] = '';
        }

        if (isset($this->error['householdregister'])) {
            $data['error_householdregister'] = $this->error['householdregister'];
        } else {
            $data['error_householdregister'] = '';
        }

        if (isset($this->error['pregnantstatus'])) {
            $data['error_pregnantstatus'] = $this->error['pregnantstatus'];
        } else {
            $data['error_pregnantstatus'] = '';
        }

        if (isset($this->error['height'])) {
            $data['error_height'] = $this->error['height'];
        } else {
            $data['error_height'] = '';
        }

        if (isset($this->error['weight'])) {
            $data['error_weight'] = $this->error['weight'];
        } else {
            $data['error_weight'] = '';
        }

        if (isset($this->error['bmiindex'])) {
            $data['error_bmiindex'] = $this->error['bmiindex'];
        } else {
            $data['error_bmiindex'] = '';
        }

        if (isset($this->error['bmitype'])) {
            $data['error_bmitype'] = $this->error['bmitype'];
        } else {
            $data['error_bmitype'] = '';
        }

        if (isset($this->error['lastmenstrualdate'])) {
            $data['error_lastmenstrualdate'] = $this->error['lastmenstrualdate'];
        } else {
            $data['error_lastmenstrualdate'] = '';
        }

        if (isset($this->error['edc'])) {
            $data['error_edc'] = $this->error['edc'];
        } else {
            $data['error_edc'] = '';
        }

        if (isset($this->error['gravidity'])) {
            $data['error_gravidity'] = $this->error['gravidity'];
        } else {
            $data['error_gravidity'] = '';
        }

        if (isset($this->error['parity'])) {
            $data['error_parity'] = $this->error['parity'];
        } else {
            $data['error_parity'] = '';
        }

        if (isset($this->error['vaginaldelivery'])) {
            $data['error_vaginaldelivery'] = $this->error['vaginaldelivery'];
        } else {
            $data['error_vaginaldelivery'] = '';
        }

        if (isset($this->error['aesarean'])) {
            $data['error_aesarean'] = $this->error['aesarean'];
        } else {
            $data['error_aesarean'] = '';
        }

        if (isset($this->error['spontaneousabortion'])) {
            $data['error_spontaneousabortion'] = $this->error['spontaneousabortion'];
        } else {
            $data['error_spontaneousabortion'] = '';
        }

        if (isset($this->error['drug_inducedabortion'])) {
            $data['error_drug_inducedabortion'] = $this->error['drug_inducedabortion'];
        } else {
            $data['error_drug_inducedabortion'] = '';
        }

        if (isset($this->error['fetal'])) {
            $data['error_fetal'] = $this->error['fetal'];
        } else {
            $data['error_fetal'] = '';
        }

        if (isset($this->error['highrisk'])) {
            $data['error_highrisk'] = $this->error['highrisk'];
        } else {
            $data['error_highrisk'] = '';
        }

        if (isset($this->error['highriskfactor'])) {
            $data['error_highriskfactor'] = $this->error['highriskfactor'];
        } else {
            $data['error_highriskfactor'] = '';
        }

        if (isset($this->error['barcode'])) {
            $data['error_barcode'] = $this->error['barcode'];
        } else {
            $data['error_barcode'] = '';
        }

        if (isset($this->error['birthday'])) {
            $data['error_birthday'] = $this->error['birthday'];
        } else {
            $data['error_birthday'] = '';
        }

        if (isset($this->error['householdregister'])) {
            $data['error_householdregister'] = $this->error['householdregister'];
        } else {
            $data['error_householdregister'] = '';
        }

		if (isset($this->error['address_1'])) {
			$data['error_address_1'] = $this->error['address_1'];
		} else {
			$data['error_address_1'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$data['error_postcode'] = $this->error['postcode'];
		} else {
			$data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$data['error_country'] = $this->error['country'];
		} else {
			$data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$data['error_zone'] = $this->error['zone'];
		} else {
			$data['error_zone'] = '';
		}

		if (isset($this->error['custom_field'])) {
			$data['error_custom_field'] = $this->error['custom_field'];
		} else {
			$data['error_custom_field'] = array();
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$data['action'] = $this->url->link('account/register', '', true);

		$data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}

		if (isset($this->request->post['customer_group_id'])) {
			$data['customer_group_id'] = $this->request->post['customer_group_id'];
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}

        if (isset($this->request->post['realname'])) {
            $data['realname'] = $this->request->post['realname'];
        } else {
            $data['realname'] = '';
        }

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['barcode'])) {
			$data['barcode'] = $this->request->post['barcode'];
		} else {
			$data['barcode'] = '';
		}

        if (isset($this->request->post['birthday'])) {
            $data['birthday'] = $this->request->post['birthday'];
        } else {
            $data['birthday'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $data['telephone'] = $this->request->post['telephone'];
        } else {
            $data['telephone'] = '';
        }

		if (isset($this->request->post['fax'])) {
            $data['fax'] = $this->request->post['fax'];
        } else {
            $data['fax'] = '';
        }

        if (isset($this->request->post['productiondate'])) {
            $data['productiondate'] = $this->request->post['productiondate'];
        } else {
            $data['productiondate'] = '';
        }

        if (isset($this->request->post['department'])) {
            $data['department'] = $this->request->post['department'];
        } else {
            $data['department'] = '';
        }

        if (isset($this->request->post['householdregister'])) {
            $data['householdregister'] = $this->request->post['householdregister'];
        } else {
            $data['householdregister'] = '';
        }

        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } else {
            $data['height'] = '';
        }

        if (isset($this->request->post['weight'])) {
            $data['weight'] = $this->request->post['weight'];
        } else {
            $data['weight'] = '';
        }

        if (isset($this->request->post['bmiindex'])) {
            $data['bmiindex'] = $this->request->post['bmiindex'];
        } else {
            $data['bmiindex'] = '';
        }

        if (isset($this->request->post['bmitype'])) {
            $data['bmitype'] = $this->request->post['bmitype'];
        } else {
            $data['bmitype'] = '';
        }

        if (isset($this->request->post['lastmenstrualdate'])) {
            $data['lastmenstrualdate'] = $this->request->post['lastmenstrualdate'];
        } else {
            $data['lastmenstrualdate'] = '';
        }

        if (isset($this->request->post['edc'])) {
            $data['edc'] = $this->request->post['edc'];
        } else {
            $data['edc'] = '';
        }

        if (isset($this->request->post['gravidity'])) {
            $data['gravidity'] = $this->request->post['gravidity'];
        } else {
            $data['gravidity'] = '';
        }

        if (isset($this->request->post['parity'])) {
            $data['parity'] = $this->request->post['parity'];
        } else {
            $data['parity'] = '';
        }

        if (isset($this->request->post['vaginaldelivery'])) {
            $data['vaginaldelivery'] = $this->request->post['vaginaldelivery'];
        } else {
            $data['vaginaldelivery'] = '';
        }

        if (isset($this->request->post['aesarean'])) {
            $data['aesarean'] = $this->request->post['aesarean'];
        } else {
            $data['aesarean'] = '';
        }

        if (isset($this->request->post['spontaneousabortion'])) {
            $data['spontaneousabortion'] = $this->request->post['spontaneousabortion'];
        } else {
            $data['spontaneousabortion'] = '';
        }

        if (isset($this->request->post['drug_inducedabortion'])) {
            $data['drug_inducedabortion'] = $this->request->post['drug_inducedabortion'];
        } else {
            $data['drug_inducedabortion'] = '';
        }

        if (isset($this->request->post['fetal'])) {
            $data['fetal'] = $this->request->post['fetal'];
        } else {
            $data['fetal'] = '';
        }

        if (isset($this->request->post['highrisk'])) {
            $data['highrisk'] = $this->request->post['highrisk'];
        } else {
            $data['highrisk'] = '';
        }

        if (isset($this->request->post['highriskfactor'])) {
            $data['highriskfactor'] = $this->request->post['highriskfactor'];
        } else {
            $data['highriskfactor'] = '';
        }

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} else {
			$data['company'] = '';
		}

        if (isset($this->request->post['householdregister'])) {
            $data['householdregister'] = $this->request->post['householdregister'];
        } else {
            $data['householdregister'] = '';
        }

		if (isset($this->request->post['address_1'])) {
			$data['address_1'] = $this->request->post['address_1'];
		} else {
			$data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$data['address_2'] = $this->request->post['address_2'];
		} else {
			$data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($this->session->data['shipping_address']['postcode'])) {
			$data['postcode'] = $this->session->data['shipping_address']['postcode'];
		} else {
			$data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['pregnantstatus'])) {
			$data['pregnantstatus'] = $this->request->post['pregnantstatus'];
		} else {
			$data['pregnantstatus'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int)$this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int)$this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$data['countries'] = $this->model_localisation_country->getCountries();

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

		if (isset($this->request->post['custom_field'])) {
			if (isset($this->request->post['custom_field']['account'])) {
				$account_custom_field = $this->request->post['custom_field']['account'];
			} else {
				$account_custom_field = array();
			}

			if (isset($this->request->post['custom_field']['address'])) {
				$address_custom_field = $this->request->post['custom_field']['address'];
			} else {
				$address_custom_field = array();
			}

			$data['register_custom_field'] = $account_custom_field + $address_custom_field;
		} else {
			$data['register_custom_field'] = array();
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		if (isset($this->request->post['newsletter'])) {
			$data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$data['newsletter'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_account_id'), true), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->request->post['agree'])) {
			$data['agree'] = $this->request->post['agree'];
		} else {
			$data['agree'] = false;
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$this->session->data["nav"]="user";
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		//wechat
		if(isset($_GET['code'])){
			try {
				$get_return=$this->load->controller('wechat/userinfo/getUsertoken');
				$this->load->model('wechat/userinfo');
				if(isset($get_return["openid"])){
					$log->write("register openid:".$get_return["openid"]);
					$wechatid = $this->model_wechat_userinfo->isUserValid($get_return["openid"]);
					if (isset($wechatid)) {
						$data["wechat_id"] = $wechatid;
					} else {
						$wechatinfo = $this->getUser($get_return["access_token"], $get_return["openid"]);
						$data["wechat_id"] = $this->model_wechat_userinfo->addWechatUser($wechatinfo);
					}
					$log->write("register wechat_id:".$data["wechat_id"]);
				}
				else{
					$log->write("register 没有取到openid");
					$this->error["error_warning"]=$get_return["errmsg"];
					$data["wechat_id"]="";
				}
			}
			catch(Exception $e){
				$this->error["error_warning"]=$e->getMessage();
				$data["wechat_id"]="";
				$this->response->setOutput($e->getMessage());
			}
		}
		else if(isset($this->request->post['wechat_id'])){
			$data['wechat_id'] = $this->request->post['wechat_id'];
		}
		else {

			$data['wechat_id'] = '';
		}

		try {
			//clinic
			$this->load->model('clinic/clinic');
			$data["departmentlist"] = $this->model_clinic_clinic->getOffices();
		}
		catch(Exception $e){
			$data["error_warning"]=$e->getMessage();
		}

		$this->response->setOutput($this->load->view('account/register', $data));

	}

	private function validate() {

        if ((utf8_strlen(trim($this->request->post['realname'])) < 1) || (utf8_strlen(trim($this->request->post['realname'])) > 32)) {
            $this->error['realname'] = $this->language->get('error_realname');
        }

		/*if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}*/

        if ($this->model_account_customer->getTotalCustomersByWechat($this->request->post['wechat_id'])) {
		    if($this->request->post['wechat_id']){
                $this->error['warning'] = $this->language->get('error_wechat_exists');
            }
        }

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

        /*if ((utf8_strlen(trim($this->request->post['department'])) < 3) || (utf8_strlen(trim($this->request->post['department'])) > 128)) {
            $this->error['department'] = $this->language->get('error_department');
        }*/

        if (!isset($this->request->post['department']) || $this->request->post['department'] == '') {
            $this->error['department'] = $this->language->get('department');
        }


        if ((utf8_strlen($this->request->post['barcode'])!= 12) ) {
           $this->error['barcode'] = $this->language->get('error_barcode');
        }


        if ((utf8_strlen($this->request->post['productiondate']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['productiondate'])) ) === strtotime( $this->request->post['productiondate'])){
            $this->error['productiondate'] = $this->language->get('error_productiondate');
        }

        if ((utf8_strlen($this->request->post['birthday']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['birthday'])) ) === strtotime( $this->request->post['birthday'])){
            $this->error['birthday'] = $this->language->get('error_birthday');
        }


        if ((utf8_strlen($this->request->post['lastmenstrualdate']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['lastmenstrualdate'])) ) === strtotime( $this->request->post['lastmenstrualdate'])){
            $this->error['lastmenstrualdate'] = $this->language->get('lastmenstrualdate');
        }

        if ((utf8_strlen($this->request->post['edc']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['edc'])) ) === strtotime( $this->request->post['edc'])){
            $this->error['edc'] = $this->language->get('edc');
        }


        /*if ((utf8_strlen($this->request->post['bmiindex'])!= 12) ) {
          $this->error['bmiindex'] = $this->language->get('error_bmiindex');
        }


        if (!isset($this->request->post['bmitype']) || $this->request->post['bmitype'] == '') {
            $this->error['bmitype'] = $this->language->get('bmitype');
        }*/



        if ((utf8_strlen($this->request->post['height'])!= 3) ) {
          $this->error['height'] = $this->language->get('error_height');
        }

        if ((utf8_strlen($this->request->post['weight'])<2)|| (utf8_strlen($this->request->post['weight'])>4)) {
            $this->error['weight'] = $this->language->get('error_weight');
        }

        if ((utf8_strlen($this->request->post['gravidity'])!= 1) ) {
            $this->error['gravidity'] = $this->language->get('error_gravidity');
        }

        if ((utf8_strlen($this->request->post['parity'])!= 1) ) {
            $this->error['parity'] = $this->language->get('error_parity');
        }

        if ((utf8_strlen($this->request->post['vaginaldelivery'])!= 1) ) {
            $this->error['vaginaldelivery'] = $this->language->get('error_vaginaldelivery');
        }

        if ((utf8_strlen($this->request->post['aesarean'])!= 1) ) {
            $this->error['aesarean'] = $this->language->get('error_aesarean');
        }

        if ((utf8_strlen($this->request->post['spontaneousabortion'])!= 1) ) {
            $this->error['spontaneousabortion'] = $this->language->get('error_spontaneousabortion');
        }

        if ((utf8_strlen($this->request->post['drug_inducedabortion'])!= 1) ) {
            $this->error['drug_inducedabortion'] = $this->language->get('drug_inducedabortion');
        }

        if ((utf8_strlen($this->request->post['fetal'])!= 1) ) {
            $this->error['fetal'] = $this->language->get('error_fetal');
        }

        if (!isset($this->request->post['highrisk']) || $this->request->post['highrisk'] == '') {
            $this->error['highrisk'] = $this->language->get('error_highrisk');
        }
        if (!isset($this->request->post['householdregister']) || $this->request->post['householdregister'] == '') {
            $this->error['householdregister'] = $this->language->get('error_householdregister');
        }



        if ((utf8_strlen(trim($this->request->post['highriskfactor'])) < 3) || (utf8_strlen(trim($this->request->post['highriskfactor'])) > 128)) {
            $this->error['highriskfactor'] = $this->language->get('error_highriskfactor');
        }

		if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		/*$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
			$this->error['postcode'] = $this->language->get('error_postcode');
		}

		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = $this->language->get('error_country');
		}*/

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
			$this->error['zone'] = $this->language->get('error_zone');
		}

		// Customer Group
		if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		// Custom field validation
		$this->load->model('account/custom_field');

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
            if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']])) {
				$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
			} elseif (($custom_field['type'] == 'text') && !empty($custom_field['validation']) && !filter_var($this->request->post['custom_field'][$custom_field['location']][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
            	$this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
            }
		}

		/*if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = $this->language->get('error_confirm');
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		// Agree to terms
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}*/

		return !$this->error;
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getUser($accesstoken,$openid){
		$log = new Log("wechat.log");
		$get_url=sprintf(WECHAT_GETUSERINFO,$accesstoken,$openid);
		$get_return = file_get_contents($get_url);
		$log->write("register openid:".$get_return["openid"]. "     result: ".$get_return);
		$get_return = (array)json_decode($get_return);
		return $get_return;
	}
}
