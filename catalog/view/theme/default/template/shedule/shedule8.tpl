<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第8次产检(第36周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、胎位检查</p>
    <p>2、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>3、指导准妈妈自数胎动</p>
    <p>是否需要空腹：否</p>
    <p>说明：从36 周开始，产检变为一周一次，医生会持续监视胎儿的状态。此阶段的准妈妈，可开始准备一些生产用的东西，以免生产当天太过匆忙，手忙脚乱。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>