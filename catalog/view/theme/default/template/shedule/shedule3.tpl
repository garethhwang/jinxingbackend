<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第3次产检(第20周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、四维彩超胎儿畸形筛查</p>
    <p>2、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>是否需要空腹：否</p>
    <p>说明：除了常规检查以外，这次产检要做第一次超声波检查。</p>
    <p>准妈妈在孕20 周做第一次超声波检查，主要是看胎儿外观发育上是否有较大问题。医生会仔细量胎儿的头围、腹围，看大腿骨长度及检视脊柱是否有先天性异常。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>