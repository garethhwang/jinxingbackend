<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第6次产检(第30周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、下肢水肿、子痫前症的发生</p>
    <p>2、胎位检查、指导准妈妈自数胎动</p>
    <p>3、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>是否需要空腹：否</p>
    <p>说明： 在孕期28 周以后，产检变为两周一次，医生要陆续为准妈妈检查是否有水肿现象。因为准妈妈的子宫已经扩张到一定水平，有可能会压迫到静脉，所以，静脉回流不好的准妈妈，此阶段较易出现下肢水肿现象。由于大部分的子痫前症，会在孕期28 周以后发生，医生通常依据准妈妈测量血压所得到的数值作为依据，如果测量结果发现准妈妈的血压偏高，又出现蛋白尿、全身水肿等情况时，准妈妈须多加留意，以免有子痫前症的危险。所以，准妈妈在怀孕后期，针对血压、蛋白尿、尿糖所做的检查非常重要。从这周开始，准妈妈要关注自己的胎动。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>