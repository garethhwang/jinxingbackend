<?php
/**
 * Created by PhpStorm.
 * User: sally
 * Date: 2016/12/11
 * Time: 18:35
 */
define('WECHAT_ACCESSTOKEN', 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s');
define('WECHAT_USERTOKEN','https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code');
define('WECHAT_GETUSERINFO','https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN');
define('WECHAT_GETGROUP','https://api.weixin.qq.com/cgi-bin/groups/get?access_token=%s');
define("WECHAT_UNIFIEDORDER","https://api.mch.weixin.qq.com/pay/unifiedorder");
define("WECHAT_AUTHORIZE","https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
define("WECHAT_SERVICE_TEL","010-65724244");
