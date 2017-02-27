<?php
class Request {
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();
	public $json;
	public $content;

	public function __construct() {
		$this->content = file_get_contents('php://input');
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->request = $this->clean($_REQUEST);
		$this->cookie = $this->clean($_COOKIE);
		$this->files = $this->clean($_FILES);
		$this->server = $this->clean($_SERVER);
	}

	public function clean($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);

				$data[$this->clean($key)] = $this->clean($value);
			}
		} else {
			$data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
		}

		return $data;
	}

	public function json($key = null, $default = null)
	{
		if ( ! isset($this->json)) {
			$this->json = json_decode($this->content, true);
		}
		if (is_null($key)) return $this->json;

		if (isset($this->json[$key])) {
			return $this->json[$key];
		} else {
			return $default;
		}

		return $default;
	}
}
