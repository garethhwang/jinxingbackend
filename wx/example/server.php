<?php
/**
 * 微信公众平台 PHP SDK 示例文件
 *
 * @author NetPuter <netputer@gmail.com>
 */

require('../src/Wechat.php');
$token = "weixin";
$appid="wx5ce715491b2cf046";
$redirect_uri="http://opencart.meluo.net/";
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
						$data= "终于等到你！\n".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'index.php?route=wechat/register&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect">孕妇请点击这里</a>'."，进行注册，金杏会发送定期提醒给你\n非孕妇可直接访问".'<a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'index.php?route=common/homem&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect" >健康服务</a>'."\n3月4日孕早期线上课堂报名，".'<a href="http://mp.weixin.qq.com/s/kqNdWl5W41mbeeleH8MScA" >请点这里</a>';
						exit(Wechat::response($xml, $data,"text"));
//                        $data = "<ArticleCount>2</ArticleCount>
//							 <Articles>
//							 <item>
//							 <Title><![CDATA[欢迎加入金杏伐木累]]></Title>
//							 <Description><![CDATA[Hello！我是杏宝，为了杏宝能给准妈妈们提供更好的服务，请快快注册成为我们的一份子吧。]]></Description>
//							 <PicUrl><![CDATA[http://opencart.meluo.net/image/catalog/p3.png]]></PicUrl>
//							 <Url><![CDATA[http://opencart.meluo.net/index.php?route=wechat/wechatwelcome]]></Url>
//							 </item>
//							 <item>
//							 <Title><![CDATA[让我们一起来吐槽......那些年最难穿的Bra 文胸 乳罩......]]></Title>
//							 <Description><![CDATA[让我们一起来吐槽......那些年最难穿的Bra 文胸 乳罩......]]></Description>
//							 <PicUrl><![CDATA[http://mmbiz.qpic.cn/mmbiz_jpg/PvwkMxwqhtvxa5MDjApOGOZvibKr9Q4Vciag66V2FKsxvT3THy6fib7nUY2ExfkMe7bCJn9yPiaDYETQOcqvwIOdibw/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1]]></PicUrl>
//							 <Url><![CDATA[http://mp.weixin.qq.com/s/Vw6Zuk6UQau4nUmH_NvkYg]]></Url>
//							 </item>
//
//							 </Articles>";
//                        exit(Wechat::response($xml, $data,"news"));
					case "CLICK":
						//payfor
						$key = $xml->EventKey;
						if ($key == 'V_HELP')
						{
							$pay = "<a href='https://meluo.sinaapp.com/wechat/example/js_api_call.php'>JSapi支付(在微信客户端中点击)</a>";

							exit(Wechat::response($xml,$pay,"text"));
						}
						if($key=="OnlineConsultation"){
							Wechat::sendWechatMsg($xml);
							exit(Wechat::multichat($xml));
						}
						else if($key=="zzjz"){//办事指南
						    $data = "<ArticleCount>4</ArticleCount>
							 <Articles>
							 <item>
							 <Title><![CDATA[周易与中医学的融合之道]]></Title> 
							 <Description><![CDATA[周易与中医学的融合之道]]></Description>
							 <PicUrl><![CDATA[http://mp.xinyijk.com/wechat/Images/newsimg1.png]]></PicUrl>
							 <Url><![CDATA[http://www.xinyijk.com/meducation.html]]></Url>
							 </item>
							 <item>
							 <Title><![CDATA[传统文化与中医的关联]]></Title> 
							 <Description><![CDATA[传统文化与中医的关联]]></Description>
							 <PicUrl><![CDATA[http://mp.xinyijk.com/wechat/Images/newsimg2.png]]></PicUrl>
							 <Url><![CDATA[http://www.xinyijk.com/meducation.html]]></Url>
							 </item>
							 <item>
							 <Title><![CDATA[中医临床辩证的聚焦点]]></Title> 
							 <Description><![CDATA[中医临床辩证的聚焦点]]></Description>
							 <PicUrl><![CDATA[http://mp.xinyijk.com/wechat/Images/newsimg3.png]]></PicUrl>
							 <Url><![CDATA[http://www.xinyijk.com/meducation.html]]></Url>
							 </item>
							 <item>
							 <Title><![CDATA[中医药应用中的圆运动]]></Title> 
							 <Description><![CDATA[中医药应用中的圆运动]]></Description>
							 <PicUrl><![CDATA[http://mp.xinyijk.com/wechat/Images/newsimg4.png]]></PicUrl>
							 <Url><![CDATA[http://www.xinyijk.com/meducation.html]]></Url>
							 </item>
							 </Articles>"; 
							exit(Wechat::response($xml, $data,"news"));
						}
						else if($key=="gyzl"){
							$data = "<ArticleCount>1</ArticleCount>
							 <Articles>
							 <item>
							 <Title><![CDATA[苗医苗药公益之旅]]></Title> 
							 <Description><![CDATA[苗医苗药公益之旅属于中华中医药学会推广项目，采用先动员后义诊的方式，提前动员，联系各大高校义工社团、社会公益救助协会等，利用广播、影片、海报以及社会媒体等提高基层困难家庭的关注度]]></Description>
							 <PicUrl><![CDATA[http://mp.xinyijk.com/wechat/Images/newsimg5.png]]></PicUrl>
							 <Url><![CDATA[http://www.xinyijk.com/mpublicactivity.html]]></Url>
							 </item>
							 
							 </Articles>"; 
							exit(Wechat::response($xml, $data,"news"));
						}
						
					    break;
					case "unsubscribe":
						$data= '感谢您长久以来您对<新医诊室>的支持';
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
