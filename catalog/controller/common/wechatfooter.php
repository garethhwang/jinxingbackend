<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/3
 * Time: 12:11
 */
class ControllerCommonWechatfooter extends Controller
{
    public function index()
    {
        $this->load->language('common/footer');
        $data['title'] = $this->document->getTitle();

        //mobile navigation
        if(isset($this->session->data["nav"])){
            $data['nav'] = $this->session->data["nav"];
        }
        else{
            $data['nav'] ="home";
        }

        return $this->load->view('common/wechatfooter', $data);
       // $this->response->setOutput($this->load->view('common/wechatfooter', $data));
    }

}