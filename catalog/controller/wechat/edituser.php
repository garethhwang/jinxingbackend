<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/12
 * Time: 19:36
 */
class ControllerWechatEdituser extends Controller
{
    private $error = array();

    public function index()
    {
        $log = new Log("wechat.log");

        $data["error_warning"] = "";
        $get_return = array();
        if (isset($this->session->data['openid'])) {
            $log->write("PersonalCenter openid:" . $this->session->data['openid']);
            $data['openid'] = $this->session->data['openid'];
            $this->error['warning'] = "";
        } else {
            $data['openid'] = "";
            $this->error['warning'] = "PersonalCenter： 微信信息没有获取到！";
            $log->write($this->error['warning']);
        }

        $data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';



        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);
        //$log->write("physical_id=" . $data["physical_id"]);

        /*
        if (!isset($data['customer_id'])) {
            $this->response->redirect($this->url->link('wechat/register', '', true));
        }*/

        $realname = $this->request->json('realname');
        $telephone = $this->request->json('telephone');
        $barcode = $this->request->json('barcode');
        $birthday = $this->request->json('birthday');
        $department = $this->request->json('department');
        $pregnantstatus=  $this->request->json('pregnantstatus');
        $height = $this->request->json('height');
        $weight = $this->request->json('weight');
        $lastmenstrualdate = $this->request->json('lastmenstrualdate');
        $gravidity = $this->request->json('gravidity');
        $parity = $this->request->json('parity');
        $vaginaldelivery = $this->request->json('vaginaldelivery');
        $aesarean = $this->request->json('aesarean');
        $spontaneousabortion = $this->request->json('spontaneousabortion');
        $drug_inducedabortion = $this->request->json('drug_inducedabortion');
        $highrisk = $this->request->json('highrisk');
        $highriskfactor = $this->request->json('highriskfactor');
        $householdregister= $this->request->json('householdregister');
        $district = $this->request->json('district');
        $address_1 = $this->request->json('address_1');
        

        $postdata  = array(
            'telephone' => $telephone,
            'realname'  => $realname,
            'barcode'  => $barcode,
            'birthday' => $birthday,
            'department' => $department,
            'height'   => $height,
            'weight'   => $weight,
            'pregnantstatus' => $datapregnantstatus,
            'lastmenstrualdate' => $datalastmenstrualdate,
            'gravidity' => $gravidity,
            'parity' => $parity,
            'vaginaldelivery' => $vaginaldelivery,
            'aesarean' => $aesarean,
            'spontaneousabortion' => $spontaneousabortion,
            'drug_inducedabortion'=> $drug_inducedabortion,
            'highrisk' => $highrisk,
            'highriskfactor' => $highriskfactor,
            'householdregister' => $householdregister,
            'district' => $district,
            'address_1' => $address_1,
            );



