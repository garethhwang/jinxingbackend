<?php
/**
 * 微信公众平台 PHP SDK 示例文件
 *
 * @author NetPuter <netputer@gmail.com>
 */

require('/home/work/www/BeJinXingJK/www/wx/src/Wechat.php');
$token = "weixin";
$appid="wx5ce715491b2cf046";
$redirect_uri="http://wechat.jinxingjk.com/";
	if(Wechat::isGET())
	{
		Wechat::valid($token);
	}

	if(Wechat::isPOST())
	{
		$post    = $GLOBALS["HTTP_RAW_POST_DATA"];
		$xml     = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
		$content = trim($xml->Content);    // 获取消息内容
		$type    = strtolower($xml->MsgType);
		$openid  = $xml->FromUserName;

		switch($type)
		{
			case "event":
				switch($xml->Event)
				{
				    case "subscribe":
				        $data = "终于等到你啦！\n".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'#/register&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect">如果你是孕期的准妈妈请点击这里</a>'."，进行注册，金杏会定期发送健康提醒给你！\n".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'#/productedregister&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect">如果你是产后妈妈请点击这里</a>'."，金杏会定期发送宝宝疫苗提醒给你！\n如果你是宝宝家人或关注乳腺健康服务也可直接访问".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'#/&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect" >健康服务</a>'."3月13日-3月19日首单免费体验专业催乳/开奶服务，快快预约，限量30名，下单请选择“健康服务”-“泌乳服务”，服务后全额返还首单体验金额，金杏客服会联系你哟！";
					    //$data= "终于等到你！\n".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'#/register&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect">孕妇请点击这里</a>'."，进行注册，金杏会发送定期提醒给你\n非孕妇可直接访问".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'#/common/homem&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect" >健康服务</a>'."\n3月4日孕早期线上课堂报名，".'<a href="http://mp.weixin.qq.com/s/kqNdWl5W41mbeeleH8MScA" >请点这里</a>';
					    exit(Wechat::response($xml, $data,"text"));
				     case "CLICK":
					    break;
				     case "unsubscribe":
					    $data= '感谢您长久以来您对<金杏健康>的支持';
				  	    exit(Wechat::response($xml, $data,"text"));
				     default:
						break;
				}
				break;
			case "text":
				if($content == 'A')
				{
					$data = 'good';
					exit(Wechat::response($xml, $data,"text"));
				}
				//进入在线聊天
				if($content == '在线咨询'){
					exit(Wechat::multichat($xml));
				}
				break;
			default:
				break;

		}
		//exit(Wechat::response($xml, '类型无效!'));
	}
