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

        /*if(empty($doctor_info)){
            $response = array(
                'code'  => 1011,
                'message'  => "如需要使用本功能，请您注册",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
        }*/

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
            $data['img'] = $doctor_info['img'];
        } else {
            $data['img'] = '';
        }

        if (!empty($doctor_info)) {
            $data['img_thumbnail'] = $doctor_info['img_thumbnail'];
        } else {
            $data['img_thumbnail'] = '';
        }

        if (!empty($doctor_info)) {
            $data['district'] = $doctor_info['district'];
        } else {
            $data['district'] = '';
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
            'doctor_id' => $data["doctor_id"],
            'name' =>  $data['name'],
            'telephone' =>  $data['telephone'],
            'sex' =>  $data['sex'],
            'img' =>  $data['img'],
            'img_thumbnail' => $data['img_thumbnail'],
            'district' => $data['district'],
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
        /*$this->load->model('doctor/doctor');
        $doctor_info = $this->model_doctor_doctor->getDoctor($data['doctor_id']);

        if(empty($doctor_info)){
            $response = array(
                'code'  => 1011,
                'message'  => "如需要使用本功能，请您注册",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
        }*/


        //$data['doctor_id'] = $this->request->json('doctor_id', '');
        $data['name'] = $this->request->json('name', '');
        //$data['telephone'] = $this->request->json('telephone', '');
        $data['sex'] = $this->request->json('sex', '');
        $data['img'] = $this->request->json('img', '');
        $data['img_thumbnail'] = $this->request->json('img_thumbnail', '');
        $data['department'] = $this->request->json('department', '');
        $data['district'] = $this->request->json('district', '');
        $data['discription'] =  $this->request->json('discription', '');
        $data['starrating'] = $this->request->json('starrating', '');

        $postdata  = array(
            'name' =>  $data['name'],
            //'telephone' =>  $data['telephone'],
            'sex' =>  $data['sex'],
            'img' =>  $data['img'],
            'img_thumbnail' => $data['img_thumbnail'],
            'district' => $data['district'],
            'department' =>  $data['department'],
            'discription' =>  $data['discription'],
            'starrating' =>  $data['starrating'],
        );

        $this->load->model('doctor/doctor');

        $this->model_doctor_doctor->editDoctor($postdata, $data["doctor_id"]);

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

    public function uploaddocimg()
    {

        $log = new Log("wechat.log");


        $pic_width_max=120;
        $pic_height_max=90;

        //$doctor_id= $this->request->json('doctor_id', '');
        /*$this->load->model('doctor/doctor');
        $doctor_info = $this->model_doctor_doctor->getDoctor($data['doctor_id']);

        if(empty($doctor_info)){
            $response = array(
                'code'  => 1011,
                'message'  => "如需要使用本功能，请您注册",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
        }*/

        //$customer_id = $this->request->json("customer_id","");

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
            && ($_FILES["file"]["size"] < 20971520)   // 小于 20Mb
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
                $fileurl = $this->createDctorUrl();
                $date = date("Y-m-d");
                $filename = $date.$_FILES["file"]["name"];
                $fileresizename = $date.$_FILES["file"]["name"]."resize";
                $filename = md5($filename).".".$extension;
                $fileresizename = md5($fileresizename).".".$extension;
                $uploadfile = $fileurl.$filename;
                $uploadfile_resize = $fileurl.$fileresizename;

                move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile);

                if($_FILES["file"]['size'] > 81920) {

                    if($_FILES["file"]["type"] == "image/pjpeg" || $_FILES["file"]["type"] == "image/jpg" || $_FILES["file"]["type"] == "image/jpeg")
                    {
                        //$im = imagecreatefromjpeg($_FILES[$upload_input_name]['tmp_name']);
                        $im = imagecreatefromjpeg($uploadfile);
                    }
                    elseif($_FILES["file"]["type"] == "image/x-png" || $_FILES["file"]["type"] == "image/png")
                    {
                        //$im = imagecreatefrompng($_FILES[$upload_input_name]['tmp_name']);
                        $im = imagecreatefrompng($uploadfile);
                    }
                    elseif($_FILES["file"]["type"] == "image/gif")
                    {
                        //$im = imagecreatefromgif($_FILES[$upload_input_name]['tmp_name']);
                        $im = imagecreatefromgif($uploadfile);
                    }
                    else//默认jpg
                    {
                        $im = imagecreatefromjpeg($uploadfile);
                    }
                    if($im)
                    {
                        $this->ResizeImage($im,$pic_width_max,$pic_height_max,$uploadfile_resize);

                        ImageDestroy ($im);
                    }
                } else {

                    $uploadfile_resize =  $uploadfile;

                }


                $result = array(

                    'fileoriginname' => $_FILES["file"]["name"],
                    'filename' => $filename,
                    'fileresizename' => $fileresizename,
                    'filetype' => $_FILES["file"]["type"],
                    'filesize' => ($_FILES["file"]["size"] / 1024),
                    'fileurl' => $uploadfile,
                    'fileresizeurl' => $uploadfile_resize
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


    public function ResizeImage($uploadfile,$maxwidth,$maxheight,$name){
        //取得当前图片大小
        $width = imagesx($uploadfile);
        $height = imagesy($uploadfile);
        $i=0.5;
        //生成缩略图的大小
        if(($width > $maxwidth) || ($height > $maxheight))
        {
            /*
            $widthratio = $maxwidth/$width;
            $heightratio = $maxheight/$height;

            if($widthratio < $heightratio)
            {
                $ratio = $widthratio;
            }
            else
            {
                 $ratio = $heightratio;
            }

            $newwidth = $width * $ratio;
            $newheight = $height * $ratio;
            */
            $newwidth = $width * $i;
            $newheight = $height * $i;
            if(function_exists("imagecopyresampled"))
            {
                $uploaddir_resize = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($uploaddir_resize, $uploadfile, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            }
            else
            {
                $uploaddir_resize = imagecreate($newwidth, $newheight);
                imagecopyresized($uploaddir_resize, $uploadfile, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            }

            ImageJpeg ($uploaddir_resize,$name);
            ImageDestroy ($uploaddir_resize);
        }
        else
        {
            ImageJpeg ($uploadfile,$name);
        }
    }

    public function createDctorUrl(){

            $date = date("Ymd");

            if(!file_exists("image/doctor/".$date)) {
                mkdir("image/doctor/".$date);
                chmod("image/doctor/".$date , 0777);
            }


            $url = "image/doctor/".$date."/";

            return  $url ;

    }




}