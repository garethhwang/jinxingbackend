<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/12
 * Time: 21:37
 */
class ControllerProductDurationVisitProductDurationVisit extends Controller
{
    private $error = array();
    public function index() {
        $this->document->setTitle('科室列表');

        $this->load->model('clinic/clinic');

        $this->getlist();
    }

    public function getlist(){

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['filter_province_name'])) {
            $filter_province_name = $this->request->get['filter_province_name'];
        }else {
            $filter_province_name = null;
        }

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        }else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_city_name'])) {
            $filter_city_name = $this->request->get['filter_city_name'];
        }else {
            $filter_city_name = null;
        }

        if (isset($this->request->get['filter_district_name'])) {
            $filter_district_name = $this->request->get['filter_district_name'];
        }else {
            $filter_district_name = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'office_id';
        }

        $url = '';

        if (isset($this->request->get['filter_province_name'])) {
            $url .= '&filter_province_name=' . $this->request->get['filter_province_name'];
        }

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_city_name'])) {
            $url .= '&filter_city_name=' . $this->request->get['filter_city_name'];
        }

        if (isset($this->request->get['filter_district_name'])) {
            $url .= '&filter_district_name=' . $this->request->get['filter_district_name'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['filter_office_id'])) {
            $url .= '&filter_office_id=' . $this->request->get['filter_office_id'];
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

        $filter_province_id = $this->model_clinic_clinic->getProvinceidByProvinceName($filter_province_name);
        $filter_city_id = $this->model_clinic_clinic->getCityidByCityName($filter_city_name);
        $filter_district_id = $this->model_clinic_clinic->getDistrictidByDistrictName($filter_district_name);

        $filter_data = array(
            'province_id' => $filter_province_id,
            'city_id' => $filter_city_id,
            'district_id' => $filter_district_id,
            'sort'  => $sort,
            'order' => $order
        );

        $results = $this->model_clinic_clinic->getOffices($filter_data);

        foreach ($results as $result) {

            $province_name = $this->model_clinic_clinic->getProvinceByProvinceid($result['province_id']);
            $city_name = $this->model_clinic_clinic->getCityByCityid($result['city_id']);
            $district_name =  $this->model_clinic_clinic->getDistrictByDistrictid($result['district_id']);

            $data['offices'][] = array(
                'office_id'   => $result['office_id'],
                'name'         => $result['name'],
                'district_id' => $result['district_id'],
                'district_name' => $district_name,
                'city_id'      => $result['city_id'],
                'city_name'    => $city_name,
                'province_id'  => $result['province_id'],
                'province_name' => $province_name,
                'edit'           => $this->url->link('clinic/clinic/edit', 'token=' . $this->session->data['token'] . '&office_id=' . $result['office_id'] . $url, true)
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
        $data['column_action'] = '操作';
        $data['text_no_results'] = '没有查到相应信息';


        $data['token'] = $this->session->data['token'];
        $data['filter_name'] = $filter_name;
        $data['filter_province_name'] = $filter_province_name;
        $data['filter_city_name'] = $filter_city_name;
        $data['filter_district_name'] = $filter_district_name;
        $data['filter_province_id'] = $filter_province_id;
        $data['filter_city_id'] = $filter_city_id;
        $data['filter_district_id'] = $filter_district_id;

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

        if (isset($this->request->get['filter_province_name'])) {
            $url .= '&filter_province_name=' . $this->request->get['filter_province_name'];
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

        $data['sort_name'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
        $data['sort_province_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=province_id' . $url, true);
        $data['sort_city_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=city_id' . $url, true);
        $data['sort_district_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=district_id' . $url, true);
        $data['sort_office_id'] = $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . '&sort=office_id' . $url, true);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');


        //$this->response->setOutput($filter_province_id);
        $this->response->setOutput($this->load->view('clinic/clinic', $data));

    }

    public function add(){
        $data["error_warning"]="";
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        //getprovicelist
        $results = $this->model_clinic_clinic->getProvinces();

        foreach ($results as $result) {
            $data['provinces'][] = array(
                'province_id'   => $result['name']
            );
        }

        if (isset($this->request->post['name'])) {
            $data['name'] = $this->request->post['name'];
        } else {
            $data['name'] = "";
        }

        if (isset($this->request->post['city'])) {
            $data['city'] = $this->request->post['city'];
        } else {
            $data['city'] = "";
        }

        if (isset($this->request->post['district_id'])) {
            $data['district_id'] = $this->request->post['district_id'];
        } else {
            $data['district_id'] = "";
        }

        if (isset($this->request->post['office_desc'])) {
            $data['office_desc'] = $this->request->post['office_desc'];
        } else {
            $data['office_desc'] = "";
        }

        $url = '';
        $data['action']=$this->url->link('clinic/clinic/save', 'token=' . $this->session->data['token'] . $url, true);
        $data['save']= $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true);
        $data['cancel']= $this->url->link('clinic/clinic', 'token=' . $this->session->data['token'] . $url, true);
        $this->response->setOutput($this->load->view('clinic/addclinic', $data));
    }

    public function delete(){

    }

    public function save(){

    }

}