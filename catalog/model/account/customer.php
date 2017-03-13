<?php
class ModelAccountCustomer extends Model
{
    public function addCustomer($data)
    {
        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);


        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', realname = '" . $this->db->escape($data['realname']) . "', email = '". $this->db->escape("aa@126.com") . "', telephone = '" . $this->db->escape($data['telephone']) . "', barcode = '" . $this->db->escape($data['barcode']) . "', birthday = '" . $this->db->escape($data['birthday']) . "', department = '" . $this->db->escape($data['department']) . "', pregnantstatus = '1 ', wechat_id = '" . $this->db->escape($data['wechat_id']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "', receiptdate = DATE_ADD( '".$this->db->escape($data['lastmenstrualdate'])."',INTERVAL 10 WEEK),ispregnant = '1', date_added = NOW()");

        $customer_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', householdregister = '" . $this->db->escape($data['householdregister']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['district']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "physical SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', height = '" . $this->db->escape($data['height']) . "',weight = '" . $this->db->escape($data['weight']) . "', bmiindex = '" . $this->db->escape($data['bmiindex']) . "', bmitype = '" . $this->db->escape($data['bmitype']) . "', lastmenstrualdate = '" . $this->db->escape($data['lastmenstrualdate']) . "', edc = '" . $this->db->escape($data['edc']) . "', gravidity = '" . $this->db->escape($data['gravidity']) . "', parity = '" . $this->db->escape($data['parity']) . "', vaginaldelivery = '" . $this->db->escape($data['vaginaldelivery']) . "', aesarean = '" . $this->db->escape($data['aesarean']) . "', spontaneousabortion = '" . $this->db->escape($data['spontaneousabortion']) . "', drug_inducedabortion = '" . $this->db->escape($data['drug_inducedabortion']) . "', fetal = '0', highrisk = '" . $this->db->escape($data['highrisk']) . "', highriskfactor = '" . $this->db->escape($data['highriskfactor']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['physical']) ? json_encode($data['custom_field']['physical']) : '') . "'");

        //', bmiindex = '" . $this->db->escape($data['bmiindex']) . "', bmitype = '" . $this->db->escape($data['bmitype']) . "

        $physical_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET physical_id = '" . (int)$physical_id . "' WHERE customer_id = '" . (int)$customer_id . "'");


        $lastmenstrual = $this->db->query("SELECT lastmenstrualdate FROM " . DB_PREFIX . "physical  WHERE customer_id = '" . (int)$customer_id . "'");

        $lastmenstrualdate = $lastmenstrual->row['lastmenstrualdate'];

        $temp = date_create($lastmenstrualdate);
        $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create($lastmenstrualdate);
        $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');


        $this->db->query("INSERT INTO " . DB_PREFIX . "checklist SET customer_id = '" . (int)$customer_id . "',lastmenstrualdate ='".$lastmenstrualdate."', fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'");

        $this->load->language('mail/customer');

        $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

        $message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";

        if (!$customer_group_info['approval']) {
            $message .= $this->language->get('text_login') . "\n";
        } else {
            $message .= $this->language->get('text_approval') . "\n";
        }

        $message .= $this->url->link('account/login', '', true) . "\n\n";
        $message .= $this->language->get('text_services') . "\n\n";
        $message .= $this->language->get('text_thanks') . "\n";
        $message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        //$mail->setTo($data['email']);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject($subject);
        $mail->setText($message);
        //$mail->send();

