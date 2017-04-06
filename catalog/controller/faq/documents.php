<?php
class ControllerFaqDocuments extends Controller {
	public function index() {

		// Faq Category Menu
		$this->load->model('faq/document');

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
		$results = $this->model_faq_document->getDocuments();

		foreach ($results as $result){
			$data['documents'][] = array(
				'faq_id' => $result['faq_id'],
				'title' => $result['title'],
				'href' => $this->url->link('faq/document','&document_id=' . $result['faq_id'] )
				//'href' => $this->url->link('wechat/wechatproduct')
			);
		}


		$response = array(
				'code'  => 0,
				'message'  => "",
				'data' =>array(),
		);
		$response["data"] = $data;

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($response));

		return;


		//$this->document->setTitle("帮助手册");
	   // $data['title'] = "帮助手册";
		//$data['header'] = $this->load->controller('common/wechatheader');


		//$this->response->setOutput($this->load->view('faq/documents', $data));
	}
}
