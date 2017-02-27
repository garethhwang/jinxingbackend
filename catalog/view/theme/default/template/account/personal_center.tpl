<?php echo $header;?>
<div class="userinfo_top">
  <img src="<?php echo $headimgurl; ?>" />
</div>
<div class="userinfo_edit"><a href="/index.php?route=wechat/edituser"><span>修改资料</span></a></div>
<div class="userinfo_title">宝妈资料</div>
<div class="userinfo_content">
  <table>
    <tr>
      <td style="width: 35%;">真实姓名：</td>
      <td><?php echo $realname; ?></td>
    </tr>
    <tr>
      <td>手机号码：</td>
      <td><?php echo $telephone; ?></td>
    </tr>
    <tr>
      <td>条形码：</td>
      <td><?php echo $barcode; ?></td>
    </tr>
    <tr>
      <td>出生日期：</td>
      <td><?php echo $birthday; ?></td>
    </tr>
    <tr>
      <td>保健科室：</td>
      <td><?php echo $department; ?></td>
    </tr>
    <tr>
      <td>身高：</td>
      <td><?php echo $height; ?></td>
    </tr>
    <tr>
      <td>体重：</td>
      <td><?php echo $weight; ?></td>
    </tr>
    <tr>
      <td>BMI分类：</td>
      <td><?php echo $bmitype; ?></td>
    </tr>
    <tr>
      <td>BMI值：</td>
      <td><?php echo $bmiindex; ?></td>
    </tr>
    <tr>
      <td>末次月经时间：</td>
      <td><?php echo $lastmenstrualdate; ?></td>
    </tr>
    <tr>
      <td>预产期：</td>
      <td><?php echo $edc; ?></td>
    </tr>
    <tr>
      <td>孕次：</td>
      <td><?php echo $gravidity; ?></td>
    </tr>
    <tr>
      <td>产次：</td>
      <td><?php echo $parity; ?></td>
    </tr>
    <!--
    <tr>
      <td>胎次：</td>
      <td><?php echo $fetal; ?></td>
    </tr>
    -->
    <tr>
      <td>分娩次数：</td>
      <td><?php echo $vaginaldelivery; ?></td>
    </tr>
    <tr>
      <td>剖宫产次数：</td>
      <td><?php echo $aesarean; ?></td>
    </tr>
    <tr>
      <td>自然流产次数：</td>
      <td><?php echo $spontaneousabortion; ?></td>
    </tr>
    <tr>
      <td>药物及人工流产次数：</td>
      <td><?php echo $drug_inducedabortion; ?></td>
    </tr>
    <tr>
      <td>是否高危：</td>
      <td><?php echo $highrisk; ?></td>
    </tr>
    <tr>
      <td>高危因素：</td>
      <td ><?php echo $highriskfactor; ?></td>
    </tr>
    <tr>
      <td>是否是本市户籍：</td>
      <td ><?php echo $householdregister; ?></td>
    </tr>
    <tr>
      <td>居住地区：</td>
      <td ><?php echo $district; ?></td>
    </tr>
    <tr>
      <td>详细地址：</td>
      <td ><?php echo $address_1; ?></td>
    </tr>
  </table>
</div>
<script>

</script>