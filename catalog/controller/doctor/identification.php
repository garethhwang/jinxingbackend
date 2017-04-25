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

    public function index(){

        $log = new Log("wechat.log");

        $jxsession = $this->load->controller('account/authentication');
        if(empty($jxsession)) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($jxsession),true);

        $data['doctor_id'] = $this->request->json('doctor_id', '');
        $data['customer_id'] = $this->request->json('customer_id', '');
        $this->load->model('doctor/identification');
        $identification_info = $this->model_doctor_identification->getIdentification($data['doctor_id'],$data['customer_id']);
        $identification_info['jxsession'] = $jxsession ;

        /*if(empty($doctor_info)){
            $response = array(
                'code'  => 1011,
                'message'  => "如需要使用本功能，请您注册",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
        }*/

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] =  $identification_info;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }

    public function submit()
    {
        $log = new Log("wechat.log");

        $data["jxsession"] = $this->load->controller('account/authentication');
        if(empty($data["jxsession"])) {
            $response = array(
                'code'  => 1002,
                'message'  => "欢迎来到金杏健康，请您先登录",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;
        }
        $customer_info = json_decode($this->cache->get($data["jxsession"]),true);

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

        $data['customer_id'] = $this->request->json('customer_id', '');
        $data['identification_text'] = $this->request->json('identification_text', '');
        $data['face_img'] = $this->request->json('face_img', '');
        $data['tongue_img'] = $this->request->json('tongue_img', '');
        $data['face_img_thumbnail'] = $this->request->json('face_img_thumbnail', '');
        $data['tongue_img_thumbnail'] = $this->request->json('tongue_img_thumbnail', '');



        $postdata  = array(
            'doctor_id' => $data['doctor_id'],
            'customer_id' => $data['customer_id'],
            'identification_text' => $data['identification_text'],
            'face_img' => $data['face_img'],
            'tongue_img' => $data['tongue_img'],
            'face_img_thumbnail' => $data['face_img_thumbnail'],
            'tongue_img_thumbnail' => $data['tongue_img_thumbnail']
        );

        $this->load->model('doctor/identification');

        $this->model_doctor_identification->addIdentification($postdata);

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $data;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

        //$this->response->setOutput($this->load->view('wechat/edituser', $data));
    }


    public function upload() {
        $base64 = "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";
        $url = base64_decode($base64);

        $response = array(
            'code'  => 0,
            'message'  => "",
            'data' =>array(),
        );
        $response["data"] = $url ;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($response));

    }
    public function uploadimg()
    {

        $log = new Log("wechat.log");

        $pic_width_max=120;
        $pic_height_max=90;

        //$doctor_id = $this->request->json('doctor_id', '');
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

        //$customer_id = $this->request->json("customer_id");


        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);// 获取文件后缀名

        $log-> write("file= ".$_FILES."       文件后缀名".$extension ."     文件类型=".$_FILES["file"]["type"]);

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

                $fileurl = $this->createIdentificationUrl();
                $date = date("Y-m-d");
                $filename = $date.$_FILES["file"]["name"];
                $filename = md5($filename);
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

    public function createIdentificationUrl(){


        $date = date("Ymd");

        if(!file_exists("image/identification/".$date)){
            mkdir("image/identification/".$date);
            chmod("image/identification/".$date , 0777);
        }

        $url = "image/identification/".$date."/";

        return  $url ;

    }

}