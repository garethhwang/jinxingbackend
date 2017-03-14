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


        $data['doctor_id'] = $this->request->json('doctor_id', '');
        $data['customer_id'] = $this->request->json('customer_id', '');
        $this->load->model('doctor/doctor');
        $identification_info = $this->model_doctor_doctor->getIdentification($data['doctor_id'],$data['customer_id']);

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


    public function uploadimg()
    {

        $log = new Log("wechat.log");

        $pic_width_max=120;
        $pic_height_max=90;

        $doctor_id = $this->request->json('doctor_id', '');
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

        $customer_id = $this->request->json("customer_id");

        $customer_id = 593;

        $log->write("customer_id=".$customer_id);

        if(!isset($customer_id)){

            $response = array(
                'code'  => 1062,
                'message'  => "没有取得孕产妇信息" ,
                'data' =>array(),
            );
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return ;

        }

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

                $fileurl = $this->createIdentificationUrl($customer_id);
                $date = date("Y-m-d");
                $filename = $doctor_id.$customer_id.$date.$_FILES["file"]["name"];
                $filename = md5($filename);
                $fileresizename = $doctor_id.$customer_id.$date.$_FILES["file"]["name"]."resize";
                $filename = md5($filename).".".$extension;
                $fileresizename = md5($fileresizename).".".$extension;
                $uploadfile = $fileurl.$filename;
                $uploadfile_resize = $fileurl.$fileresizename;

                move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile);

                if($_FILES["file"]['size'])
                {
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
                }


                $result = array(
                    'customer_id' => $customer_id,
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

    public function createIdentificationUrl($customer_id){

        $log = new Log("wechat.log");

        $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($customer_id);

        $log->write("11111customer_id=".$customer_id);

        if (!empty($customer_info)) {
            $data['realname'] = $customer_info['realname'];
            $log->write("11111customer_name=".$data['realname']);

        } else {
            $data['realname'] = '';
        }

        $date = date("Y-m-d");

        if(!file_exists("image/identification/".$date)){
            mkdir("image/identification/".$date);
            chmod("image/identification/".$date , 0777);
        }

        if (!file_exists("image/identification/".$date."/".$data['realname'])){
            mkdir("image/identification/".$date."/".$data['realname']);
            chmod("image/identification/".$date."/".$data['realname'], 0777);
        }

        $url = "image/identification/".$date."/".$data['realname']."/" ;

        return  $url ;

    }

}