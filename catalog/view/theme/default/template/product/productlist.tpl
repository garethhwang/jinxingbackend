<?php echo $header; ?>
<div class="productlist">
    <?php foreach ($products as $product) { ?>
    <?php if($product['service_timer']==0){ ?>
    <div class="productItem" data-href = "<?php echo $product['href']; ?>" onclick="productItem(this)">
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"/></a>
        <table>
            <tr>
                <td style="width: 50%;" class="title"><?php echo $product['name']; ?></td>
                <td class="money" style="border-right: none;">
                    ￥<label class="moneyNum"><?php echo $product['price']; ?></label>
                </td>
            </tr>
        </table>
    </div>
    <?php } else { ?>
    <div class="productItem" data-href = "<?php echo $product['href']; ?>" onclick="productItem(this)">
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"/></a>
        <table>
            <tr>
                <td style="width: 33%;" class="title"><?php echo $product['name']; ?></td>
                <td class="money">
                    ￥<label class="moneyNum"><?php echo $product['price']; ?></label>
                </td>
                <td style="width: 33%;">
                    <span class="time">
                        <?php echo $product['service_timer']; ?>分钟
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<?php echo $footer; ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    var nextPage = <?php echo $nextPage; ?>;
    $(document).ready(function () {

        //$('.productItem').click(function () {
        //    location.href = $(this).attr("data-href");
       // });
        initOrder();

        $(window).scroll(function () {
            var scrollTop = $(this).scrollTop();
            var scrollHeight = $(document).height();
            var windowHeight = $(this).height();
            if (scrollTop + windowHeight == scrollHeight && nextPage != -1) {
                getListMore();
            }
        });
    });

    function initOrder() {
        if(<?php echo $isnotregist?> == "1"){
            alertConfirm2('下单前需要绑定手机',"去绑定","https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ce715491b2cf046&redirect_uri=http://opencart.meluo.net/index.php?route=wechat/wechatbinding&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
        };
    }

    function productItem(e){
        location.href = e.getAttribute("data-href");
    }

    function getListMore() {
        $.ajax({
            url: 'index.php?route=product/category/categorymore&page=' + nextPage + "&limit=10&path=" + getUrlParam("path"),
            dataType: 'json',
            success: function (data) {
                if (data.products.length < 10) {
                    nextPage = -1;
                }
                else {
                    nextPage++;
                }
                var totalHTML = "";
                console.log("getListMore products"+data.products.length);
                for (var i = 0; i < data.products.length; i++) {
                    var product = data.products[i];
                    if (Number(product.service_timer) == 0) {
                        totalHTML += listHTML(product.href, product.thumb, product.name, product.price);
                    }
                    else {
                        totalHTML += listHTMLWithTime(product.href, product.thumb, product.name, product.price, product.service_timer);
                    }
                }
                $(".productlist").append(totalHTML);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    function listHTML(linksrc, imgsrc, productname, special) {
        var html = '<div class="productItem"> <a href="' + linksrc + '"><img src="' + imgsrc + '" /></a><table><tr>'
                + '<td style="width: 50%;" class="title">' + productname + '</td>'
                + '<td class="money" style="border-right: none;">￥<label class="moneyNum">' + special + '</label></td></tr></table></div>';
        return html;
    }

    function listHTMLWithTime(linksrc, imgsrc, productname, special, servicetime) {
        var html = '<div class="productItem"><a href="' + linksrc + '"><img src="' + imgsrc + '" /></a><table><tr>'
                + '<td style="width: 33%;" class="title">' + productname + '</td>'
                + '<td class="money">￥<label class="moneyNum">' + special + '</label></td>'
                + '<td style="width: 33%;"><span  class="time">' + servicetime + '分钟 </span></td></tr></table></div>';
        return html;
    }
</script>
