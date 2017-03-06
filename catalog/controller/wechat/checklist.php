<?php

/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2017/1/10
 * Time: 15:47
 */
class  ControllerWechatChecklist extends Controller
{
    private $error = array();

    public function index()
    {

        //$this->session->data['openid']='oKe2EwWLwAU7EQu7rNof5dfG1U8g';
        $log = new Log("wechat.log");

        if(isset($this->session->data['openid'])){
            $data["openid"] = $this->session->data['openid'];
        }
        else{
            $data["openid"] = "";
        }
        //wechat
        $code = $this->request->json("code","");
        if($code){
            $this->load->controller('wechat/userinfo/getUsertoken');
            $codeinfo = $this->cache->get($code);
            $codeinfo=json_decode($codeinfo,true);
            $data["openid"] = $codeinfo["openid"];
            $data["wechat_id"] = $codeinfo["wechat_id"];
        }else{
            $response = array(
                'code'  => 1001,
                'message'  => "微信信息没有获取到！",
                'data' =>array(),
            );

            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($response));
            return;
        }




        $this->customer->wechatlogin($data["openid"]);
        unset($this->session->data['guest']);

        $this->load->model('wechat/userinfo');
        $data = $this->model_wechat_userinfo->getCustomerByWechat($data["openid"]);
        //$lastmenstrualdate = date_format($data["lastmenstrualdate"],"Y-m-d");

