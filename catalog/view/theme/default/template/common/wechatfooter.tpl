
<div class="footer_mobile"></div>
<footer class="footer_mobile v2_footwrap">
    <table style="width: 100%;background-color: #3b3a3d;text-align: center" cellpadding="0" cellspacing="0">
        <tr>
            <td style="width: 33%;">
                <?php if($nav=="home") { ?>
                <a href="/index.php?route=common/homem"><img src="image/catalog/newstyle/wechatfooter/footerhome_active.png"/><p style="color: #fe8e19">服务首页</p></a>
                <?php } else { ?>
                <a href="/index.php?route=common/homem"><img src="image/catalog/newstyle/wechatfooter/footerhome.png" /><p >服务首页</p></a>
                <?php } ?>
            </td>
            <td>
                <?php if($nav=="blog") { ?>
                <a href="/index.php?route=press/all&page=1&limit=10"><img src="image/catalog/newstyle/wechatfooter/footerdoc_active.png"/><p style="color: #fe8e19">权威文章</p></a>
                <?php } else { ?>
                <a href="/index.php?route=press/all&page=1&limit=10"><img  src="image/catalog/newstyle/wechatfooter/footerdoc.png"/><p >权威文章</p></a>
                <?php } ?>
            </td>
            <td style="width: 33%;">
                <?php if($nav=="order") { ?>
                <a href="/index.php?route=wechat/ordercenter" ><img  src="image/catalog/newstyle/wechatfooter/footeruser_active.png" /><p style="color: #fe8e19">订单中心</p></a>
                <?php } else { ?>
                <a href="/index.php?route=wechat/ordercenter" ><img  src="image/catalog/newstyle/wechatfooter/footeruser.png"/><p >订单中心</p></a>
                <?php } ?>
            </td>
        </tr>
    </table>
</footer>

</body></html>