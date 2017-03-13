<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/12
 * Time: 23:26
 */
class ControllerDoctorEdit extends Controller
{
    private $error = array();

    public function index()
    {
        $log = new Log("wechat.log");


        $data['doctor_id'] = $this->request->json('doctor_id', '');
        $this->load->model('doctor/doctor');
        $doctor_info = $this->model_doctor_doctor->getDoctor($data['doctor_id']);

        if (!empty($doctor_info)) {
            $data['name'] = $doctor_info['name'];
        } else {
            $data['name'] = '';
        }

        if (!empty($doctor_info)) {
            $data['sex'] = $doctor_info['sex'];
        } else {
            $data['sex'] = '';
        }

        if (!empty($doctor_info)) {
            $data['img'] = $doctor_info['img '];
        } else {
            $data['img'] = '';
        }

        if (!empty($doctor_info)) {
            $data['telephone'] = $doctor_info['telephone'];
        } else {
            $data['telephone'] = '';
        }

        if (!empty($doctor_info)) {
            $data['starrating'] = $doctor_info['starrating'];
        } else {
            $data['starrating'] = '';
        }

        if (!empty($doctor_info)) {
            $data['discription'] = $doctor_info['discription'];
        } else {
            $data['discription'] = '';
        }

        if (!empty($doctor_info)) {
            $data['department'] = $doctor_info['department'];
        } else {
            $data['department'] = '';
        }

        if (!empty($doctor_info)) {
            $data['depname'] = $this->ConvertDepartment($doctor_info['department']);
        } else {
            $data['depname'] = '';
        }

        $data["citys_data"] = $this->load->controller('wechat/wechatbinding/getCity');
        $data["dists_data"] = $this->load->controller('wechat/wechatbinding/getDistrict');
        $data["allcitys_data"] = $this->load->controller('wechat/wechatbinding/getAllCity');
        $data["deps_data"] = $this->load->controller('wechat/wechatbinding/getOffice');


        $result  = array(
            'name' =>  $data['name'],
            'telephone' =>  $data['telephone'],
            'sex' =>  $data['sex'],
            'img' =>  $data['img'],
            'department' =>  $data['depname'],
            'discription' =>  $data['discription'],
            'starrating' =>  $data['starrating'],
        );

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $result;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/edituser', $data));
    }


    public function modify(){


        $data['doctor_id'] = $this->request->json('doctor_id', '');
        $data['name'] = $this->request->json('name', '');
        $data['telephone'] = $this->request->json('telephone', '');
        $data['sex'] = $this->request->json('sex', '');
        $data['img'] = $this->request->json('img', '');
        $data['department'] = $this->request->json('department', '');
        $data['discription'] =  $this->request->json('discription', '');
        $data['starrating'] = $this->request->json('starrating', '');

        $postdata  = array(
            'name' =>  $data['name'],
            'telephone' =>  $data['telephone'],
            'sex' =>  $data['sex'],
            'img' =>  $data['img'],
            'department' =>  $data['depname'],
            'discription' =>  $data['discription'],
            'starrating' =>  $data['starrating'],
        );

        $this->load->model('doctor/doctor');

        $this->model_doctor_doctor->editCustomer($postdata, $data["doctor_id"]);

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

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