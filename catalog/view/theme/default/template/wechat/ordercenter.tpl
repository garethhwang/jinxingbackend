<?php echo $header; ?>
<div class="orderTitle">
    <table>
        <tr>
            <td style="border-right: 1px solid #eee;width: 35%;">订单中心</td>
            <td>
                <span class="adviseTel">客服电话：<a href="tel:<?php echo $service_tel?>"><?php echo $service_tel?></a></span>
            </td>
        </tr>
    </table>
</div>
<div class="userinfoList" id="div0">
    全部订单<img src="image/catalog/newstyle/userinfoimg3.png" />
</div>
<div class="userinfoList" id="div1">
    待支付<img src="image/catalog/newstyle/userinfoimg3.png" />
</div>
<div class="userinfoList" id="div2">
    已支付未完成<img src="image/catalog/newstyle/userinfoimg3.png" />
</div>
<div class="userinfoList" id="div3">
    已完成订单<img src="image/catalog/newstyle/userinfoimg3.png" />
</div>
<script>
    $(document).ready(function(){
        $("#div0").click(function(){
            location.href = "/index.php?route=wechat/ordercenter/getAllList";
        });
        $("#div1").click(function(){
            location.href = "/index.php?route=wechat/ordercenter/getPendingList";
        });
        $("#div2").click(function(){
            location.href = "/index.php?route=wechat/ordercenter/getPaidList";
        });
        $("#div3").click(function(){
            location.href = "/index.php?route=wechat/ordercenter/getCompletedList";
        });
    });
</script>
<?php echo $footer; ?>