        $temp = date_create($data["lastmenstrualdate"]);
        $data["fircheck"] = date_modify($temp,"+12 weeks");$data["fircheck"] = date_format($data["fircheck"],'Y-m-d');
        $data["firchecks"] = date_create($data["fircheck"]);$data["firchecks"] = date_modify($data["firchecks"],"+7 days");$data["firchecks"] = date_format($data["firchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["seccheck"] = date_modify($temp,"+16 weeks");$data["seccheck"] = date_format($data["seccheck"],'Y-m-d');
        $data["secchecks"] = date_create($data["seccheck"]);$data["secchecks"] = date_modify($data["secchecks"],"+7 days");$data["secchecks"] = date_format($data["secchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["thicheck"] = date_modify($temp,"+20 weeks");$data["thicheck"] = date_format($data["thicheck"],'Y-m-d');
        $data["thichecks"] = date_create($data["thicheck"]);$data["thichecks"] = date_modify($data["thichecks"],"+7 days");$data["thichecks"] = date_format($data["thichecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["foucheck"] = date_modify($temp,"+24 weeks");$data["foucheck"] = date_format($data["foucheck"],'Y-m-d');
        $data["fouchecks"] = date_create($data["foucheck"]);$data["fouchecks"] = date_modify($data["fouchecks"],"+7 days");$data["fouchecks"] = date_format($data["fouchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["fifcheck"] = date_modify($temp,"+28 weeks");$data["fifcheck"] = date_format($data["fifcheck"],'Y-m-d');
        $data["fifchecks"] = date_create($data["fifcheck"]);$data["fifchecks"] = date_modify($data["fifchecks"],"+7 days");$data["fifchecks"] = date_format($data["fifchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["sixcheck"] = date_modify($temp,"+30 weeks");$data["sixcheck"] = date_format($data["sixcheck"],'Y-m-d');
        $data["sixchecks"] = date_create($data["sixcheck"]);$data["sixchecks"] = date_modify($data["sixchecks"],"+7 days");$data["sixchecks"] = date_format($data["sixchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["sevcheck"] = date_modify($temp,"+32 weeks");$data["sevcheck"] = date_format($data["sevcheck"],'Y-m-d');
        $data["sevchecks"] = date_create($data["sevcheck"]);$data["sevchecks"] = date_modify($data["sevchecks"],"+7 days");$data["sevchecks"] = date_format($data["sevchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["eigcheck"] = date_modify($temp,"+36 weeks");$data["eigcheck"] = date_format($data["eigcheck"],'Y-m-d');
        $data["eigchecks"] = date_create($data["eigcheck"]);$data["eigchecks"] = date_modify($data["eigchecks"],"+7 days");$data["eigchecks"] = date_format($data["eigchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["nincheck"] = date_modify($temp,"+37 weeks");$data["nincheck"] = date_format($data["nincheck"],'Y-m-d');
        $data["ninchecks"] = date_create($data["nincheck"]);$data["ninchecks"] = date_modify($data["ninchecks"],"+7 days");$data["ninchecks"] = date_format($data["ninchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["tencheck"] = date_modify($temp,"+38 weeks");$data["tencheck"] = date_format($data["tencheck"],'Y-m-d');
        $data["tenchecks"] = date_create($data["tencheck"]);$data["tenchecks"] = date_modify($data["tenchecks"],"+7 days");$data["tenchecks"] = date_format($data["tenchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["tenseccheck"] = date_modify($temp,"+39 weeks");$data["tenseccheck"] = date_format($data["tenseccheck"],'Y-m-d');
        $data["tensecchecks"] = date_create($data["tenseccheck"]);$data["tensecchecks"] = date_modify($data["tensecchecks"],"+7 days");$data["tensecchecks"] = date_format($data["tensecchecks"],'Y-m-d');

        $temp = date_create($data["lastmenstrualdate"]);
        $data["tenthicheck"] = date_modify($temp,"+40 weeks");$data["tenthicheck"] = date_format($data["tenthicheck"],'Y-m-d');
        $data["tenthichecks"] = date_create($data["tenthicheck"]);$data["tenthichecks"] = date_modify($data["tenthichecks"],"+7 days");$data["tenthichecks"] = date_format($data["tenthichecks"],'Y-m-d');



        $this->document->setTitle("产检计划");
        //$data['footer'] = $this->load->controller('common/wechatfooter');
        //$data['header'] = $this->load->controller('common/wechatheader');
        $this->session->data["nav"]="personal_center";


        $log->write( $data['fircheck']. $data['foucheck'].$data['sevcheck'].$data['tencheck'].$data['tenthicheck']);

        $result = array(
            'first'=> array(
                'start'=> $data['fircheck'],
                'end' =>  $data['firchecks'],
            ),
            'second'=> array(
                'start'=> $data['seccheck'],
                'end' =>  $data['secchecks'],
            ),
            'third' => array(
                'start'=> $data['thicheck'],
                'end' =>  $data['thichecks'],
            ),
            'fourth' => array(
                'start'=> $data['foucheck'],
                'end' =>  $data['fouchecks'],
            ),
            'fifth' => array(
                'start'=> $data['fifcheck'],
                'end' =>  $data['fifchecks'],
            ),
            'sixth' => array(
                'start'=> $data['sixcheck'],
                'end' =>  $data['sixchecks'],
            ),
            'seventh' => array(
                'start'=> $data['sevcheck'],
                'end' =>  $data['sevchecks'],
            ),
            'eighth' => array(
                'start'=> $data['eigcheck'],
                'end' =>  $data['eigchecks'],
            ),
            'ninth' => array(
                'start'=> $data['nincheck'],
                'end' =>  $data['ninchecks'],
            ),
            'tenth' => array(
                'start'=> $data['tencheck'],
                'end' =>  $data['tenthichecks'],
                'firend' => $data['tenchecks'],
                'secstart' => $data['tenseccheck'],
                'secend' => $data['tensecchecks'],
                'thistart' => $data['tenthicheck'],
            ),

        );
            /*'fircheck' => $data['fircheck'],
            'firchecks' => $data['firchecks'],
            'seccheck' => $data['seccheck'],
            'secchecks' => $data['secchecks'],
            'thicheck' => $data['thicheck'],
            'thichecks' => $data['thichecks'],
            'foucheck' => $data['foucheck'],
            'fouchecks' => $data['fouchecks'],
            'fifcheck' => $data['fifcheck'],
            'fifchecks' => $data['fifchecks'],
            'sixcheck' => $data['sixcheck'],
            'sixchecks' => $data['sixchecks'],
            'sevcheck' => $data['sevcheck'],
            'sevchecks' => $data['sevchecks'],
            'eigcheck' => $data['eigcheck'],
            'eigchecks' => $data['eigchecks'],
            'nincheck' => $data['nincheck'],
            'ninchecks' => $data['ninchecks'],
            'tencheck' => $data['tencheck'],
            'tenchecks' => $data['tenthichecks'],
            'firstart' => $data['tencheck'],
            'firend' => $data['tenchecks'],
            'secstart' => $data['tenseccheck'],
            'secend' => $data['tensecchecks'],
            'thistart' => $data['tenthicheck'],
            'thiend' => $data['tenthichecks'],

            );*/

	    $response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $result;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));
        //$this->response->setOutput($this->load->view('wechat/checklist', $data));
    }
}
