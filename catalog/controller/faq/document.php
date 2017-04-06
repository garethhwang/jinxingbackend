<?php
class ControllerFaqDocument extends Controller {
	public function index() {
		$this->document->setTitle("帮助手册");
	
		$log = new Log("wechat.log");
		//$data["error_warning"] = "";
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

		$document_id = $this->request->json('document_id', 0);
	
		//if (isset($this->request->get['document_id'])) {
		//    $document_id = (int)$this->request->get['document_id'];
		//} else {
		//    $document_id = 0;
		//}
	
		// Faq Category Menu
		$this->load->model('faq/document');
		$results = $this->model_faq_document->getDocumentById($document_id);
	
		foreach ($results as $result) {
	
			$data['documents'][] = array(
			'title'			=> html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'),
			'answer'       		=> html_entity_decode($result['answer'], ENT_QUOTES, 'UTF-8'),
			//'title'			=> $result['title'],
			//'answer'       		=> $result['answer'],
			//$document['title'] = html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8');
			//$document['answer'] = html_entity_decode($result['answer'], ENT_QUOTES, 'UTF-8');
		    );
	
	
		    //$data['documents'][] = array(
			//'title'			=> $result['title'],
			//'answer'       		=> $result['answer'],
		    //);

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



		//$data['header'] = $this->load->controller('common/wechatheader');
	
		//$this->response->setOutput($this->load->view('faq/document', $data));
	}
}
