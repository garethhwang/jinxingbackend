<?php
// Version
define('VERSION', '2.3.0.2');



// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Wechat
if (is_file(DIR_SYSTEM.'/config/wechat.php')) {
	require_once(DIR_SYSTEM.'/config/wechat.php');
}

if (is_file(DIR_SYSTEM.'/wxpay/lib/WxPay.Api.php')){
	require_once(DIR_SYSTEM.'/wxpay/lib/WxPay.Api.php');
}
if (is_file(DIR_SYSTEM.'/wxpay/example/WxPay.JsApiPay.php')){
	require_once (DIR_SYSTEM.'/wxpay/example/WxPay.JsApiPay.php');
}

//if (is_file(DIR_SYSTEM.'/wxpay/example/log.php')){
//	require_once (DIR_SYSTEM.'/wxpay/example/log.php');
//}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('catalog');