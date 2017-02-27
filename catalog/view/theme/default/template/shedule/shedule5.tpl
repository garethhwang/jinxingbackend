<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第5次产检(第28周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、乙型肝炎抗原、骨盆测量、胎位检查、B 超</p>
    <p>2、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>是否需要空腹：是</p>
    <p>说明：此阶段最重要是为准妈妈抽血检查乙型肝炎，目的是要检视准妈妈本身是否携带乙肝病毒或已感染到乙型肝炎。如果准妈妈的乙型肝炎两项检验皆呈阳性反应，一定要让医生知道，才能在准妈妈生下胎儿24 小时内，为新生儿注射疫苗，以免让新生儿遭受感染。此外，要再次做B 超检查，以排除畸形可能。这次产检开始检查宝宝的胎位，检查妈妈的骨盆，为分娩做准备。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>