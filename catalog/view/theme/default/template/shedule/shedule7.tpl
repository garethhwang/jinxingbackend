<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第7次产检(第32周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、评估胎儿体重、胎位检查</p>
    <p>2、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>3、指导准妈妈自数胎动</p>
    <p>是否需要空腹：否</p>
    <p>说明：除了做常规检查以外，这次产检还会预估胎儿至足月生产时的重量。一旦发现胎儿体重不足，准妈妈就应多补充一些营养素;若发现胎儿过重，准妈妈在饮食上就要稍加控制，以免日后需要剖宫生产，或在生产过程中出现胎儿难产情形。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>