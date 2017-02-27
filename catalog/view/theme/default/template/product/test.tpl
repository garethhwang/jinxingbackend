<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
        function onBridgeReady() {
            var jsonData = {
                appId: $("body").attr("data-appId"),
                timeStamp: $("body").attr("data-timeStamp"),
                nonceStr: $("body").attr("data-nonceStr"),
                package: "prepay_id=" + $("body").attr("data-prepayid"),
                signType: "MD5",
                paySign: $("body").attr("data-paySign")
            };
            WeixinJSBridge.invoke(
                    'getBrandWCPayRequest', <?php echo $wxpay; ?>, function (res) {
                        WeixinJSBridge.log(res.err_msg);
                        alert(res.err_code + res.err_desc + res.err_msg);
                    }
            );
        }
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        }
    </script>
</head>
<body data-appid="<?php echo $appid; ?>" data-timeStamp="<?php echo $timeStamp; ?>"
      data-nonceStr="<?php echo $nonceStr; ?>" data-prepayid="<?php echo $prepay_id; ?>"
      data-paySign="<?php echo $paySign; ?>">
<br/>
<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>
appid:<?php echo $appid; ?><br/>
timeStamp:<?php echo $timeStamp; ?><br/>
nonceStr:<?php echo $nonceStr; ?><br/>
prepay_id:<?php echo $prepay_id; ?><br/>
paySign:<?php echo $paySign; ?><br/>

<div align="center">
    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;"
            onclick="onBridgeReady()" type="button">立即支付
    </button>
</div>
</body>
</html>