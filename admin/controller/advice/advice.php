<?php
class ControllerAdviceAdvice extends Controller {
    public function index() {
        $this->document->setTitle('投诉');

        if (isset($this->request->get['filter_date_start'])) {
            $filter_date_start = $this->request->get['filter_date_start'];
        } else {
            $filter_date_start = '';
        }

        if (isset($this->request->get['filter_date_end'])) {
            $filter_date_end = $this->request->get['filter_date_end'];
        } else {
            $filter_date_end = '';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => '投诉',
            'href' => $this->url->link('advice/advice', 'token=' . $this->session->data['token'] . $url, true)
        );

        $this->load->model('advice/advice');

        $data['advices'] = array();

        $filter_data = array(
            'filter_date_start'	     => $filter_date_start,
            'filter_date_end'	     => $filter_date_end,
            'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                  => $this->config->get('config_limit_admin')
        );

        $advice_total=$this->model_advice_advice->getTotalAdvices($filter_data);
        $results = $this->model_advice_advice->getAllAdvice($filter_data);

        if(isset($results)) {
            foreach ($results as $result) {

                $data['advices'][] = array(
                    'campaign' => $result['campaign'],
                    'code' => $result['code'],
                    'clicks' => $result['clicks'],
                    'orders' => $result['orders'],
                    'total' => $this->currency->format($result['total'], $this->config->get('config_currency'))
                );
            }
        }
        $data['heading_title'] = '投诉';

        $data['text_list'] = '投诉列表';
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_customer'] = '用户名';
        $data['column_dateadd'] = '投诉日期';
        $data['column_advice'] = '投诉内容';

        $data['entry_date_start'] = '起始日期';
        $data['entry_date_end'] = '截止日期';

        $data['button_filter'] = $this->language->get('button_filter');

        $data['token'] = $this->session->data['token'];

        $url = '';

        if (isset($this->request->get['filter_date_start'])) {
            $url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
        }

        if (isset($this->request->get['filter_date_end'])) {
            $url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
        }

        $pagination = new Pagination();
        $pagination->total = $advice_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('advice/advice', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($advice_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($advice_total - $this->config->get('config_limit_admin'))) ? $advice_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $advice_total, ceil($advice_total / $this->config->get('config_limit_admin')));

        $data['filter_date_start'] = $filter_date_start;
        $data['filter_date_end'] = $filter_date_end;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('advice/advice', $data));
    }
}