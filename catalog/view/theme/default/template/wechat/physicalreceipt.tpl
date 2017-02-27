<?php echo $header; ?>
<!--switch-->
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/switch/mui-switch.css"/>
<div class="orderTitleInves">
	<?php if( $historyrecord == "0" ){ echo "第一次回访调查"; ?></br>
    <label class="orderTitle2"><?php $date=date_create($last);$date=date_modify($date,"+10 weeks");echo date_format($date,"Y-m-d")."至";$dates=date_create($last);$dates=date_modify($dates,"+11 weeks");echo date_format($dates,"Y-m-d");?></label>
    <?php } else if ( $historyrecord == "1" ){ echo "第二次回访调查"; ?></br>
    <label class="orderTitle2"><?php $date=date_create($last);$date=date_modify($date,"+20 weeks");echo date_format($date,"Y-m-d")."至";$dates=date_create($last);$dates=date_modify($dates,"+21 weeks");echo date_format($dates,"Y-m-d");?></label>
    <?php } else{ echo "第三次回访调查"; ?></br>
    <label class="orderTitle2"><?php $date=date_create($last);$date=date_modify($date,"+34 weeks");echo date_format($date,"Y-m-d")."至";$dates=date_create($last);$dates=date_modify($dates,"+35 weeks");echo date_format($dates,"Y-m-d");}?></label>
</div>
<form method="post" enctype="multipart/form-data" class="form-horizontal" id="register_form">
	<div>
		<div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>心脏病</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="heart" id="heart" data-num="1" >
						</td>
					</tr>
				</table>
				<div id="div1" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="heartdisease[]" value="心率失常">
							</td>
							<td width="22%" class="checktd">
								<label >心率失常</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="heartdisease[]" value="心功能异常">
							</td>
							<td class="checktd">
								<label>心功能异常</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="heartdisease[]" id="xzbcheck" value="其它">
							</td>
							<td class="checktd">
								<label>其它</label>
							</td>
							<td>
								<input type="text" class="formcontroller"  name="xzb" style="width: 90%;" >
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>高血压</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="hyper" id="hyper" data-num="2" >
						</td>
					</tr>
				</table>
				<div id="div2" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="20%">
								<label>血压数值</label>
							</td>
							<td width="60%">
								<input type="text" name="gxy" class="formcontroller" >
							</td>
							<td class="checktd">
								<label style="margin-left: 1rem">mmHg</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>糖尿病</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="GI" id="GI" data-num="3" >
						</td>
					</tr>
				</table>
				<div id="div3" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="radio" name="cure" value="未使用任何药物" checked>
							</td>
							<td width="40%" class="checktd">
								<label>未使用任何药物</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td >
								<input type="radio" name="cure" value="口服血糖药物">
							</td>
							<td class="checktd">
								<label>口服血糖药物后</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td >
								<input type="radio" name="cure" value="使用胰岛素药物">
							</td>
							<td class="checktd">
								<label>使用胰岛素药物后</label>
							</td>
							<td>

							</td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td width="37%">
								<label>饭后2小时血糖值</label>
							</td>
							<td>
								<input type="text"  name="tnb" class="formcontroller" style="width: 90%;" >
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>肾病</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="neph" id="neph" data-num="4" >
						</td>
					</tr>
				</table>
				<div id="div4" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="nephropathy[]" value="肾炎">
							</td>
							<td class="checktd">
								<label>肾炎</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="nephropathy[]" value="肾炎伴肾功能损害">
							</td>
							<td class="checktd">
								<label>肾炎伴肾功能损害</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="nephropathy[]" value="肾炎伴高血压，蛋白尿，肾功能不全">
							</td>
							<td class="checktd">
								<label>肾炎伴高血压，蛋白尿，肾功能不全</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>肝病</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="hepa" id="hepa" data-num="5" >
						</td>
					</tr>
				</table>
				<div id="div5" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="hepatopathy[]" value="慢性肝炎病毒携带者">
							</td>
							<td class="checktd">
								<label>慢性肝炎病毒携带者</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="hepatopathy[]" value="肝硬化">
							</td>
							<td class="checktd">
								<label>肝硬化</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="hepatopathy[]" value="脂肪肝">
							</td>
							<td class="checktd">
								<label>脂肪肝</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="hepatopathy[]" value="肝内胆汁淤积症">
							</td>
							<td class="checktd">
								<label>肝内胆汁淤积症</label>
							</td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td width="35%">
								<label>谷丙转氨酶(ALT)</label>
							</td>
							<td width="15%">
								<input type="text"  name="alt" class="formcontroller" style="width: 4rem">
							</td>
							<td width="35%">
								<label>谷草转氨酶(AST)</label>
							</td>
							<td>
								<input type="text" name="ast" class="formcontroller" style="width: 4rem">
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>甲状腺功能异常</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]" value="thy" id="thy" data-num="6" >
						</td>
					</tr>
				</table>
				<div id="div6" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="thyroid[]" value="甲亢">
							</td>
							<td class="checktd">
								<label>甲亢</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="thyroid[]" value="甲减或低下">
							</td>
							<td class="checktd">
								<label>甲减或低下</label>
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="thyroid[]" value="甲状腺疾病">
							</td>
							<td class="checktd">
								<label>甲状腺疾病</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>血液疾病系统</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]"  value="bloods" id="bloods" data-num="7" >
						</td>
					</tr>
				</table>
				<div id="div7" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="blood[]" value="贫血HGB数值" id="blood1">
							</td>
							<td class="checktd">
								<label>贫血</label>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<label>HGB血红蛋白：</label><input type="text"  name="hgb" class="formcontroller" style="width: 60%" >
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="blood[]" value="血小板异常数值" id="blood2">
							</td>
							<td class="checktd">
								<label>血小板异常</label>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<label>血小板异常数值：</label><input type="text" name="xqb" class="formcontroller" style="width: 50%" >
							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="blood[]" value="再生障碍性贫血/白血病">
							</td>
							<td class="checktd">
								<label>再生障碍性贫血/白血病</label>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div>
			<div class="back_seperator"></div>
			<div class="back_div">
				<table width="100%">
					<tr>
						<td>
							<label>其他</label>
						</td>
						<td style="text-align: right">
							<input class="mui-switch mui-switch-animbg" type="checkbox" name="switch[]"  value="otherelse" id="otherelse" data-num="8" >
						</td>
					</tr>
				</table>
				<div id="div8" class="back_divcontent">
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="精神疾病">
							</td>
							<td width="30%" class="checktd">
								<label>精神疾病</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="血型不合">
							</td>
							<td class="checktd">
								<label>血型不合</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="免疫系统疾病">
							</td>
							<td class="checktd">
								<label>免疫系统疾病</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="结核">
							</td>
							<td class="checktd">
								<label>结核</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="哮喘">
							</td>
							<td class="checktd">
								<label>哮喘</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="肿瘤">
							</td>
							<td class="checktd">
								<label>肿瘤</label>
							</td>
							<td>

							</td>
						</tr>
						<tr>
							<td >
								<input type="checkbox" name="others[]" value="性病">
							</td>
							<td class="checktd">
								<label>性病</label>
							</td>
							<td>

							</td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td width="10%">
								<input type="checkbox" name="others[]" value="其它" id="other1">
							</td>
							<td width="15%" class="checktd">
								<label>其它</label>
							</td>
							<td >
								<input type="text" name="other" class="formcontroller" style="width: 90%" >
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="bindBottom">
		<!--<input type="submit" class="bindBtn" style="width: 45%"  id="register_submitbtn" value="确定"/>-->
		<span class="whitebtn active" style="margin: 3rem" onclick="" id="register_submitbtn">确定</span>
	</div>
