<?php
class ControllerclinicSuccess extends Controller {
    public function index() {
        $data['text_message']  = '<p>恭喜您！科室创建完成</p> ';

        $this->document->setTitle('科室创建成功！');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => '首页',
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' =>  '科室列表',
            'href' => $this->url->link('clinic/clinic', '', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => '成功',
            'href' => $this->url->link('clinic/success')
        );

        $data['heading_title'] = '成功';

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('clinic/success', $data));
    }
}