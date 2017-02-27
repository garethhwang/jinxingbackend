<?php echo $header; ?>
<style>
    .order_detail label{
        margin-left: 2rem;
        font-size: 1.75rem;
        font-weight: bold;
        color: #666666;
    }
</style>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="order_form">
<div class="order_title">
    <table width="100%">
        <tr>
            <td style="color:#333 "><?php echo $products[0]['name'] ?></td>
            <td style="text-align: right;color: #fe8e19"><label style="margin-right: 1.5rem"><?php echo"￥"; echo $products[0]['price'] ?></label></td>
        </tr>
    </table>
</div>
<div class="order_detail">
    联系人<label name="realname"><?php echo $shipping_realname?></label>
</div>
<div class="order_detail">
    联系电话<label  name="telephone"><?php echo $telephone?></label>
</div>
<div class="order_detail">
    地址<label  name="shipping_address_1"><?php echo $shipping_city; echo $shipping_address_1?></label>
</div>
<div class="order_detail">
    日期<label  name="shipping_date"><?php echo $shipping_date?></label>
</div>
<div class="order_detail" style="height: 20rem">
    温馨提示
    <span><p style="margin: 0;padding: 0;font-weight: normal;line-height: 3rem">1、请您仔细核对您的手机号，并保持电话畅通，服务顾问会在服务开始前与此号码沟通相关事宜。</br>
            2、您有任何疑问，也可以随时拨打客服电话：</br>
            <a href="tel:<?php echo $service_tel?>"><label style="color: #fe8e19;margin-left: 1.5rem"><?php echo $service_tel?></label></a>前来咨询</p></span>
</div>
<div class="order_title" style="border-bottom: none">
    <label>原价：</label><label style="color: #fe8e19"><?php echo"￥"; echo $products[0]['price'] ?></label><br>
    <?php if ($coupontype == 'P'){ ?>
    <label>折扣：</label><label style="color: #fe8e19"><?php echo"  "; echo floor($discount); echo"%" ?></label><br>
    <?php }elseif ($coupontype == 'F'){ ?>
    <label>折扣：</label><label style="color: #fe8e19"><?php echo"￥"; echo floor($discount) ?></label><br>
    <?php }else{ ?>
    <label>折扣：</label><label style="color: #fe8e19"><?php echo"  "; echo $discount ?></label><br><?php } ?>
    <label>合计：</label><label style="color: #fe8e19"><?php echo"￥"; echo $lastprice ?></label>
    <?php if (isset($order_status_id)){ ?>
        <?php if ($order_status_id == '1'){ ?>
        <div class="order_detail" style="text-align: center;border: none;padding: 0">
            <span class="whitebtn active" style="margin: auto;width: 10rem;" onclick="callpay()" id="PayProduct">下一步</span>
        </div>
        <?php }?>
    <?php }?>

<!--
    <div style="width: 48.75%;">
        <input type="button" id="PayProduct" onclick="callpay()"  value="下单支付" />
    </div>
-->


</div>
</form>
<!--<script src="catalog/view/javascript/wechat/LArea.js"></script>
<script>
    $(document).ready(function () {

        $("#orderpay_submitbtn").click(function () {
            $("#order_form").submit();
        });
    });
    });
</script>-->
</body>
<script src="catalog/view/javascript/wechat/jquery.flexslider.js"></script>
<script>
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            directionNav:false,
            controlNav: true
        });
    });

    function onBridgeReady() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', <?php echo $wxpay; ?>, function (res) {
            WeixinJSBridge.log(res.err_msg);
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                //alert(res.err_code + res.err_desc + res.err_msg);
                var url = 'index.php?route=wechat/orderStatusUpdate&order_id=<?php echo $order_id; ?>';
                window.location.href=url;
            } else if(res.err_msg == "get_brand_wcpay_request:cancel"){
                alert("返回");
                window.history.back(-1);
            }
        }
    );
    }
    function callpay(){
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        }
        else{
            onBridgeReady();
        }
    }
</script>

</html>