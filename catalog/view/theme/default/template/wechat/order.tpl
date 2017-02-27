<?php echo $header; ?>
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/LArea.css">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="order_form">

<div class="order_title" style="height: 13rem">
    <table width="100%">
        <tr>
            <td style="color:#333 "><?php echo $product['name']; ?></td>
            <td rowspan="2" style="text-align: right;">
                <div style="margin-right: 3rem" hidden>
                    <input type="button" value="-" class="order_plusbtn" />
                        <label  id="productCount" style="margin: 0.2rem;font-size: 2.2rem;font-weight: bold;vertical-align: top;line-height: 5.8rem">1</label>
                        <input type="hidden" name="productCount"/>
                    <input type="button" value="+" class="order_plusbtn" />
                </div>
            </td>
        </tr>
        <tr>
            <td style="color: #fe8e19"><label style="margin-right: 1.5rem">￥<?php echo $product['price']; ?></td>
            <td></td>
        </tr>
    </table>
</div>
<div class="order_detail">
    联系人<input type="text" name="realname" value="<?php echo $customer['realname']; ?>">
</div>
<div class="order_detail">
    联系电话<input type="text" name="telephone" value="<?php echo $customer['telephone']; ?>">
</div>

    <table class="order_detail" width="98%">
        <tr>
            <td width="15%">
                地址
            </td>
            <td width="30%">
                <input id="address"  name="address" type="text" style="width: 100%"  readonly="" placeholder="选择区域" value="<?php echo $address['city']; ?>"/><input id="addressvalue" type="hidden" value="<?php echo $address['city']; ?>"/>
            </td>
            <td>
                <input type="text" name="shipping_address_1" style="width: 100%"  placeholder="详细地址"  value="<?php echo $address['address_1']; ?>">
            </td>
        </tr>
    </table>
<!--<div class="order_detail" style="width: 100%">
    <label style="width: 10%">地址</label>
    <input id="address" name="address" style="width: 30%" type="text" readonly="" placeholder="选择区域"/>
    <input id="addressvalue" style="width: 0%" type="hidden"/>
    <input type="text" name="shipping_address_1"  placeholder="详细地址">
</div>-->
<div class="order_detail">
    日期<input type="date" name="shipping_date" >
</div>
    <table class="order_detail" width="98%">
        <tr>
            <td width="15%">
                折扣券
            </td>
            <td width="60%">
                <input type="text" name="couponcode" id="couponcode">
            </td>
            <td>
                <span class="whitebtn active" style="margin: auto;min-width: 5rem;"  id="useVoucher">使用</span>
            </td>
        </tr>
    </table>
<div class="order_detail" style="height: 22rem">
    温馨提示
    <span><p style="margin: 0;padding: 0;font-weight: normal;line-height: 3rem">1、请您仔细核对您的手机号，并保持电话畅通，服务顾问会在服务开始前与此号码沟通相关事宜。</br>
            2、您有任何疑问，也可以随时拨打客服电话：</br>
            <a href="tel:<?php echo $service_tel?>"><label style="color: #fe8e19;margin-left: 1.5rem"><?php echo $service_tel?></label></a>前来咨询</p></span>
</div>
<div class="order_title" style="border-bottom: none !important;">
    <label>合计：</label><label  style="color: #fe8e19">￥<label id="countPrice"><?php echo $product['price']; ?></label></label>

</div>
    <div class="footerblock"></div>
    <footer class="productfooter_mobile productv2_footwrap" id="orderpay_submitbtn">
        <div class="product_foot" style="text-align: center;line-height: 6.25rem;vertical-align: middle;">
            <label style="color: white;font-size: 1.75rem;font-weight: bold">支付</label>
        </div>
    </footer>
</form>
<script src="catalog/view/javascript/wechat/LArea.js"></script>
<script>
    $(document).ready(function () {

        //initOrder();

        $("#orderpay_submitbtn").click(function () {

            if($("[name='realname']").val().trim().length == 0){
                alertConfirm("姓名不能为空");
            }else if($("[name='telephone']").val().trim().length < 1 || $("[name='telephone']").val().trim().length > 11){
                alertConfirm("电话格式不正确");
            }else if($("#addressvalue").val().trim().length == 0){
                alertConfirm("区域不能为空");
            }else if($("[name='shipping_address_1']").val().trim().length == 0){
                alertConfirm("详细地址不能为空");
            }else if($("[name='shipping_date']").val().trim().length == 0){
                alertConfirm("日期不能为空");
            }else {
                $("#order_form").submit();
            }
        });

        $("#useVoucher").click(function(e){
            e.preventDefault();
            if($(this).hasClass("whitebtn active")){
                verificationcoupon();
            }
        });


        $(".order_plusbtn").click(function () {
            var temp = parseInt($("#productCount").text());
            if($(this).val() == "-"){
                temp = temp - 1;

                if( temp <= 0){
                    temp = 1
                }
            }else {
                temp = temp + 1;
            }
            $("#productCount").text(temp);
            $("[name = 'productCount']").val(temp);
            $("#countPrice").text(temp*<?php echo $product['price']; ?>);
        });
    });


    function verificationcoupon() {

        var couponcode =  document.getElementById("couponcode").value;
        $("#useVoucher").removeClass("whitebtn active");
        $("#useVoucher").addClass("whitebtn active");

        $.ajax({
            type: "POST",　　
            url: 'http://opencart.meluo.net/index.php?route=wechat/order&product_id=<?php echo $product_id?>',
            dataType: "json",
            data: "couponcode=" + couponcode,
            success: function (json) {
                if (json.msgid == 1) {
                    alertConfirm(json.html);
                }
                else {
                    alertConfirm(json.html);
                }
            }
        });


    }

    var provs_data =<?php echo $provs_data; ?>;
    var citys_data =<?php echo $citys_data; ?>;
    var dists_data =<?php echo $dists_data; ?>;
    var area2 = new LArea();
    area2.init({
        'trigger': '#address',
        'valueTo': '#addressvalue',
        'keys': {
            id: 'id',
            name: 'name'
        },
        'type': 2,
        'data': [provs_data, citys_data, dists_data]
    });

</script>