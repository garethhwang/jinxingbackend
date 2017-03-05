<?php


$OPENID=$argv[1];
$Date=$argv[2];

var_dump($OPENID);

class class_weixin
{
	var $appid = 'wx5ce715491b2cf046';
	var $appsecret = '64d8329728c7f15c39f5ed77e77a33c7';


	public function __construct($appid = NULL, $appsecret = NULL)
	{
		if($appid && $appsecret) {
			$this->appid = $appid;
			$this->appsecret = $appsecret;
		}

		$this->lasttime = 1406469747;
		$this->access_token = "FdYlY9vsJUrNVc4SOQDLOP18eBxrhoJ67skn6aR5tvD0bbGdyD_TxAhB-NB8KCg4M3SnsZfmGTU1H4ElBkMBkLl4AXalQq7zfPpi";

		if(time() > ($this->lasttime + 7200)){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
			$res = $this->http_request($url);
			$result = json_decode($res, true);

			//save to Database or Memcache
			$this->access_token = $result["access_token"];
			$this->lasttime = time();


			var_dump($this->lasttime);
			var_dump($this->access_token);
		}
	}


	public function send_template_message($data)
	{
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->access_token;
		$res = $this->http_request($url, $data);
		return json_decode($res, true);
	}

	protected function http_request($url, $data = null)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if(!empty($data)){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}
}

$USER="oKe2EwS-FfXcDKjAQEOhf5RgNqKs";
$template = array('touser' => $OPENID,
                  'template_id' => "-egtpOUgfIoEfwwLFzoCcGleIDV6f29gibVe6tfUbUE",
                  'url' => "http://opencart.meluo.net/index.php?route=wechat/physicalreceipt",
                  'data' => array( 'first' => array('value' => urlencode("回访提醒"),
                                                    'color' => "#0000CD",
                                                   ),
                                   'keyword1' => array('value' => urlencode(" 您已经到了本次回访调查时间，请在回访调查里面如实填写，为了您和宝宝的健康请积极配合，谢谢！"),
                                                    'color' => "#696969",
                                                   ),
                                   'keyword2' => array('value' => urlencode(" $Date"),
                                                    'color' => "#696969",
                                                   ),
                                   'remark' => array('value' => urlencode("请及时安排好生活与工作，有什么需要帮助的可以联系我们。"),
                                                    'color' => "#000000",
                                                   )
                                 )
                  );

$weixin = new class_weixin();
var_dump($weixin->send_template_message(urldecode(json_encode($template))));
?>
