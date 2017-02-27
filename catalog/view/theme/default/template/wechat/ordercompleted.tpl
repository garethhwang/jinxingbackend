<?php echo $header; ?>
<div class="orderTitle">
    已完成订单
</div>
<?php if(isset($orders)){ ?>
    <?php foreach ($orders as $order) { ?>
    <div class="orderList">
        <table class="maintable">
            <tr>
                <td style="width: 7rem;vertical-align: top;">地址：</td>
                <td colspan="2" style="line-height: 2.5rem;"><?php echo $order['shipping_city']; echo $order['shipping_address_1']; ?></td>
            </tr>
            <tr>
                <td>时间：</td>
                <td><?php echo $order['shipping_date'] ?></td>
                <td class="listMoney" style="text-align: right">￥<?php  echo $order['totals'][2]['text']; ?></td>
            </tr>
            <tr>
                <td>商品：</td>
                <?php if(isset($order['products'])){ ?>
                <?php foreach ($order['products'] as $product) { ?>
                <td><?php echo $product['name']; ?></td>
                <?php } ?>
                <td style="text-align: right">
                    <span class="listPaybtn">联系客服</span> </td>
                <?php } ?>
            </tr>
        </table>
    </div>
    <?php } ?>
<?php } ?>
<script>
    $(".listPaybtn").click(function(){

        location.href = "tel:<?php echo $service_tel?>";
        event.stopPropagation();
    });

    $(".maintable").click(function(){
        location.href = "<?php echo $detail_href?>"+"&order_id="+"<?php echo $order['order_id'];?>";
    });
</script>
<?php echo $footer; ?>