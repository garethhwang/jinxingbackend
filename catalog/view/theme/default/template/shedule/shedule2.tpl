<?php echo $header; ?>
<div class="checkContent">
    <div class="title">第2次产检(第16周)</div>
    <p>检查时间：</p><p id="time"></p>
    <p>检查项目：</p>
    <p>1、复查血常规、尿常规、宫高、腹围、胎心、血压、体重</p>
    <p>2、唐氏症筛检</p>
    <p>是否需要空腹：否</p>
    <p>说明：从第二次产检开始，准妈妈每次必须做基本的例行检查，包括称体重、量血压、问诊及看宝宝的胎心等。此外准妈妈可以在16周以上抽血做唐氏症筛检(但以16 ～ 18 周最佳)，并看第一次产检的抽血报告。唐氏综合征又称“先天愚型”或“21 三体综合征”，特指21 号染色体由正常的2 条变成3 条，患唐氏综合征的孩子大多为严重智能障碍，所以三元专家建议怀孕女性选择这项检查。</p>
</div>
<Script language="javascript">
    var start = getUrlParam("start");
    var end = getUrlParam("end");
    document.getElementById('time').innerHTML = start + " 至 " + end;
</Script>