</form>
<!--<label><input class="mui-switch mui-switch-animbg" type="checkbox" checked > 默认选中</label>
<label><input class="mui-switch mui-switch-anim" type="checkbox"> 默认未选中</label>
<label><input class="mui-switch mui-switch-anim" type="checkbox" checked> 默认选中</label>-->
</body>
</html>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    $(document).ready(function () {
        InitPage1();

        $(".checktd").click(function(){
            $(this).prev().children().click();
        });

        $("[name='heartdisease[]']").click(function(){
            if($("#xzbcheck").is(':checked')){
                $("[name='xzb']").attr("disabled", false);
            }else {
                $("[name='xzb']").attr("disabled", true);
            }
        });

        $("#blood1").click(function(){
            if($("#blood1").is(':checked')){
                $("[name='hgb']").attr("disabled",false );
            }else {
                $("[name='hgb']").attr("disabled",true );
            }
        });

        $("#blood2").click(function(){
            if($("#blood2").is(':checked')){
                $("[name='xqb']").attr("disabled", false);
            }else {
                $("[name='xqb']").attr("disabled",true );
            }
        });

        $("#other1").click(function(){
            if($("#other1").is(':checked')){
                $("[name='other']").attr("disabled",false );
            }else {
                $("[name='other']").attr("disabled",true );
            }
        });


        $("#register_submitbtn").click(function () {

            var countCheckXzbFalse = 0;
            if($("#heart").is(':checked')){
                $("[name='heartdisease[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckXzbFalse++;
                    }
                })
            }

            var countCheckSbFalse = 0;
            if($("#neph").is(':checked')){
                $("[name='nephropathy[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckSbFalse++;
                    }
                })
            }

            var countCheckGbFalse = 0;
            if($("#hepa").is(':checked')){
                $("[name='hepatopathy[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckGbFalse++;
                    }
                })
            }

            var countCheckJzxFalse = 0;
            if($("#thy").is(':checked')){
                $("[name='thyroid[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckJzxFalse++;
                    }
                })
            }

            var countCheckBloodFalse = 0;
            if($("#bloods").is(':checked')){
                $("[name='blood[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckBloodFalse++;
                    }
                })
            }

            var countCheckOtherFalse = 0;
            if($("#otherelse").is(':checked')){
                $("[name='others[]']").each(function () {
                    if(!$(this).is(":checked")){
                        countCheckOtherFalse++;
                    }
                })
            }


            if($("#heart").is(':checked')&&countCheckXzbFalse == 3){
                alertConfirm("心脏病必须勾选一项");
			}
            else if($("#xzbcheck").is(':checked')&&$("[name='xzb']").val().trim().length == 0){
                alertConfirm("心脏病【其他】不能为空");
            }
			else if($("#hyper").is(':checked')&&( $("[name='gxy']").val().trim().length == 0 && isNaN($("[name='gxy']").val()))){
                alertConfirm("血压数值必填且必须为数字");
			}
            else if($("#GI").is(':checked')&&( $("[name='tnb']").val().trim().length == 0 || isNaN($("[name='tnb']").val()))){
                alertConfirm("饭后两小时血糖值必填且必须为数字");
			}
            else if($("#neph").is(':checked')&&countCheckSbFalse == 3){
                alertConfirm("肾病必须勾选一项");
            }
            else if($("#hepa").is(':checked')&&countCheckGbFalse == 4){
                alertConfirm("肝病必须勾选一项");
            }else if( $("#hepa").is(':checked')&&$("[name='alt']").val().trim().length == 0 || isNaN($("[name='alt']").val())){
                alertConfirm("ALT数值必填且为数字");
			}else if( $("#hepa").is(':checked')&&$("[name='ast']").val().trim().length == 0 || isNaN($("[name='ast']").val())){
                alertConfirm("AST数值必填且为数字");
            }
            else if($("#thy").is(':checked')&&countCheckJzxFalse == 3){
                alertConfirm("甲状腺功能异常必须勾选一项");
            }
            else if($("#bloods").is(':checked')&&countCheckBloodFalse == 3){
                alertConfirm("血液疾病系统必须勾选一项");
            }else if($("#bloods").is(':checked')&&$("#blood1").is(':checked')&&( $("[name='hgb']").val().trim().length == 0 || isNaN($("[name='hgb']").val()))){
                alertConfirm("贫血HGB数值必填且为数字");
			}
			else if($($("#bloods").is(':checked')&&"#blood2").is(':checked')&&( $("[name='xqb']").val().trim().length == 0 || isNaN($("[name='xqb']").val()))){
                alertConfirm("血小板异常数值必填且为数字");
            }
            else if($("#otherelse").is(':checked')&&countCheckOtherFalse == 8){
                alerter("其他必须勾选一项");
            }
            else if($("#other1").is(':checked')&& $("[name='other']").val().trim().length == 0){
                alerter("其他必填");
            }
            else{
                $("#register_form").submit();
            }
        });

        $("[name='switch[]']").click(function(){
            var temp = $(this).attr("data-num");

            if($(this).is(":checked")){
                $("#div"+temp).show();
                $(this).attr("checked","");
                document.getElementById("heart").value = "heart";
                document.getElementById("hyper").value = "hyper";
                document.getElementById("GI").value = "GI";
                document.getElementById("neph").value = "neph";
                document.getElementById("hepa").value = "hepa";
                document.getElementById("thy").value = "thy";
                document.getElementById("bloods").value = "bloods";
                document.getElementById("otherelse").value = "otherelse";
            }else {
                $("#div"+temp).hide();
                $(this).attr("checked","checked");
            }
        });
    });

    function InitPage1() {
		/*$("#div1").hide();
		 $("#div2").hide();
		 $("#div3").hide();
		 $("#div4").hide();
		 $("#div5").hide();
		 $("#div6").hide();
		 $("#div7").hide();
		 $("#div8").hide();*/

        if( <?php echo $isnotregist?> == "1"){
            alertConfirm2('如果您是孕妇用户，请注册后使用本功能，如果您是非孕妇用户，请直接访问健康服务', "去注册", "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx5ce715491b2cf046&redirect_uri=http://opencart.meluo.net/index.php?route=wechat/register&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
        }

        else if( <?php echo $pregnant?> == "0" ){
            alertConfirmBack("您不是孕妇，不需要进行回访调查喔");
        }

        else if( <?php echo $ishighrisk?> == "0"){
            alertConfirmBack("您不是高危孕妇，不需要进行回访调查喔");
        }

        else if( <?php echo $success?> == "1"){
            alertConfirmBack("本次回访调查已成功提交！");
        }

        else if( <?php echo $isnottime?> == "1"){
            alertConfirmBack("您未到下次回访时间，请耐心等待哦");
        }

        else if( <?php echo $isnottime?> == "2"){
            alertConfirmBack("您的回访调查已结束！");
        }



        $(".back_divcontent").hide();

        $("[name='xzb']").attr("disabled", true);
        $("[name='hgb']").attr("disabled",true );
        $("[name='xqb']").attr("disabled",true );
        $("[name='other']").attr("disabled",true );
    }

</script>