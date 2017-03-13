<?php
/**
 * Created by PhpStorm.
 * User: hwang
 * Date: 2017/3/13
 * Time: 14:28
 */

class ControllerDoctorIdentification extends Controller
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


    public function uploadimg()
    {


        $log = new Log("wechat.log");
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);// 获取文件后缀名


        $log-> write("文件后缀名".$extension ."     文件类型=".$_FILES["file"]["type"]);


        if ((($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/jpg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/x-png")
                || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 209715200)   // 小于 200 kb
            && in_array($extension, $allowedExts))
        {
            if ($_FILES["file"]["error"] > 0)
            {

                $response = array(
                    'code'  => 1060,
                    'message'  => $_FILES["file"]["error"] ,
                    'data' =>array(),
                );
            }
            else
            {



                // 判断当期目录下的 upload 目录是否存在该文件
                // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                if (file_exists("image/" . $_FILES["file"]["name"]))
                {
                    //echo $_FILES["file"]["name"] . " 文件已经存在。 ";
                }
                else
                {
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    move_uploaded_file($_FILES["images"]["tmp_name"], "image/" . $_FILES["file"]["name"]);
                    //echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
                }

                $result = array(
                    'filename' => $_FILES["file"]["name"],
                    'filetype' => $_FILES["file"]["type"],
                    'filesize' => ($_FILES["file"]["size"] / 1024),
                    'filetmpurl' => "be.jinxingjk.com/image/".$_FILES["file"]["tmp_name"]
                );


                $response = array(
                    'code'  => 0,
                    'message'  => "",
                    'data' =>array(),
                );
                $response["data"] = $result;


            }
        }
        else
        {

            $response = array(
                'code'  => 1061,
                'message'  => "非法的文件格式" ,
                'data' =>array(),
            );
            //echo "非法的文件格式";
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }





}