        // Send to main admin email if new account email is enabled
        if (in_array('account', (array)$this->config->get('config_mail_alert'))) {
            $message = $this->language->get('text_signup') . "\n\n";
            $message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
            $message .= $this->language->get('text_realname') . ' ' . $data['realname'] . "\n";
            $message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
            $message .= $this->language->get('text_email') . ' ' . $data['email'] . "\n";
            $message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
            $mail->smtp_username = $this->config->get('config_mail_smtp_username');
            $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
            $mail->smtp_port = $this->config->get('config_mail_smtp_port');
            $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

            $mail->setTo($this->config->get('config_email'));
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
            $mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
            $mail->setText($message);
            $mail->send();

            // Send to additional alert emails if new account email is enabled
            $emails = explode(',', $this->config->get('config_alert_email'));

            foreach ($emails as $email) {
                if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail->setTo($email);
                    $mail->send();
                }
            }
        }

        return $customer_id;
    }

    public function addNonpregnant($data){


        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', realname = '" . $this->db->escape($data['realname']) . "', email = '". $this->db->escape("aa@126.com") . "', telephone = '" . $this->db->escape($data['telephone']) . "', pregnantstatus = '" . $this->db->escape($data['pregnantstatus']) . " ',babybirth = '" . $this->db->escape($data['babybirth']) . "', wechat_id = '" . $this->db->escape($data['wechat_id']) . "', department = NULL , custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "',receiptdate = NULL ,ispregnant = '0',date_added = NOW()");

        $customer_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', householdregister = '是',  address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['district']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "physical SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['physical']) ? json_encode($data['custom_field']['physical']) : '') . "'");

        //height = '',weight = '', bmiindex = '', bmitype = '', lastmenstrualdate = '', edc = '', gravidity = '', parity = '', vaginaldelivery = '', aesarean = '', spontaneousabortion = '', drug_inducedabortion = '', fetal = '', highrisk = '', highriskfactor = '',

        $physical_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET physical_id = '" . (int)$physical_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
        $temp = date_create();
        $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create();
        $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create();
        $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create();
        $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create();
        $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create();
        $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create();
        $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create();
        $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create();
        $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create();
        $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create();
        $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create();
        $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');


        $this->db->query("INSERT INTO " . DB_PREFIX . "checklist SET customer_id = '" . (int)$customer_id . "',lastmenstrualdate =NOW(), fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'");

        return $customer_id;

    }

    /*public function editNonpregnant($data){

        $customer_id = $this->customer->getId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET realname = '" . $this->db->escape($data['realname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "' WHERE customer_id = '" . (int)$customer_id . "'");
    }*/

    public function addPuerpera($data){


        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', language_id = '" . (int)$this->config->get('config_language_id') . "', realname = '" . $this->db->escape($data['realname']) . "', email = '". $this->db->escape("aa@126.com") . "', telephone = '" . $this->db->escape($data['telephone']) . "',babybirth = '" . $this->db->escape($data['babybirth']) . "', pregnantstatus = '2 ', wechat_id = '" . $this->db->escape($data['wechat_id']) . "', department = NULL , custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? json_encode($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = token(9)) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int)!$customer_group_info['approval'] . "',receiptdate = NULL ,ispregnant = '0',date_added = NOW()");

        $customer_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', householdregister = '是',  address_1 = '" . $this->db->escape($data['address_1']) . "', city = '" . $this->db->escape($data['district']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? json_encode($data['custom_field']['address']) : '') . "'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "physical SET customer_id = '" . (int)$customer_id . "', realname = '" . $this->db->escape($data['realname']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['physical']) ? json_encode($data['custom_field']['physical']) : '') . "'");

        //height = '',weight = '', bmiindex = '', bmitype = '', lastmenstrualdate = '', edc = '', gravidity = '', parity = '', vaginaldelivery = '', aesarean = '', spontaneousabortion = '', drug_inducedabortion = '', fetal = '', highrisk = '', highriskfactor = '',

        $physical_id = $this->db->getLastId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET physical_id = '" . (int)$physical_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
        /*$temp = date_create();
        $fircheck = date_modify($temp,"+12 weeks");$fircheck = date_format($fircheck,'Y-m-d');$firchecks = date_create($fircheck);$firchecks = date_modify($firchecks,"+7 days");$firchecks = date_format($firchecks,'Y-m-d');$temp = date_create();
        $seccheck = date_modify($temp,"+16 weeks");$seccheck = date_format($seccheck,'Y-m-d');$secchecks = date_create($seccheck);$secchecks = date_modify($secchecks,"+7 days");$secchecks = date_format($secchecks,'Y-m-d');$temp = date_create();
        $thicheck = date_modify($temp,"+20 weeks");$thicheck = date_format($thicheck,'Y-m-d');$thichecks = date_create($thicheck);$thichecks = date_modify($thichecks,"+7 days");$thichecks = date_format($thichecks,'Y-m-d');$temp = date_create();
        $foucheck = date_modify($temp,"+24 weeks");$foucheck = date_format($foucheck,'Y-m-d');$fouchecks = date_create($foucheck);$fouchecks = date_modify($fouchecks,"+7 days");$fouchecks = date_format($fouchecks,'Y-m-d');$temp = date_create();
        $fifcheck = date_modify($temp,"+28 weeks");$fifcheck = date_format($fifcheck,'Y-m-d');$fifchecks = date_create($fifcheck);$fifchecks = date_modify($fifchecks,"+7 days");$fifchecks = date_format($fifchecks,'Y-m-d');$temp = date_create();
        $sixcheck = date_modify($temp,"+30 weeks");$sixcheck = date_format($sixcheck,'Y-m-d');$sixchecks = date_create($sixcheck);$sixchecks = date_modify($sixchecks,"+7 days");$sixchecks = date_format($sixchecks,'Y-m-d');$temp = date_create();
        $sevcheck = date_modify($temp,"+32 weeks");$sevcheck = date_format($sevcheck,'Y-m-d');$sevchecks = date_create($sevcheck);$sevchecks = date_modify($sevchecks,"+7 days");$sevchecks = date_format($sevchecks,'Y-m-d');$temp = date_create();
        $eigcheck = date_modify($temp,"+36 weeks");$eigcheck = date_format($eigcheck,'Y-m-d');$eigchecks = date_create($eigcheck);$eigchecks = date_modify($eigchecks,"+7 days");$eigchecks = date_format($eigchecks,'Y-m-d');$temp = date_create();
        $nincheck = date_modify($temp,"+37 weeks");$nincheck = date_format($nincheck,'Y-m-d');$ninchecks = date_create($nincheck);$ninchecks = date_modify($ninchecks,"+7 days");$ninchecks = date_format($ninchecks,'Y-m-d');$temp = date_create();
        $tencheck = date_modify($temp,"+38 weeks");$tencheck = date_format($tencheck,'Y-m-d');$tenchecks = date_create($tencheck);$tenchecks = date_modify($tenchecks,"+7 days");$tenchecks = date_format($tenchecks,'Y-m-d');$temp = date_create();
        $tenseccheck = date_modify($temp,"+39 weeks");$tenseccheck = date_format($tenseccheck,'Y-m-d');$tensecchecks = date_create($tenseccheck);$tensecchecks = date_modify($tensecchecks,"+7 days");$tensecchecks = date_format($tensecchecks,'Y-m-d');$temp = date_create();
        $tenthicheck = date_modify($temp,"+40 weeks");$tenthicheck = date_format($tenthicheck,'Y-m-d');$tenthichecks = date_create($tenthicheck);$tenthichecks = date_modify($tenthichecks,"+7 days");$tenthichecks = date_format($tenthichecks,'Y-m-d');


        $this->db->query("INSERT INTO " . DB_PREFIX . "checklist SET customer_id = '" . (int)$customer_id . "',lastmenstrualdate =NOW(), fircheck =  '".$fircheck."',fircheckurl =  '" . checklist . "1?start=".$fircheck."&end=".$firchecks."' , seccheck =  '".$seccheck."', seccheckurl =  '" . checklist . "2?start=".$seccheck."&end=".$secchecks."' , thicheck =  '".$thicheck."', thicheckurl =  '" . checklist . "3?start=".$thicheck."&end=".$thichecks."' , foucheck =  '".$foucheck."', foucheckurl =  '" . checklist . "4?start=".$foucheck."&end=".$fouchecks."' , fifcheck =  '".$fifcheck."', fifcheckurl =  '" . checklist . "5?start=".$fifcheck."&end=".$fifchecks."' , sixcheck =  '".$sixcheck."', sixcheckurl =  '" . checklist . "6?start=".$sixcheck."&end=".$sixchecks."' , sevcheck =  '".$sevcheck."', sevcheckurl =  '" . checklist . "7?start=".$sevcheck."&end=".$sevchecks."' , eigcheck =  '".$eigcheck."', eigcheckurl =  '" . checklist . "8?start=".$eigcheck."&end=".$eigchecks."' , nincheck =  '".$nincheck."', nincheckurl =  '" . checklist . "9?start=".$nincheck."&end=".$ninchecks."' , tencheck =  '".$tencheck."', tencheckurl =  '" . checklist . "10?start=".$tencheck."&end=".$tenthichecks."&firend=".$tenchecks."&secstart=".$tenseccheck."&secend=".$tensecchecks."&thistart=".$tenthicheck."'");*/

        return $customer_id;

    }



    public function editCustomer($data, $customer_id)
    {
        //$customer_id = $this->customer->getId();

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET realname = '" . $this->db->escape($data['realname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', barcode = '" . $this->db->escape($data['barcode']) . "', birthday = '" . $this->db->escape($data['birthday']) . "', department = '" . $this->db->escape($data['department']) . "', pregnantstatus = '1', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "',receiptdate = DATE_ADD( '".$this->db->escape($data['lastmenstrualdate'])."',INTERVAL 10 WEEK),ispregnant = '1' WHERE customer_id = '" . (int)$customer_id . "'");

        //email = '" . $this->db->escape($data['email']) . "', productiondate = '" . $this->db->escape($data['productiondate']) . "', fax = '" . $this->db->escape($data['fax']) . "', pregnantstatus = '" . $this->db->escape($data['pregnantstatus']) . "'

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

    public function getCustomer($customer_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");

        return $query->row;
    }

    public function getNonpregnant($nonpregnant_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nonpregnant WHERE nonpregnant_id = '" . (int)$nonpregnant_id . "'");

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

    public function  confirmpregnant($customer_id){
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET pregnantstatus = '2' WHERE customer_id = '".$customer_id."'");
    }

    public function  addbabybirth($babybirth){
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET babybirth ='".$babybirth."' ");
    }

    public function  getCustomerInfo(){

        $result = $this->db->query("select realname, headimgurl from wechat_user, " . DB_PREFIX . "customer,  where  wechat_user.wechat_id = " . DB_PREFIX . "customer.wechat_id ");

        return $result->rows;
    }

}