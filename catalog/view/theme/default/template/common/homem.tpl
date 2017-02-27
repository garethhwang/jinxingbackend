<?php echo $header; ?>
<div class="flexslider">
    <ul class="slides">
        <?php foreach ($modules as $module) { ?>
        <li>
            <img src="/image/<?php echo $module['image']; ?>"/>
        </li>
        <?php } ?>
    </ul>
</div>
<div class="homenav nav1">
    <img src="image/catalog/newstyle/homenavimg1.png">

    <div>泌乳调理</div>
</div>
<div class="homenav nav2">
    <a href="#" id="alerter"><img
                src="image/catalog/newstyle/homenavimg2.png"></a>

    <div>产后恢复</div>
</div>
<div class="homenav nav3">
    <img src="image/catalog/newstyle/homenavimg3.png">

    <div>营养膳食</div>
</div>
<script src="catalog/view/javascript/wechat/jquery.flexslider.js"></script>
<script>
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            directionNav: false,
            controlNav: true
        });
    });

    $(document).ready(function(){
        $(".nav1").click(function(){
            location.href = "index.php?route=product/category&path=20&limit=10&page=1";
        });

        $(".nav3").click(function(){
            alertConfirm("此服务暂未开放");
            //location.href = "index.php?route=product/category&path=17&limit=10&page=1";
        });

       $(".nav2").click(function(){
           alertConfirm("此服务暂未开放");
       });
    });

</script>
<?php echo $footer; ?>
