<?php
class ControllerAccountPhysical extends Controller {
    private $error = array();

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/physical', '', true);

            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $this->load->language('account/physical');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/physical');

        $this->getList();
    }

    /*public function add() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/physical', '', true);

            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $this->load->language('account/physical');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->model('account/physical');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_account_physical->addPhysical($this->request->post);

            $this->session->data['success'] = $this->language->get('text_add');

            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'realname'        => $this->customer->getRealName()
                );

                $this->model_account_activity->addActivity('physical_add', $activity_data);
            }

            $this->response->redirect($this->url->link('account/physical', '', true));
        }

        $this->getForm();
    }*/

    public function edit() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/physical', '', true);

            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $this->load->language('account/physical');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
        $this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
        $this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

        $this->load->model('account/physical');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_account_physical->editPhysical($this->request->get['physical_id'], $this->request->post);


            $this->session->data['success'] = $this->language->get('text_edit');

            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'realname'        => $this->customer->getRealName()
                );

                $this->model_account_activity->addActivity('physical_edit', $activity_data);
            }

            $this->response->redirect($this->url->link('account/physical', '', true));
        }

        $this->getForm();
    }

    public function delete() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/physical', '', true);

            $this->response->redirect($this->url->link('account/login', '', true));
        }

        $this->load->language('account/physical');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/physical');

        if (isset($this->request->get['physical_id']) && $this->validateDelete()) {
            $this->model_account_physical->deletePhysical($this->request->get['physical_id']);

            $this->session->data['success'] = $this->language->get('text_delete');

            // Add to activity log
            if ($this->config->get('config_customer_activity')) {
                $this->load->model('account/activity');

                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'realname'        => $this->customer->getRealName()
                );

                $this->model_account_activity->addActivity('physical_delete', $activity_data);
            }

            $this->response->redirect($this->url->link('account/physical', '', true));
        }

        $this->getList();
    }

    protected function getList() {
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('account/physical', '', true)
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_physical_book'] = $this->language->get('text_physical_book');
        $data['text_empty'] = $this->language->get('text_empty');

        //$data['button_new_physical'] = $this->language->get('button_new_physical');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_back'] = $this->language->get('button_back');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['physical'] = array();

        $result = $this->model_account_physical->getPhysical();

        if ($result['physical_format']) {
            $format = $result['physical_format'];
        } else {
            $format = '{realname}' . "\n" . '{height}' ."\n" . '{weight}'. "\n" . '{bmiindex}' . "\n" . '{bmitype}' . "\n" . '{lastmenstrualdata}' . "\n" . '{edc}' . "\n" . '{gravidity}' . "\n" . '{parity}' . "\n" . '{vaginaldelivery}' . "\n" . '{aesarean}' . "\n" . '{spontaneousabortion}' . "\n" . '{drug_inducedabortion}' . "\n" . '{fetal}' . "\n" . '{highrisk}' . "\n" . '{highriskfactor}';
        }

        $find = array(
                '{realname}',
                '{height}',
                '{weight}',
                '{bmiindex}',
                '{bmitype}',
                '{lastmenstrualdata}',
                '{edc}',
                '{gravidity}',
                '{parity}',
                '{vaginaldelivery}',
                '{aesarean}',
                '{spontaneousabortion}',
                '{drug_inducedabortion}',
                '{fetal}',
                '{highrisk}',
                '{highriskfactor}'
        );

        $replace = array(
                'realname'      => $result->row['realname'],
                'height'        => $result->row['height'],
                'weight'        => $result->row['weight'],
                'bmiindex'      => $result->row['bmiindex'],
                'bmitype'      => $result->row['bmitype'],
                'lastmenstrualdata'       => $result->row['lastmenstrualdata'],
                'edc'           => $result->row['edc'],
                'gravidity'        => $result->row['gravidity'],
                'parity'           => $result->row['parity'],
                'vaginaldelivery'      =>$result->row['vaginaldelivery'],
                'aesarean'     => $result->row['aesarean'],
                'spontaneousabortion'        => $result->row['spontaneousabortion'],
                'drug_inducedabortion'     => $result->row['drug_inducedabortion'],
                'fetal'     => $result->row['fetal'],
                'highrisk' => $result->row['highrisk'],
                'highriskfactor'   => $result->row['highriskfactor']
         );

            $data['physical'] = array(
                'physical_id' => $result['physical_id'],
                'physical'    => str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format)))),
                'update'     => $this->url->link('account/physical/edit', 'physical_id=' . $result['physical_id'], true),
                'delete'     => $this->url->link('account/physical/delete', 'physical_id=' . $result['physical_id'], true)
            );


        $data['add'] = $this->url->link('account/physical/add', '', true);
        $data['back'] = $this->url->link('account/account', '', true);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $this->session->data["nav"]="user";
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('account/physical_list', $data));
    }

    protected function getForm() {
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
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('account/physical', '', true)
        );

        if (!isset($this->request->get['physical_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit_physical'),
                'href' => $this->url->link('account/physical/add', '', true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_edit_physical'),
                'href' => $this->url->link('account/physical/edit', 'physical_id=' . $this->request->get['physical_id'], true)
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit_physical'] = $this->language->get('text_edit_physical');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_select'] = $this->language->get('text_select');
        $data['text_none'] = $this->language->get('text_none');
        $data['text_loading'] = $this->language->get('text_loading');

        $data['entry_realname'] = $this->language->get('entry_realname');
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
        $data['button_back'] = $this->language->get('button_back');
        $data['button_upload'] = $this->language->get('button_upload');

        if (isset($this->error['realname'])) {
            $data['error_realname'] = $this->error['realname'];
        } else {
            $data['error_realname'] = '';
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

        if (isset($this->error['custom_field'])) {
            $data['error_custom_field'] = $this->error['custom_field'];
        } else {
            $data['error_custom_field'] = array();
        }

        if (!isset($this->request->get['physical_id'])) {
            $data['action'] = $this->url->link('account/physical/add', '', true);
        } else {
            $data['action'] = $this->url->link('account/physical/edit', 'physical_id=' . $this->request->get['physical_id'], true);
        }

        if (isset($this->request->get['physical_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $physical_info = $this->model_account_physical->getphysical($this->request->get['physical_id']);
        }

        if (isset($this->request->post['realname'])) {
            $data['realname'] = $this->request->post['realname'];
        } elseif (!empty($physical_info)) {
            $data['realname'] = $physical_info['realname'];
        } else {
            $data['realname'] = '';
        }

        if (isset($this->request->post['height'])) {
            $data['height'] = $this->request->post['height'];
        } elseif (!empty($physical_info)) {
            $data['height'] = $physical_info['height'];
        } else {
            $data['height'] = '';
        }

        if (isset($this->request->post['weight'])) {
            $data['weight'] = $this->request->post['weight'];
        } elseif (!empty($physical_info)) {
            $data['weight'] = $physical_info['weight'];
        } else {
            $data['weight'] = '';
        }

        if (isset($this->request->post['bmiindex'])) {
            $data['bmiindex'] = $this->request->post['bmiindex'];
        } elseif (!empty($physical_info)) {
            $data['bmiindex'] = $physical_info['bmiindex'];
        } else {
            $data['bmiindex'] = '';
        }
        if (isset($this->request->post['bmitype'])) {
            $data['bmitype'] = $this->request->post['bmitype'];
        } elseif (!empty($physical_info)) {
            $data['bmitype'] = $physical_info['bmitype'];
        } else {
            $data['bmitype'] = '';
        }
        if (isset($this->request->post['lastmenstrualdata'])) {
            $data['lastmenstrualdata'] = $this->request->post['lastmenstrualdata'];
        } elseif (!empty($physical_info)) {
            $data['lastmenstrualdata'] = $physical_info['lastmenstrualdata'];
        } else {
            $data['lastmenstrualdata'] = '';
        }
        if (isset($this->request->post['edc'])) {
            $data['edc'] = $this->request->post['edc'];
        } elseif (!empty($physical_info)) {
            $data['edc'] = $physical_info['edc'];
        } else {
            $data['edc'] = '';
        }
        if (isset($this->request->post['gravidity'])) {
            $data['gravidity'] = $this->request->post['gravidity'];
        } elseif (!empty($physical_info)) {
            $data['gravidity'] = $physical_info['gravidity'];
        } else {
            $data['gravidity'] = '';
        }
        if (isset($this->request->post['parity'])) {
            $data['parity'] = $this->request->post['parity'];
        } elseif (!empty($physical_info)) {
            $data['parity'] = $physical_info['parity'];
        } else {
            $data['parity'] = '';
        }
        if (isset($this->request->post['vaginaldelivery'])) {
            $data['vaginaldelivery'] = $this->request->post['vaginaldelivery'];
        } elseif (!empty($physical_info)) {
            $data['vaginaldelivery'] = $physical_info['vaginaldelivery'];
        } else {
            $data['vaginaldelivery'] = '';
        }
        if (isset($this->request->post['aesarean'])) {
            $data['aesarean'] = $this->request->post['aesarean'];
        } elseif (!empty($physical_info)) {
            $data['aesarean'] = $physical_info['aesarean'];
        } else {
            $data['aesarean'] = '';
        }
        if (isset($this->request->post['spontaneousabortion'])) {
            $data['spontaneousabortion'] = $this->request->post['spontaneousabortion'];
        } elseif (!empty($physical_info)) {
            $data['spontaneousabortion'] = $physical_info['spontaneousabortion'];
        } else {
            $data['spontaneousabortion'] = '';
        }
        if (isset($this->request->post['drug_inducedabortion'])) {
            $data['drug_inducedabortion'] = $this->request->post['drug_inducedabortion'];
        } elseif (!empty($physical_info)) {
            $data['drug_inducedabortion'] = $physical_info['drug_inducedabortion'];
        } else {
            $data['drug_inducedabortion'] = '';
        }
        if (isset($this->request->post['fetal'])) {
            $data['fetal'] = $this->request->post['fetal'];
        } elseif (!empty($physical_info)) {
            $data['fetal'] = $physical_info['fetal'];
        } else {
            $data['fetal'] = '';
        }
        if (isset($this->request->post['highrisk'])) {
            $data['highrisk'] = $this->request->post['highrisk'];
        } elseif (!empty($physical_info)) {
            $data['highrisk'] = $physical_info['highrisk'];
        } else {
            $data['highrisk'] = '';
        }
        if (isset($this->request->post['highriskfactor'])) {
            $data['highriskfactor'] = $this->request->post['highriskfactor'];
        } elseif (!empty($physical_info)) {
            $data['highriskfactor'] = $physical_info['highriskfactor'];
        } else {
            $data['highriskfactor'] = '';
        }
        if (isset($this->request->post['householdregister'])) {
            $data['householdregister'] = $this->request->post['householdregister'];
        } elseif (!empty($physical_info)) {
            $data['householdregister'] = $physical_info['householdregister'];
        } else {
            $data['householdregister'] = '';
        }

        // Custom fields
        $this->load->model('account/custom_field');

        $data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

        if (isset($this->request->post['custom_field'])) {
            $data['address_custom_field'] = $this->request->post['custom_field'];
        } elseif (isset($physical_info)) {
            $data['address_custom_field'] = $physical_info['custom_field'];
        } else {
            $data['address_custom_field'] = array();
        }



        $data['back'] = $this->url->link('account/physical', '', true);

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


        $this->response->setOutput($this->load->view('account/physical_form', $data));
    }

    protected function validateForm() {
        if ((utf8_strlen(trim($this->request->post['realname'])) < 1) || (utf8_strlen(trim($this->request->post['realname'])) > 32)) {
            $this->error['realname'] = $this->language->get('error_realname');
        }

        if ((utf8_strlen($this->request->post['lastmenstrualdate']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['lastmenstrualdate'])) ) === strtotime( $this->request->post['lastmenstrualdate'])){
            $this->error['lastmenstrualdate'] = $this->language->get('lastmenstrualdate');
        }

        if ((utf8_strlen($this->request->post['edc']) > 96) || !strtotime( date('Y-m-d', strtotime($this->request->post['edc'])) ) === strtotime( $this->request->post['edc'])){
            $this->error['edc'] = $this->language->get('edc');
        }


        /*if ((utf8_strlen($this->request->post['bmiindex'])!= 12) ) {
          $this->error['bmiindex'] = $this->language->get('error_bmiindex');
      }*/


        if (!isset($this->request->post['bmitype']) || $this->request->post['bmitype'] == '') {
            $this->error['bmitype'] = $this->language->get('bmitype');
        }



        if ((utf8_strlen($this->request->post['height'])!= 3) ) {
            $this->error['height'] = $this->language->get('error_height');
        }


        if ((utf8_strlen($this->request->post['weight'])<2)|| (utf8_strlen($this->request->post['weight'])>3)) {
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
            $this->error['highrisk'] = $this->language->get('highrisk');
        }



        if ((utf8_strlen(trim($this->request->post['highriskfactor'])) < 3) || (utf8_strlen(trim($this->request->post['highriskfactor'])) > 128)) {
            $this->error['highriskfactor'] = $this->language->get('error_highriskfactor');
        }

        // Custom field validation
        $this->load->model('account/custom_field');

        $custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

        foreach ($custom_fields as $custom_field) {
            if (($custom_field['location'] == 'physical') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
                $this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
            } elseif (($custom_field['location'] == 'physical') && ($custom_field['type'] == 'text') && !empty($custom_field['validation']) && !filter_var($this->request->post['custom_field'][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
                $this->error['custom_field'][$custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
            }
        }

        return !$this->error;
    }

    protected function validateDelete() {

        if ($this->customer->getPhysicalId() == $this->request->get['physical_id']) {
            $this->error['warning'] = $this->language->get('error_default');
        }

        return !$this->error;
    }
}