            $this->load->model('wechat/userinfo');
            $customer_info = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);
            $this->load->model('account/address');
            $customer_address = $this->model_account_address->getAddress($data["address_id"]);


            //$log->write("postdata[realname]=" . $postdata['realname']);
            //$log->write("info=" . $customer_info['realname']);
       
        if (isset($postdata['headimgurl'])) {
            $data['headimgurl'] = $postdata['headimgurl'];
        } elseif (!empty($customer_info)) {
            $data['headimgurl'] = $customer_info['headimgurl'];
        } else {
            $data['headimgurl'] = '';
        }

        if (isset($postdata['realname'])) {
            $data['realname'] = $postdata['realname'];
        } elseif (!empty($customer_info)) {
            $data['realname'] = $customer_info['realname'];
        } else {
            $data['realname'] = '';
        }

        //$log->write("realname=" . $data['realname']);


        if (isset($postdata['barcode'])) {
            $data['barcode'] = $postdata['barcode'];
        } elseif (!empty($customer_info)) {
            $data['barcode'] = $customer_info['barcode'];
        } else {
            $data['barcode'] = '';
        }

        if (isset($postdata['birthday'])) {
            $data['birthday'] = $postdata['birthday'];
        } elseif (!empty($customer_info)) {
            $data['birthday'] = $customer_info['birthday'];
        } else {
            $data['birthday'] = '';
        }

        if (isset($postdata['telephone'])) {
            $data['telephone'] = $postdata['telephone'];
        } elseif (!empty($customer_info)) {
            $data['telephone'] = $customer_info['telephone'];
        } else {
            $data['telephone'] = '';
        }


        if (isset($postdata['department'])) {
            $data['department'] = $postdata['department'];
        } elseif (!empty($customer_info)) {
            $data['department'] = $customer_info['department'];
        } else {
            $data['department'] = '';
        }

        if (isset($postdata['depname'])) {
            $data['depname'] = $postdata['depname'];
        } elseif (!empty($customer_info)) {
            $data['depname'] = $this->ConvertDepartment($customer_info['department']);
        } else {
            $data['depname'] = '';
        }

        /*if (isset($this->request->post['district'])) {
            $data['district'] = $this->request->post['district'];
        } elseif (!empty($customer_info)) {
            $data['district'] = $customer_info['district'];
        } else {
            $data['district'] = '';
        }

        if (isset($this->request->post['districtname'])) {
            $data['districtname'] = $this->request->post['districtname'];
        } elseif (!empty($customer_address)) {
            $data['districtname'] = $customer_address['city'];
        } else {
            $data['districtname'] = '';
        }*/


        if (isset($postdata['height'])) {
            $data['height'] = $postdata['height'];
        } elseif (!empty($customer_info)) {
            $data['height'] = $customer_info['height'];
        } else {
            $data['height'] = '';
        }

        if (isset($postdata['weight'])) {
            $data['weight'] = $postdata['weight'];
        } elseif (!empty($customer_info)) {
            $data['weight'] = $customer_info['weight'];
        } else {
            $data['weight'] = '';
        }

        if (isset($postdata['bmiindex'])) {
            $data['bmiindex'] = $postdata['bmiindex'];
        } elseif (!empty($customer_info)) {
            $data['bmiindex'] = $customer_info['bmiindex'];
        } else {
            $data['bmiindex'] = '';
        }

        if (isset($postdata['bmitype'])) {
            $data['bmitype'] = $postdata['bmitype'];
        } elseif (!empty($customer_info)) {
            $data['bmitype'] = $customer_info['bmitype'];
        } else {
            $data['bmitype'] = '';
        }

        if (isset($postdata['lastmenstrualdate'])) {
            $data['lastmenstrualdate'] = $postdata['lastmenstrualdate'];
        } elseif (!empty($customer_info)) {
            $data['lastmenstrualdate'] = $customer_info['lastmenstrualdate'];
        } else {
            $data['lastmenstrualdate'] = '';
        }

        if (isset($postdata['edc'])) {
            $data['edc'] = $postdata['edc'];
        } elseif (!empty($customer_info)) {
            $data['edc'] = $customer_info['edc'];
        } else {
            $data['edc'] = '';
        }

        if (isset($postdata['gravidity'])) {
            $data['gravidity'] = $postdata['gravidity'];
        } elseif (!empty($customer_info)) {
            $data['gravidity'] = $customer_info['gravidity'];
        } else {
            $data['gravidity'] = '';
        }

        if (isset($postdata['parity'])) {
            $data['parity'] = $postdata['parity'];
        } elseif (!empty($customer_info)) {
            $data['parity'] = $customer_info['parity'];
        } else {
            $data['parity'] = '';
        }

        if (isset($postdata['vaginaldelivery'])) {
            $data['vaginaldelivery'] = $postdata['vaginaldelivery'];
        } elseif (!empty($customer_info)) {
            $data['vaginaldelivery'] = $customer_info['vaginaldelivery'];
        } else {
            $data['vaginaldelivery'] = '';
        }

        if (isset($postdata['aesarean'])) {
            $data['aesarean'] = $postdata['aesarean'];
        } elseif (!empty($customer_info)) {
            $data['aesarean'] = $customer_info['aesarean'];
        } else {
            $data['aesarean'] = '';
        }

        if (isset($postdata['spontaneousabortion'])) {
            $data['spontaneousabortion'] = $postdata['spontaneousabortion'];
        } elseif (!empty($customer_info)) {
            $data['spontaneousabortion'] = $customer_info['spontaneousabortion'];
        } else {
            $data['spontaneousabortion'] = '';
        }

        if (isset($postdata['drug_inducedabortion'])) {
            $data['drug_inducedabortion'] = $postdata['drug_inducedabortion'];
        } elseif (!empty($customer_info)) {
            $data['drug_inducedabortion'] = $customer_info['drug_inducedabortion'];
        } else {
            $data['drug_inducedabortion'] = '';
        }

        if (isset($postdata['fetal'])) {
            $data['fetal'] = $postdata['fetal'];
        } elseif (!empty($customer_info)) {
            $data['fetal'] = $customer_info['fetal'];
        } else {
            $data['fetal'] = '';
        }

        if (isset($postdata['highrisk'])) {
            $data['highrisk'] = $postdata['highrisk'];
        } elseif (!empty($customer_info)) {
            $data['highrisk'] = $customer_info['highrisk'];
        } else {
            $data['highrisk'] = '';
        }

        if (isset($postdata['highriskfactor'])) {
            $data['highriskfactor'] = $postdata['highriskfactor'];
        } elseif (!empty($customer_info)) {
            $data['highriskfactor'] = $customer_info['highriskfactor'];
        } else {
            $data['highriskfactor'] = '';
        }

        if (isset($postdata['district'])) {
            $data['district'] = $postdata['district'];
        } elseif (!empty($customer_address)) {
            $data['district'] = $customer_address['city'];
        } else {
            $data['district'] = '';
        }

        if (isset($postdata['address_1'])) {
            $data['address_1'] = $postdata['address_1'];
        } elseif (!empty($customer_address)) {
            $data['address_1'] = $customer_address['address_1'];
        } else {
            $data['address_1'] = '';
        }

        if (isset($postdata['householdregister'])) {
            $data['householdregister'] = $postdata['householdregister'];
        } elseif (!empty($customer_address)) {
            $data['householdregister'] = $customer_address['householdregister'];
        } else {
            $data['householdregister'] = '';
        }




           $this->load->model('account/customer');

          
            $postdata["bmiindex"] = $postdata["weight"] / (pow($postdata["height"], 2) / 10000);
            $postdata["bmiindex"] = round($postdata["bmiindex"], 2);


            if ($postdata["bmiindex"] < "18.5") {
                $postdata["bmitype"] = "过轻";
            } else if ($postdata["bmiindex"] < "25") {
                $postdata["bmitype"] = "正常";
            } else if ($postdata["bmiindex"] < "28") {
                $postdata["bmitype"] = "过重";
            } else if ($postdata["bmiindex"] < "32") {
                $postdata["bmitype"] = "肥胖";
            } else {
                $postdata["bmitype"] = "非常肥胖";
            }

            if ($postdata["highrisk"] == "否") {
                $postdata["highriskfactor"] = "无";
            }

            $edc = date_create($postdata["lastmenstrualdate"]);
            $edc = date_modify($edc, "+280 days");
            $postdata["edc"] = date_format($edc, "Y/m/d");

            $this->model_account_customer->editCustomer($postdata);
            $this->load->model('account/physical');
            $this->model_account_physical->editPhysical($data["physical_id"], $postdata);
            $this->load->model('account/address');
            $this->model_account_address->editAddress($data["address_id"], $postdata);

            //$log->write("怀孕否=" . $this->request->post["ispregnant"]);

            //$this->session->data['success'] = $this->language->get('text_success');


            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name' => $this->customer->getRealName()
                );

                $this->model_account_activity->addActivity('register', $activity_data);
            }

            $this->response->redirect($this->url->link('account/personal_center', '', true));
        


        $data['heading_title'] = $this->language->get('heading_title');


        $data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_productiondate'] = $this->language->get('entry_productiondate');
        $data['entry_department'] = $this->language->get('entry_department');
        $data['entry_pregnantstatus'] = $this->language->get('entry_pregnantstatus');
        $data['entry_realname'] = $this->language->get('entry_realname');
        $data['entry_barcode'] = $this->language->get('entry_barcode');
        $data['entry_birthday'] = $this->language->get('entry_birthday');
        $data['entry_householdregister'] = $this->language->get('entry_householdregister');
        $data['entry_company'] = $this->language->get('entry_company');
        $data['entry_address_1'] = $this->language->get('entry_address');
        $data['entry_city'] = $this->language->get('entry_city');
        $data['entry_zone'] = $this->language->get('entry_zone');

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


        //$data['button_continue'] = $this->language->get('button_continue');
        //$data['button_upload'] = $this->language->get('button_upload');

        /*if (isset($this->error['warning'])) {
           $data['error_warning'] = $this->error['warning'];
       } else {
           $data['error_warning'] = '';
       }

      if (isset($this->error['realname'])) {
           $data['error_realname'] = $this->error['realname'];
       } else {
           $data['error_realname'] = '';
       }

       if (isset($this->error['telephone'])) {
           $data['error_telephone'] = $this->error['telephone'];
       } else {
           $data['error_telephone'] = '';
       }


       if (isset($this->error['productiondate'])) {
           $data['error_productiondate'] = $this->error['productiondate'];
       } else {
           $data['error_productiondate'] = '';
       }


       if (isset($this->error['department'])) {
           $data['error_department'] = $this->error['department'];
       } else {
           $data['error_department'] = '';
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

       /*if (isset($this->error['postcode'])) {
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

       if (isset($this->error['agree'])) {
           $data['error_agree'] = $this->error['agree'];
       } else {
           $data['error_agree'] = '';
       }

       if (isset($this->error['confirm'])) {
           $data['error_confirm'] = $this->error['confirm'];
       } else {
           $data['error_confirm'] = '';
       }*/

        //$data['action'] = $this->url->link('wechat/edituser', '', true);

        $data['customer_groups'] = array();


        
           

        // Custom Fields
        $this->load->model('account/custom_field');

        $data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

        if (isset($postdata['custom_field'])) {
            if (isset($postdata['custom_field']['account'])) {
                $account_custom_field = $postdata['custom_field']['account'];
            } else {
                $account_custom_field = array();
            }

            if (isset($postdata['custom_field']['address'])) {
                $address_custom_field = $postdata['custom_field']['address'];
            } else {
                $address_custom_field = array();
            }

            $data['register_custom_field'] = $account_custom_field + $address_custom_field;
        } else {
            $data['register_custom_field'] = array();
        }


        //$this->load->model('clinic/clinic');
        //$data["departmentlist"] = $this->model_clinic_clinic->getOffices();
        $data["provs_data"] = json_encode($this->load->controller('wechat/wechatbinding/getProvince'));
        $data["citys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getCity'));
        $data["dists_data"] = json_encode($this->load->controller('wechat/wechatbinding/getDistrict'));
        $data["allcitys_data"] = json_encode($this->load->controller('wechat/wechatbinding/getAllCity'));
        $data["deps_data"] = json_encode($this->load->controller('wechat/wechatbinding/getOffice'));

        $this->document->setTitle("个人信息");


        $data['footer'] = $this->load->controller('common/wechatfooter');
        $data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"] = "personal_center";


        $result  = array(
            'error_warning' =>  $data['error_warning'], 
            'headimgurl' =>  $data['headimgurl'],
            'realname' =>  $data['realname'],
            'telephone' =>  $data['telephone'],
            'barcode' =>  $data['barcode'],
            'department' =>  $data['department'],
            'pregnantstatus' =>  $data['pregnantstatus'],
            'birthday' =>  $data['birthday'],
            'height' =>  $data['height'],
            'weight' =>  $data['weight'],
            'bmitype' =>  $data['bmitype'],
            'bmiindex' =>  $data['bmiindex'],
            'lastmenstrualdate' =>  $data['lastmenstrualdate'],
            'gravidity' =>  $data['gravidity'],
            'parity' =>  $data['parity'],
            'edc' =>  $data['edc'],
            'vaginaldelivery' =>  $data['vaginaldelivery'],
            'aesarean' =>  $data['aesarean'],
            'spontaneousabortion' =>  $data['spontaneousabortion'],
            'drug_inducedabortion' =>  $data['drug_inducedabortion'],
            'highriskfactor' =>  $data['highriskfactor'],
            'highrisk' =>  $data['highrisk'],
            'district' =>  $data['district'],
            'address_1' =>  $data['address_1'],
            'footer' => $data['footer'],
            'header' => $data['header'],
            );

      $response = array(
        'code'  => 0,
        'message'  => "",
        'data' =>array(),
    );
    $response["data"] = $result;

        //$this->response->setOutput($this->load->view('wechat/edituser', $data));
    }

    public function ConvertDepartment($department)
    {
        $temp_arr = explode(",", $department);
        $this->load->model('wechat/userinfo');
        if (count($temp_arr) == 3) {
            $cityName = $this->model_wechat_userinfo->getCityName($temp_arr[0]);
            $districtName = $this->model_wechat_userinfo->getDistrictName($temp_arr[1]);
            $officeName = $this->model_wechat_userinfo->getOfficeName($temp_arr[2]);
            return $cityName . "市" . $districtName . "区" . $officeName;
        }

    }

    public function ConvertPosition($position)
    {
        $temp_arr = explode(",", $position);
        $this->load->model('clinic/clinic');
        if (count($temp_arr) == 3) {
            $provinceName = $this->model_clinic_clinic->getProvince($temp_arr[0]);
            $cityName = $this->model_clinic_clinic->getCity($temp_arr[1]);
            $districtName = $this->model_clinic_clinic->getDistrict($temp_arr[1]);
            return $provinceName . "," . $cityName . "," . $districtName;
        }

    }
}