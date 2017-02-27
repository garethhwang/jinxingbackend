<?php
/**
 * 微信公众平台 PHP SDK
 *
 * @author
 */

  /**
   * 微信公众平台处理类
   */
  class Wechat {
	static function valid($token)
	{
		$echoStr = $_GET["echostr"];
		if(self::signature($token)){
			exit($echoStr);
		}
        return false;
	}

	static function signature($token)
	{
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce     = $_GET["nonce"];
		$tmpArr    = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if($tmpStr == $signature){
			return true;
		}else{
			return false;
		}
	}

	static function requestMethod()
	{
        return $_SERVER['REQUEST_METHOD'];
    }

    static function isGET()
	{
        return self::requestMethod() == 'GET';
    }

    static function isPOST()
	{
        return self::requestMethod() == 'POST';
    }

	/**
     * 响应请求
     */
    static function response($xml, $data, $type) 
	{
		$time = time();
        $xmltpl['text']  = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName>';
        $xmltpl['text'] .= '<CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><MsgId>1234567890123456</MsgId></xml>';
        $xmltpl['item']  = '<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>';
        $xmltpl['news']  = '<xml>
					  <ToUserName><![CDATA[%s]]></ToUserName>
					  <FromUserName><![CDATA[%s]]></FromUserName>
					  <CreateTime>%s</CreateTime>
					  <MsgType><![CDATA[news]]></MsgType>%s
					  <FuncFlag>1</FuncFlag>
					  </xml>';
        if($type == 'text'){
            return sprintf($xmltpl['text'], $xml->FromUserName, $xml->ToUserName, $time, $data);
        }else if($type == 'news'){
            return sprintf($xmltpl['news'], $xml->FromUserName, $xml->ToUserName, $time, $data);
        }
        return self::response($xml, '类型不正确');
	}

	//多客服聊天
	static function multichat($xml)
	{
		$time = time();
        $xmltpl['text']  = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName>';
        $xmltpl['text'] .= '<CreateTime>%s</CreateTime><MsgType><![CDATA[transfer_customer_service]]></MsgType></xml>';
        return sprintf($xmltpl['text'], $xml->FromUserName, $xml->ToUserName, $time);
	}

	static function sendWechatMsg($xml){
		$touser=$xml->FromUserName;
		$xjson="{\"touser\":\"".$touser."\",\"msgtype\":\"text\",\"text\":{\"content\":\"点击左下角键盘图标，在文字框输入症状描述或语音提问，即可开始享受在线上问诊服务~专家会在15分钟内给您提供治疗建议\"}}";
		$jsonMenu = json_encode($xjson);
        $get_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx79dcda258b479eeb&secret=bc86a75c83618ee2f0bdb4cdd1feda89';
        $get_return = file_get_contents($get_url);
        $get_return = (array)json_decode($get_return);
        if( !isset($get_return['access_token']) ){exit( '获取access_token失败！' );}
        $post_url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$get_return['access_token'];
        $ch = curl_init($post_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$xjson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($xjson))
        );
        $respose_data = curl_exec($ch);
        //echo $respose_data;exit;
	}
  }
