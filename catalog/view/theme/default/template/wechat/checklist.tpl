<?php echo $header; ?>
<style>
    body{background: #eee;}
</style>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=1&start=<?php echo $start=date_format($fircheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第一次产检（第12周）</td>
            <td rowspan="2" class="highInfo">
                <span class="checkHigh">空腹</span>
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($fircheck,"Y-m-d")."至";$fircheck= date_format($fircheck,"Y-m-d"); $fircheck=date_create($fircheck);
        $firchecks= date_modify($fircheck,"+7 days "); echo date_format($firchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=2&start=<?php echo $start=date_format($seccheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第二次产检（第16周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($seccheck,"Y-m-d")."至";$seccheck= date_format($seccheck,"Y-m-d"); $seccheck=date_create($seccheck);
        $secchecks= date_modify($seccheck,"+7 days ");echo date_format($secchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=3&start=<?php echo $start=date_format($thicheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第三次产检（第20周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($thicheck,"Y-m-d")."至";$thicheck= date_format($thicheck,"Y-m-d"); $thicheck=date_create($thicheck);
        $thichecks= date_modify($thicheck,"+7 days ");echo date_format($thichecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=4&start=<?php echo $start=date_format($foucheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第四次产检（第24周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($foucheck,"Y-m-d")."至";$foucheck= date_format($foucheck,"Y-m-d"); $foucheck=date_create($foucheck);
        $fouchecks= date_modify($foucheck,"+7 days ");echo date_format($fouchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=5&start=<?php echo $start=date_format($fifcheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第五次产检（第28周）</td>
            <td rowspan="2" class="highInfo">
                <span class="checkHigh">空腹</span>
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($fifcheck,"Y-m-d")."至";$fifcheck= date_format($fifcheck,"Y-m-d"); $fifcheck=date_create($fifcheck);
        $fifchecks= date_modify($fifcheck,"+7 days ");echo date_format($fifchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=6&start=<?php echo $start=date_format($sixcheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第六次产检（第30周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($sixcheck,"Y-m-d")."至";$sixcheck= date_format($sixcheck,"Y-m-d"); $sixcheck=date_create($sixcheck);
        $sixchecks= date_modify($sixcheck,"+7 days ");echo date_format($sixchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=7&start=<?php echo $start=date_format($sevcheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第七次产检（第32周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($sevcheck,"Y-m-d")."至";$sevcheck= date_format($sevcheck,"Y-m-d"); $sevcheck=date_create($sevcheck);
        $sevchecks= date_modify($sevcheck,"+7 days ");echo date_format($sevchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=8&start=<?php echo $start=date_format($eigcheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第八次产检（第36周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($eigcheck,"Y-m-d")."至";$eigcheck= date_format($eigcheck,"Y-m-d"); $eigcheck=date_create($eigcheck);
        $eigchecks= date_modify($eigcheck,"+7 days ");echo date_format($eigchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=9&start=<?php echo $start=date_format($nincheck,'Y-m-d');?>&end=<?php  $end=date_create($start);
            $end= date_modify($end,'+7 days '); echo date_format($end,'Y-m-d'); ?>">第九次产检（第37周）</td>
            <td rowspan="2" class="highInfo">
                <span class="checkHigh">空腹</span>
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo $start=date_format($nincheck,"Y-m-d")."至";$nincheck= date_format($nincheck,"Y-m-d"); $nincheck=date_create($nincheck);
        $ninchecks= date_modify($nincheck,"+7 days ");echo date_format($ninchecks,"Y-m-d"); ?></td>
        </tr>
    </table>
</div>
<div class="checksheduleList">
    <table>
        <tr>
            <td class="title" data-href="/index.php?route=wechat/shedule&num=10&firstart=<?php echo $firstart=date_format($tencheck,'Y-m-d');?>&firend=<?php  $firend=date_create($firstart);
            $firend= date_modify($firend,'+7 days '); echo date_format($firend,'Y-m-d'); ?>&secstart=<?php $secstart=date_format($tencheck,'Y-m-d');$secstart=date_create($secstart);$secstart= date_modify($secstart,'+1 week ');echo $secstart=date_format($secstart,'Y-m-d');?>&secend=<?php  $secend=date_create($secstart);
            $secend= date_modify($secend,'+7 days '); echo date_format($secend,'Y-m-d'); ?>&thistart=<?php $thistart=date_format($tencheck,'Y-m-d');$thistart=date_create($thistart);$thistart= date_modify($thistart,'+2 weeks ');echo $thistart=date_format($thistart,'Y-m-d');?>&thiend=<?php  $thiend=date_create($thistart);
            $thiend= date_modify($thiend,'+7 days '); echo date_format($thiend,'Y-m-d'); ?>">第十--十二次产检（第38-40周）</td>
            <td rowspan="2" class="highInfo">
            </td>
        </tr>
        <tr>
            <td class="time"><?php echo date_format($tencheck,"Y-m-d")."至";$tencheck= date_format($tencheck,"Y-m-d"); $tencheck=date_create($tencheck);
        $tenchecks= date_modify($tencheck,"+3 weeks ");echo date_format($tenchecks,"Y-m-d");; ?></td>
        </tr>
    </table>
</div>
<script>
    $(document).ready(function () {
        $(".title").click(function () {
            location.href = $(this).attr("data-href");
        });
    });
</script>
