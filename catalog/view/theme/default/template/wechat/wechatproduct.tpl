
<?php echo $header?>
<div class="flexslider" >
    <ul class="slides">
        <!--<li>
            <img src="image/catalog/newstyle/slide.png"/>
        </li>
        <li>
            <img src="image/catalog/newstyle/slide.png"/>
        </li>
        <li>
            <img src="image/catalog/newstyle/slide.png"/>
        </li>-->
        <?php if ($thumb || $images) { ?>
        <?php if ($images) { ?>
        <li>
            <img src="<?php echo $images[0]['popup']; ?>"/>
        </li>
        <?php for($x=1; $x<count($images); $x++) { ?>
        <li>
            <img src="<?php echo $images[$x]['popup']; ?>"/>
        </li>
        <?php } ?>
        <?php } ?>
        <?php } ?>
    </ul>
</div>
<div class="product_divdetail">
    <table width="100%">
        <tr>
            <td>
                <div>
                    <label class="product_titile"><?php echo $heading_title; ?></label>
                </div>
                <div style="margin-top: 1.875rem">
                    <label class="product_price">￥<?php echo $price; ?></label>
                </div>
            </td>
            <td style="text-align: right">
                <?php if ($service_timer != 0){ ?>
                <div style="width: 100%">
                    <div style="display: inline-block;">
                        <img src="image/catalog/newstyle/clock.png"/>
                    </div>
                    <div style="display: inline-block;height: 3.5rem;vertical-align: middle">
                        <label style="font-size: 1.25rem;color: lightgray"><?php echo $service_timer;?>分钟</label>
                    </div>
                </div>
                <?php }?>
            </td>
        </tr>
    </table>
</div>
<div class="product_separater">
</div>
<div class="product_targetuser">
    <label>适用人群：</label><label><?php echo $applicable_user;?></label>
</div>
<div class="product_separater" style="margin-top: 0rem">
</div>
<div class="product_desc">
    <label>服务介绍：</label>
    <p><?php echo $description; ?></p>
</div>
<div class="product_separater" style="margin-top: 3rem">
</div>
<div class="product_desc2">
    <label>服务须知：</label>
    <p>
        <?php echo $service_notes; ?>
    </p>
</div>
<div class="footerblock"></div>
<footer class="productfooter_mobile productv2_footwrap">
    <div class="product_foot">
        <div style="width: 48.75%;"><a href="tel:<?php echo $service_tel?>">电话预约</a></div>
        <div style="width: 0.5%;background-color: white;height: 100%">
        </div>
        <div style="width: 48.75%;">
            <!--<input type="button" id="PayProduct" onclick="callpay()"  value="下单支付" />-->
            <a href="<?php echo $product_link; ?>">下单支付</a>
        </div>
    </div>
</footer>
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
            alert(res.err_code + res.err_desc + res.err_msg);
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
