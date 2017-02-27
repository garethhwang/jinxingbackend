<?php echo $header; ?>
<div class="orderTitle">
    所有订单
</div>
<?php if(isset($pendingorders)){ ?>
<?php foreach ($pendingorders as $order) { ?>
<div class="orderList">
    <table class="maintable" data-num = "<?php echo $order['order_id'];?>">
        <tr>
            <td style="width: 7rem;vertical-align: top;">地址：</td>
            <td colspan="2" style="line-height: 2.5rem;"><?php echo $order['shipping_city']; echo $order['shipping_address_1']; ?></td>
        </tr>
        <tr>
            <td>时间：</td>
            <td><?php echo $order['shipping_date'] ?></td>
            <td class="listMoney" style="text-align: right"><?php  echo "￥"; echo $order['totals'][2]['text']; ?></td>
        </tr>
        <tr>
            <td>商品：</td>
            <?php if(isset($order['products'])){ ?>
            <td>
                <?php foreach ($order['products'] as $product) { ?>
                <?php echo $product['name']; ?>
                <?php } ?>
            </td>

            <td style="text-align: right">
                <span class="listPaybtn" data-num = "<?php echo $order['order_id'];?>">去支付</span>
            </td>
            <?php } ?>
        </tr>
    </table>
</div>
<?php } ?>
<?php } ?>
<?php if(isset($otherorders)){ ?>
<?php foreach ($otherorders as $order) { ?>
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
            <td>
                <?php foreach ($order['products'] as $product) { ?>
                <?php echo $product['name']; ?>
                <?php } ?>
            </td>

            <td style="text-align: right">
                <span class="listComunicationbtn">联系客服</span> </td>
            <?php } ?>
        </tr>
    </table>
</div>
<?php } ?>
<?php } ?>
<script>

    $(document).ready(function(){
        $(".listComunicationbtn").click(function(){
            location.href = "tel:<?php echo $service_tel?>";
            event.stopPropagation();
        });

        $(".maintable").click(function(){
            location.href = "<?php echo $detail_href?>"+"&order_id="+"<?php echo $order['order_id'];?>";
        });
    });

</script>
<script>
    $(".listPaybtn").click(function(){

        location.href = "<?php echo $pay_href?>"+"&order_id="+$(this).attr("data-num");
        event.stopPropagation();
    });

    $(".maintable").click(function(){
        location.href = "<?php echo $detail_href?>"+"&order_id="+$(this).attr("data-num");
    });
</script>
<?php echo $footer; ?>