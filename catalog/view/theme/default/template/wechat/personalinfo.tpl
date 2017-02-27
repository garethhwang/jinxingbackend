<?php echo $header; ?>
<style>
    body{background: #eee;}
</style>
<div class="userinfoList">
    基本信息<a href="/index.php?route=account/personal_center" ><img src="image/catalog/newstyle/userinfoimg3.png" /></a>
</div>
<div class="userinfoList">
    产检计划<a href="/index.php?route=wechat/checklist" ><img src="image/catalog/newstyle/userinfoimg3.png" /></a>
</div>
<div class="userinfoList">
    疫苗接种表<a href="/index.php?route=wechat/vaccinemenu" ><img src="image/catalog/newstyle/userinfoimg3.png" /></a>
</div>
<!--
<div class="userinfoList">
    投诉建议<a href="/index.php?route=wechat/advise"><img src="image/catalog/newstyle/userinfoimg3.png" /></a>
</div>-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(document).ready(function () {
        InitPage1();
    });

    function InitPage1() {

        if(<?php echo $isnotregist?> == "1"){
            alertConfirm2('如果您是孕妇用户，请注册后使用本功能，如果您是非孕妇用户，请直接访问健康服务',"去注册","https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ce715491b2cf046&redirect_uri=http://opencart.meluo.net/index.php?route=wechat/register&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
        };

        if(<?php echo $pregnant?> == "0"){
            alertConfirm2('此功能仅面向孕/产妇开放，如果您是孕/产妇用户，请完善资料后进入；如果您是非孕/产妇用户，请您移步其他功能区',"完善资料","https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ce715491b2cf046&redirect_uri=http://opencart.meluo.net/index.php?route=wechat/edituser&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
        }
    }
</script>
</body>
</html>