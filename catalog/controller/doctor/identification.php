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

        $customer_id = $this->request->json("customer_id","");

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
                //$fileurl = $this->createIdentificationUrl($customer_id);
                //$date = date("Y-m-d");
                //$filename = $doctor_id.$customer_id.$date.$_FILES["file"]["name"];
                //$filename = md5($filename);
                // 判断当期目录下的 upload 目录是否存在该文件
                // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
                //if (file_exists("image/" . $_FILES["file"]["name"]))
                //{
                    //echo $_FILES["file"]["name"] . " 文件已经存在。 ";
                //}
                //else
                //{
                    // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
                    move_uploaded_file($_FILES["file"]["tmp_name"], "image/".$_FILES["file"]["name"]/*$fileurl.$filename*/);
                    //echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
                //}

                $result = array(
                    'fileoriginname' => $_FILES["file"]["name"],
                    //'filename' => $filename,
                    'filetype' => $_FILES["file"]["type"],
                    'filesize' => ($_FILES["file"]["size"] / 1024),
                    'fileurl' => "image/".$_FILES["file"]["name"]//$fileurl.$filename
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

    public function createIdentificationUrl($customer_id){


        $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($customer_id);
        if (!empty($customer_info)) {
            $data['realname'] = $customer_info['realname'];
        } else {
            $data['realname'] = '';
        }

        $date = date("Y-m-d");

        if(!file_exists("image/identification/".$date)){
            mkdir("image/identification/".$date);
            chmod("image/identification/".$date , 0777);
        }

        if (!file_exists("image/identification".$date."/".$data['realname'])){
            mkdir("image/identification/".$date."/".$data['realname']);
            chmod("image/identification/".$date."/".$data['realname'], 0777);
        }

        $url = "image/identification/".$date."/".$data['realname']."/" ;

        return  $url ;

    }

}