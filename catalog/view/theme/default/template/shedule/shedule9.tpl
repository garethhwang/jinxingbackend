<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第9次产检 (第37周 )</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、肝功有异常者复查肝功</p>
    <p>2、查血凝四项、B 超、心电图、胎位检查、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>3、胎心监测、检查胎儿与准妈妈骨盆等综合情况，决定分娩方式</p>
    <p>4、指导准妈妈自数胎动，指导准妈妈有不适情况如腹痛、见红、阴道流液随诊。</p>
    <p>是否需要空腹：是</p>
    <p>说明：这次医生会全面了解准妈妈和胎儿的状况，包括准妈妈的心脏状况等。因为37 周以后，准妈妈随时有可能生产，从这次产检开始，以后每次产检都会做胎心监护，严密监测胎儿的状况。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>