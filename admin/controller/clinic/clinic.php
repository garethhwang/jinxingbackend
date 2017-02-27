<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:37
 */
class ControllerClinicClinic extends Controller
{
    private $error = array();

    public function index()
    {

        $this->document->setTitle('科室列表');

        $this->load->model('clinic/clinic');

        $this->getlist();
    }

    public function getlist()
    {
        $log = new Log("admin.log");
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['filter_province_id'])) {
            $filter_province_id = $this->request->get['filter_province_id'];
            $data["citylist"] = $this->model_clinic_clinic->getCitiesByProvinceId($filter_province_id);
            $log->write("clinic getlist request filter_province_id:" . $filter_province_id);
        } else {
            $filter_province_id = null;
            $data["citylist"]=null;
        }

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_city_id'])) {
            $filter_city_id = $this->request->get['filter_city_id'];
            $data["districtlist"] = $this->model_clinic_clinic->getDistrictByCityId($filter_city_id);
        } else {
            $filter_city_id = null;
            $data["districtlist"]=null;
        }

        if (isset($this->request->get['filter_district_id'])) {
            $filter_district_id = $this->request->get['filter_district_id'];
            $data["officelist"] = $this->model_clinic_clinic->getOffice($filter_district_id);
        } else {
            $filter_district_id = null;
            $data["officelist"]=null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'office_id';
        }

        $url = '';

        if (isset($this->request->get['filter_province_id'])) {
            $url .= '&filter_province_id=' . $this->request->get['filter_province_id'];
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_city_id'])) {
            $url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
        }

        if (isset($this->request->get['filter_district_id'])) {
            $url .= '&filter_district_id=' . $this->request->get['filter_district_id'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => '主页',
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => '科室列表',
            'href' => $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true)
        );

        $data['add'] = $this->url->link('clinic/clinic/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete'] = $this->url->link('clinic/clinic/delete', 'token=' . $this->session->data['token'] . $url, true);

        $data['offices'] = array();
        //$filter_district_id = $this->model_clinic_clinic->getDistrictidByDistrictName($filter_district_name);

        $filter_data = array(
            'province_id' => $filter_province_id,
            'city_id' => $filter_city_id,
            'district_id' => $filter_district_id,
            'office_id' => $filter_name,
            'sort' => $sort,
            'order' => $order
        );

        $results = $this->model_clinic_clinic->getOffices($filter_data);

        foreach ($results as $result) {

            $province_name = $this->model_clinic_clinic->GetProvinceNameByProvinceId($result['province_id']);
            $city_name = $this->model_clinic_clinic->GetCityNameByCityId($result['city_id']);
            $district_name = $this->model_clinic_clinic->GetDistrictNameByDistrictId($result['district_id']);
            $department_id = urlencode($result['city_id'] . ',' . $result['district_id'] . ',' . $result['office_id']);

            $data['offices'][] = array(
                'office_id' => $result['office_id'],
                'name' => $result['name'],
                'district_id' => $result['district_id'],
                'district_name' => $district_name,
                'city_id' => $result['city_id'],
                'city_name' => $city_name,
                'province_id' => $result['province_id'],
                'province_name' => $province_name,
                'edit' => $this->url->link('clinic/clinic/edit', 'token=' . $this->session->data['token'] . '&office_id=' . $result['office_id'] . $url, true),
                'office_customer' => $this->url->link('customer/customer', 'token=' . $this->session->data['token'] . '&office_id=' . $department_id . $url, true)
            );
        }

        $data['heading_title'] = '科室管理';
        $data['text_list'] = '科室列表';

        $data['office_name'] = '科室名称';
        $data['office_id'] = '科室ID';
        $data['province'] = '省';
        $data['city'] = '城市';
        $data['district'] = '区县';
        $data['button_filter'] = '筛选';
        $data['button_edit'] = '编辑';
        $data['button_add'] = '添加';
        $data['button_delete'] = '删除';
        $data['column_action'] = '操作';
        $data['text_no_results'] = '没有查到相应信息';
        $data['text_confirm'] = '确认删除？';
        $data['button_office_customer'] = '会员列表';

        $data['token'] = $this->session->data['token'];
        $data['filter_name'] = $filter_name;
        $data['filter_district_id'] = $filter_district_id;
        $data['filter_province_id'] = $filter_province_id;
        $data['filter_city_id'] = $filter_city_id;

        $data['sort'] = $sort;
        $data['order'] = $order;

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

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }
        $url = '';

        if (isset($this->request->get['filter_province_id'])) {
            $url .= '&filter_province_id=' . $this->request->get['filter_province_id'];
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_city_id'])) {
            $url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
        }

        if (isset($this->request->get['filter_district_id'])) {
            $url .= '&filter_district_id=' . $this->request->get['filter_district_id'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['filter_office_id'])) {
            $url .= '&filter_office_id=' . $this->request->get['filter_office_id'];
        }
        if ($order == 'ASC') {
            $url .= '&order=ASC';
        } else {
            $url .= '&order=DESC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data["provincelist"] = $this->model_clinic_clinic->getProvinces();

        $data['sort_name'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
        $data['sort_province_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=province_id' . $url, true);
        $data['sort_city_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=city_id' . $url, true);
        $data['sort_district_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=district_id' . $url, true);
        $data['sort_office_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=office_id' . $url, true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('clinic/clinic', $data));

    }

    public function add()
    {
        $data["error_warning"] = "";
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        //getprovicelist
        $this->load->model('clinic/clinic');
        $data["provincelist"] = $this->model_clinic_clinic->getProvinces();

        if (isset($this->request->post['province_id'])) {
            $data['province_id'] = $this->request->post['province_id'];
            $data["citylist"] = $this->model_clinic_clinic->getCitiesByProvinceId($data['province_id']);
        } else {
            $data['province_id'] = "";
            $data["citylist"]=null;
        }

        if (isset($this->request->post['office_name'])) {
            $data['office_name'] = $this->request->post['office_name'];
        } else {
            $data['office_name'] = "";
        }

        if (isset($this->request->post['city_id'])) {
            $data['city_id'] = $this->request->post['city_id'];
            $data["districtlist"] = $this->model_clinic_clinic->getDistrictByCityId($data['city_id']);
        } else {
            $data['city_id'] = "";
            $data["districtlist"]=null;
        }

        if (isset($this->request->post['district_id'])) {
            $data['district_id'] = $this->request->post['district_id'];
        } else {
            $data['district_id'] = "";
        }

        var_dump($data['district_id'] );

        if (isset($this->request->post['office_desc'])) {
            $data['office_desc'] = $this->request->post['office_desc'];
        } else {
            $data['office_desc'] = "";
        }

        $url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->load->model('clinic/clinic');
            $this->model_clinic_clinic->addOffice($this->request->post);
            $this->response->redirect($this->url->link('clinic/success', '', true));
        }

        $data['action'] = $this->url->link('clinic/clinic/add', 'token=' . $this->session->data['token'] . $url, true);
        $data['cancel'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true);
        $this->response->setOutput($this->load->view('clinic/addclinic', $data));
    }

    public function edit()
    {
        $data["error_warning"] = "";
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $office_id = '';

        if (isset($this->request->get['office_id'])) {
            $office_id = $this->request->get['office_id'];
        } else {
            $office_id = 1;
        }

        $this->load->model('clinic/clinic');
        $data["provincelist"] = $this->model_clinic_clinic->getProvinces();

        if ($office_id) {
            $office_info = $this->model_clinic_clinic->GetOfficeInfoByOfficeId($office_id);
        }
        if ($office_info) {
            $data['office_id'] = $office_info['office_id'];
            $data['office_name'] = $office_info['name'];
            $province_id = $office_info['province_id'];
            $city_id = $office_info['city_id'];
            $district_id = $office_info['district_id'];
        }

        $url = '';

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            if (isset($this->request->post['office_name'])) {
                $data['office_name'] = $this->request->post['office_name'];
            }

            if (isset($this->request->post['district_id'])) {
                $district_id = $this->request->post['district_id'];
                $data['district_id'] = $district_id;
            }

            if (isset($this->request->post['city_id'])) {
                $city_id = $this->request->post['city_id'];
                $data['city_id'] = $city_id;
            }

            if (isset($this->request->post['province_id'])) {
                $province_id = $this->request->post['province_id'];
                $data['province_id'] = $province_id;
            }

            $this->load->model('clinic/clinic');
            $this->model_clinic_clinic->updateOffice($data);
            $this->response->redirect($this->url->link('clinic/success', 'token=' . $this->session->data['token'] . $url, true));

        }

        $data['action'] = $this->url->link('clinic/clinic/edit', 'token=' . $this->session->data['token'] . '&office_id=' . $data['office_id'] . $url, true);
        $data['cancel'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true);
        $this->response->setOutput($this->load->view('clinic/addclinic', $data));;
    }

    public function update()
    {
        $this->response->setOutput('update');
    }

    private function validate()
    {
        $this->load->model('clinic/clinic');

        if ((utf8_strlen(trim($this->request->post['office_name'])) < 1) || (utf8_strlen(trim($this->request->post['office_name'])) > 32)) {
            $this->error['office_name'] = '科室名字规则错误';
        }
        /*
                if(isset($this->request->post['city_name']))
                {
                    $city_name = $this->request->post['city_name'];
                    $city_id = $this->model_clinic_clinic->getCityidByCityName($city_name);
                    if(int($city_id) <= 0)
                    {
                        $this->error['city_name'] = '当前城市没有开展业务';
                    }
                }

                if(isset($this->request->post['district_name']))
                {
                    $district_name = $this->request->post['district_name'];
                    $district_id = $this->model_clinic_clinic->getDistrictidByDistrictName($district_name);
                    if(int($district_id) <= 0)
                    {
                        $this->error['district_name'] = '当前城市没有开展业务';
                    }
                }

                if (utf8_strlen(trim($this->request->post['office_desc'])) < 1)  {
                    $this->error['office_desc'] = '地址错误';
                }
        */
        return !$this->error;
    }

    public function delete()
    {

        $this->document->setTitle('科室列表');

        $this->load->model('clinic/clinic');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $office_id) {
                $this->model_clinic_clinic->deleteOffice($office_id);
            }

            $this->session->data['success'] = '成功';

            $url = '';

            if (isset($this->request->get['filter_province_id'])) {
                $url .= '&filter_province_id=' . $this->request->get['filter_province_id'];
            }
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_city_id'])) {
                $url .= '&filter_city_id=' . $this->request->get['filter_city_id'];
            }

            if (isset($this->request->get['filter_district_id'])) {
                $url .= '&filter_district_id=' . $this->request->get['filter_district_id'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true));
        }

        $this->getList();
    }

    public function validateDelete()
    {
        return true;
    }

    public function save()
    {

    }

    public function getAllCity()
    {
        $this->load->model('clinic/clinic');
        $log = new Log("admin.log");
        $log->write("getAllCity:" + $this->request->get['provinceid']);
        if (isset($this->request->get['provinceid'])) {
            $returndata = $this->model_clinic_clinic->getCitiesByProvinceId($this->request->get['provinceid']);
            $this->response->setOutput(json_encode($returndata));
        }
    }

    public function getAllDistinct()
    {

        $this->load->model('clinic/clinic');

        if (isset($this->request->get['cityid'])) {
            $returndata = $this->model_clinic_clinic->getDistrictByCityId($this->request->get['cityid']);
            $this->response->setOutput(json_encode($returndata));
        }
    }

    public function getAllOffice()
    {

        $this->load->model('clinic/clinic');
        if (isset($this->request->get['districtid'])) {
            $returndata = $this->model_clinic_clinic->getOffice($this->request->get['districtid']);
            $this->response->setOutput(json_encode($returndata));
        }
    }

}