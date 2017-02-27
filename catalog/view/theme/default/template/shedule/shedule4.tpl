<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第4次产检(第24周)</div>
    <p>检查项目：</p><p id="time"></p>
    <p>1、妊娠糖尿病筛检</p>
    <p>2、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>是否需要空腹：否</p>
    <p>说明：大部分妊娠糖尿病的筛检，是在孕期第24 周做。先抽取准妈妈的血液样本，来做一项耐糖试验，建议空腹喝下50 克的糖水，等1 小时后，再进行抽血。当结果出来后，血液指数若在140 以下，即属正常。如糖筛异常者，指导控制饮食，两周后复查空腹血糖和餐后一小时血糖，其中有一项异常继续控制饮食两周。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>