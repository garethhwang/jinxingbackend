<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第10-12次产检(第38-40 周各一次)</div>
    <table>
        <tr>
            <td>
                检查时间：
            </td>
            <td id="firtime"></td>
        </tr>
        <tr>
            <td></td>
            <td id="sectime"></td>
        </tr>
        <tr>
            <td></td>
            <td id="thitime"></td>
        </tr>
    </table>
    <p>检查项目：</p>

    <p>1、胎位检查、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>

    <p>2、胎心监测、可以熟悉了解生产的进行情况，每天勤练拉玛泽呼吸法</p>

    <p>是否需要空腹：否</p>

    <p>说明：从38 周开始，胎位开始固定，胎头已经下来，并卡在盆腔内，此时准妈妈应做好临产准备，注意自己的胎动变化。</p>
</div>
<Script language="javascript">
    var firstart = getUrlParam("firstart");;
    var firend = getUrlParam("firend");;
    var secstart = getUrlParam("secstart");;
    var secend = getUrlParam("secend");;
    var thistart = getUrlParam("thistart");;
    var thiend = getUrlParam("thiend");;
    document.getElementById('firtime').innerHTML = firstart + " 至 " + firend;
    document.getElementById('sectime').innerHTML = secstart + " 至 " + secend;
    document.getElementById('thitime').innerHTML = thistart + " 至 " + thiend;
</Script>