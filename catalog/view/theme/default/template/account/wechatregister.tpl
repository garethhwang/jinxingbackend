<?php echo $header?>
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/LArea.css" />
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="register_form">
    <div class="register_title" id="title1">您的个人资料</div>
    <hr class="register_hr" id="hr1"/>
    <table class="register_outer" style="margin-bottom: -1rem">
        <tr>
            <td style="width: 23%;">
                <label class="orangestar">*</label>
                真实姓名
            </td>
            <td>
                <input type="text" class="formcontroller" value="<?php echo $realname; ?>" name="realname"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="orangestar">*</label>
                手机号码
            </td>
            <td>
                <input type="text" class="formcontroller" name="telephone" id="telephone" value="<?php echo $telephone; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="orangestar">*</label>
                验证码
            </td>
            <td>
                <table class="sendMsg" cellpadding="0" cellspacing="0">
                    <tr style="height: 4rem !important;">
                        <td>
                            <input type="text" name="smscode" id="verificationcode" />
                        </td>
                        <td class="sendMsgBtn" id="btnSendCode">
                            发送验证码
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <label class="orangestar">*</label>
                条形码
            </td>
            <td>
                <input type="text" class="formcontroller" name="barcode" value="<?php echo $barcode; ?>"/>
            </td>
        </tr>

        <tr>
            <td>
                <label class="orangestar">*</label>
                出生日期
            </td>
            <td>
                <input type="date" class="formcontroller" name="birthday" value="<?php echo $birthday; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
                <label class="orangestar">*</label>
                保健科室
            </td>
            <td>
                <input id="department" class="formcontroller" type="text" readonly="" placeholder="选择科室"/>
                <input id="departmentvalue" type="hidden" name="department" />
            </td>
        </tr>

        <tr>
            <td>
                <label class="orangestar">*</label>
                身高
            </td>
            <td>
                <table>
                    <tr>
                        <td style="width: 33%;text-align: left;">
                            <span class="whitebtn" style="width: 8.75rem"><input type="text" class="hiddenInput"
                                                                                 name="height"
                                                                                 value="<?php echo $height; ?>"
                                                                                 id="input-height"/>cm</span>
                        </td>
                        <td style="text-align: center;"><label class="orangestar">*</label>体重</td>
                        <td style="width: 33%;text-align: right;">
                            <span class="whitebtn" style="width: 8.75rem"><input type="text" class="hiddenInput"
                                                                                 name="weight" onkeyup="countindex()"
                                                                                 id="input-weight"/>kg</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <label class="orangestar">*</label>
                BMI指数
            </td>
            <td>
                <table>
                    <tr>
                        <td style="width: 40%;text-align: left;">
                            <label style="font-size: 1.75rem;margin-left: 1rem" id="input-bmiindex"> </label>
                        </td>
                        <td style="text-align: center;"><label class="orangestar">*</label>BMI类型</td>
                        <td style="width: 33%;text-align: right;">
                            <label style="font-size: 1.75rem;margin-right: 1rem" id="input-bmitype"> </label>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="register_outer">
        <tr>
            <td style="width: 35%;">
                <label class="orangestar">*</label>
                末次月经时间
            </td>
            <td>
                <input type="date" class="formcontroller" name="lastmenstrualdate"
                       value="<?php echo $lastmenstrualdate; ?>" onchange="calproductdate()"/>
            </td>
        </tr>

    </table>
    <table class="register_outer" >
        <tr>
            <td style="width: 25%;">
                <label class="orangestar" style="margin-top: ">*</label>
                预产期
            </td>
            <td>
                <!--<input type="date" class="formcontroller" width="10rem" name="edc" value=""/>-->
                <label style="font-size: 1.75rem;margin-right: 1rem" name="edc" ></label>
            </td>
        </tr>
    </table>
    <div class="grayBorder">
        <table class="register_outer">
            <tr>
                <td style="width:45%;">
                    <label class="orangestar">*</label>孕次
                </td>
                <td style="width:20%;">
                    <input type="number" class="formcontroller register_smallInput" name="gravidity"
                           value="<?php echo $gravidity; ?>"/>
                </td>
                <td style="width:45%;">
                    <label class="orangestar">*</label>产次
                </td>
                <td>
                    <input type="number" class="formcontroller register_smallInput" name="parity"
                           value="<?php echo $parity; ?>"/>
                </td>
                <!--
                <td style="width:30%;">
                    <label class="orangestar">*</label>胎次
                </td>
                <td>
                    <input type="number" class="formcontroller register_smallInput" name="fetal"
                           value="<?php echo $fetal; ?>"/>
                </td>
                -->
            </tr>
        </table>

        <table class="register_outer">
            <tr>
                <td style="width:30%;">
                    <label class="orangestar">*</label>分娩次数
                </td>
                <td style="width:20%;">
                    <input type="number" class="formcontroller register_smallInput" name="vaginaldelivery"
                           value="<?php echo $vaginaldelivery; ?>"/>
                </td>
                <td style="width:30%;">
                    <label class="orangestar">*</label>剖宫产次数
                </td>
                <td>
                    <input type="number" class="formcontroller register_smallInput" name="aesarean"
                           value="<?php echo $aesarean; ?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <label class="orangestar">*</label>自然流产次数
                </td>
                <td>
                    <input type="number" class="formcontroller register_smallInput" name="spontaneousabortion"
                           value="<?php echo $spontaneousabortion; ?>"/>
                </td>
                <td>
                    <label class="orangestar">*</label>人工药流次数
                </td>
                <td>
                    <input type="number" class="formcontroller register_smallInput" name="drug_inducedabortion"
                           value="<?php echo $drug_inducedabortion; ?>"/>
                </td>
            </tr>

            <tr>
                <td>
                    <label class="orangestar">*</label>是否高危
                </td>
                <td colspan="3">
                    <span class="whitebtn active" name="isrisk" style="margin-right: 4rem;">是</span>
                    <span class="whitebtn" name="isrisk">否</span>
                    <input type="hidden" name="highrisk" id="highrisk" value="是"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="orangestar">*</label>高危因素
                </td>
                <td colspan="3">
                    <input type="text" class="formcontroller" id="dangerousreason" name="highriskfactor"
                           value="<?php echo $highriskfactor; ?>"/>
                </td>
            </tr>
        </table>
    </div>
    <div class="register_title" id="title2">您的详细地址</div>
    <hr class="register_hr" id="hr2"/>
    <table class="register_outer">
        <tr>
            <td width="45%">
                <label class="orangestar">*</label>是否为本市户口户籍
            </td>
            <td>
                <span class="whitebtn active" name="household">是</span>
                <span class="whitebtn" name="household" style="margin-left: 2rem">否</span>
                <input type="hidden" name="householdregister" id="householdregister" value="是"/>
            </td>
        </tr>
    </table>
    <table class="register_outer">
        <tr>
            <td width="25%">
                <label class="orangestar">*</label>居住地区
            </td>
            <td>
                <input id="address" name="district" class="formcontroller" type="text" readonly="" placeholder="选择区域"/>
                <input id="addressvalue" type="hidden"/>
                <!--<select class="formcontroller" name="district">
                    <?php foreach ($district as $value) { ?>
                    <?php foreach ($value as $dis) { ?>
                    <option value="<?php echo $dis; ?>"><?php echo $dis; ?></option>
                    <?php } ?>
                    <?php } ?>
                </select>-->
            </td>
        </tr>
    </table>
    <table class="register_outer">
        <tr>
            <td width="30%">
                <label class="orangestar">*</label>家庭详细住址
            </td>
            <td>
                <input type="text" class="formcontroller" name="address_1" value="<?php echo $address_1; ?>"/>
            </td>
        </tr>
    </table>
    <div class="register_outer" style="text-align: center;">
        <div style="margin-top:3rem">
            <input type="checkbox" name="agree" value="1"
                   style="height: 3rem;vertical-align: middle"><label style="font-size: 1.5rem">我已阅读并同意<a style="color: #fe8e19" href="http://opencart.meluo.net/registerterms.html">用户协议</a>
            </label>
        </div>
        <div>
            <span class="whitebtn active" style="margin: 3rem" onclick="" id="register_submitbtn">提交</span>
        </div>
    </div>
</form>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="catalog/view/javascript/wechat/LArea.js"></script>
<script type="text/javascript">
    var provs_data =<?php echo $provs_data;?>;
    var citys_data =<?php echo $citys_data;?>;
    var dists_data =<?php echo $dists_data;?>;
    var allcitys_data=<?php echo $allcitys_data;?>;
    var deps_data=<?php echo $deps_data;?>;
    var area2 = new LArea();
    area2.init({
        'trigger': '#address',
        'valueTo': '#addressvalue',
        'callfun':test,
        'keys': {
            id: 'id',
            name: 'name'
        },
        'type': 2,
        'data': [provs_data, citys_data, dists_data]
    });

    var test=function(){
        var address = $("#departmentvalue").val();
        //alert(address)
    }
    var area1 = new LArea();
    area1.init({
        'trigger': '#department',
        'valueTo': '#departmentvalue',
        'callfun':test,
        'keys': {
            id: 'id',
            name: 'name'
        },
        'type': 2,
        'data': [allcitys_data, dists_data, deps_data]
    });



    function getDepartment(districtid) {
            var url = "/index.php?route=wechat/register/getalloffice&districtid=" + districtid;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html = "<option></option>";
                    for (var i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i].office_id + "'>" + data[i].name + "</option>";
                    }
                    $("[name='department']").html(html);
                }
            });
    }

    $(document).ready(function () {

        if("<?php echo $isnotright?>" == "1") {
            alertConfirm("验证码不正确");
        }

        InitPage1();

        countindex();

        calproductdate();

        $(window).resize(function () {
            InitPage1();
        });

        $("#btnSendCode").click(function(e){
            e.preventDefault();
            if($(this).hasClass("sendMsgBtn")){
                sendMessage();
            }
        });

        $("#register_submitbtn").click(function () {

            if ($("[name='realname']").val().trim().length < 1 || $("[name='realname']").val().trim().length > 32) {
                alertConfirm("姓名格式不正确");
            }
            else if ($("[name='telephone']").val().trim().length < 1 || $("[name='telephone']").val().trim().length > 11) {
                alertConfirm("手机号码格式不正确");
            }else if ($("[name='smscode']").val().trim().length != 6) {
                alertConfirm("验证码格式不正确");
            }
            else if ($("[name='barcode']").val().trim().length == 0) {
               alertConfirm("条形码不能为空");
            }
            else if ($("[name='birthday']").val().trim().length == 0) {
                alertConfirm("出生日期不能为空");
            }
            else if ($("[name='height']").val().trim().length == 0) {
                alertConfirm("身高不能为空");
            }
            else if ($("[name='height']").val().trim().length == 0) {
                alertConfirm("体重不能为空");
            }
            else if ($("[name='lastmenstrualdate']").val().trim().length == 0) {
                alertConfirm("末次月经时间不能为空");
            }
            //else if ($("[name='edc']").val().trim().length == 0) {
             //   alertConfirm("预产期不能为空");
            //}
            else if ($("[name='gravidity']").val().trim().length == 0) {
                alertConfirm("孕次不能为空");
            }
            else if (isNaN($("[name='gravidity']").val())) {
                alertConfirm("孕次必须为数字");
            }
            else if ($("[name='parity']").val().trim().length == 0) {
                alertConfirm("产次不能为空");
            }
            else if (isNaN($("[name='parity']").val())) {
                alertConfirm("产次必须为数字");
            }
            //else if ($("[name='fetal']").val().trim().length == 0) {
            //    alertConfirm("胎次不能为空");
            //}
           // else if (isNaN($("[name='fetal']").val())) {
             //   alertConfirm("胎次必须为数字");
            //}
            else if ($("[name='vaginaldelivery']").val().trim().length == 0) {
                alertConfirm("分娩次数不能为空");
            }
            else if (isNaN($("[name='vaginaldelivery']").val())) {
                alertConfirm("分娩次数必须为数字");
            }
            else if ($("[name='aesarean']").val().trim().length == 0) {
                alertConfirm("剖宫产次不能为空");
            }
            else if (isNaN($("[name='aesarean']").val())) {
                alertConfirm("剖宫产次必须为数字");
            }
            else if ($("[name='aesarean']").val().trim().length == 0) {
                alertConfirm("剖宫产次不能为空");
            }
            else if (isNaN($("[name='aesarean']").val())) {
                alertConfirm("剖宫产次必须为数字");
            }
            else if ($("[name='highrisk']").val() == "true" && $("[name='highriskfactor']").val().trim().length == 0) {

                alertConfirm("高危因素不能为空");
            }
            else if ($("[name='address_1']").val().trim().length == 0) {
                alertConfirm("家庭详细地址不能为空");
            }
            else if ($("[name='agree']")[0].checked == false) {
                alertConfirm("请阅读协议并确认");
            }
            else {
                $("#register_form").submit();
            }
        });

        $("[name='isrisk']").click(function () {
            $("[name='isrisk']").removeClass("active");
            $(this).addClass("active");
            if ($(this).text() == "是") {
                $("#dangerousreason").attr("disabled", false);

                document.getElementById("highrisk").value = "是";
            } else {
                $("#dangerousreason").attr("disabled", true);
                $("#dangerousreason").val("");
                document.getElementById("highrisk").value = "否";
            }
        });

        $("[name='household']").click(function () {
            $("[name='household']").removeClass("active");
            $(this).addClass("active");
            if ($(this).text() == "是") {
                document.getElementById("householdregister").value = "是";

            } else {
                document.getElementById("householdregister").value = "否";
            }
        });
    });

    function InitPage1() {
        var top = $("#hr1").offset().top - $("#title1").height() / 2;
        $("#title1").css("top", top + "px");
        var top2 = $("#hr2").offset().top - $("#title2").height() / 2;
        $("#title2").css("top", top2 + "px");
    }


    var InterValObj; //timer变量，控制时间
    var count = 90; //间隔函数，1秒执行
    var curCount;//当前剩余秒数

    function validatetelephone(telephone) {
        if (telephone.length == 0) {
            alertConfirm('请输入手机号码！');
            document.form1.telephone.focus();
            return false;
        }
        if (telephone.length != 11) {
            alertConfirm('请输入有效的手机号码！');
            document.form1.telephone.focus();
            return false;
        }

    }

    function sendMessage() {
        curCount = count;

        //向后台发送处理数据
        var telephone = document.getElementById("telephone").value;
        validatetelephone(telephone);//调用上边的方法验证手机号码的正确性

        $("#btnSendCode").removeClass("sendMsgBtn");
        $("#btnSendCode").addClass("sendMsgBtnDis");
        //设置button效果，开始计时
        $("#btnSendCode").html("请在" + curCount + "秒内输入");
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次

        $.ajax({
            type: "POST", //用POST方式传输     　　
            url: 'http://opencart.meluo.net/index.php?route=wechat/wechatregister/validacode', //目标地址.
            dataType: "json", //数据格式:JSON
            //data: "dealType=" + dealType +"&uid=" + uid + "&code=" + code,
            data: "telephone=" + telephone,
            success: function (json) {
                if (json.msgid == 1) {
                    alertConfirm(json.html);
                }
                else if (json.msgid == 2) {
                    alertConfirm(json.html);
                }else if (json.msgid == 0) {
                    alertConfirm(json.html);
                }else {
                    alertConfirm(json.html);
                }
            }
        });
    }

    //timer处理函数
    function SetRemainTime() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#btnSendCode").addClass("sendMsgBtn");
            $("#btnSendCode").removeClass("sendMsgBtnDis");
            $("#btnSendCode").html("重新发送");
        }
        else {
            curCount--;
            $("#btnSendCode").html("请在" + curCount + "秒内输入");
        }
    }


    function countindex() {

        if(document.getElementById("input-weight").value.trim().length == 0){
            return;
        }

        var bmiindex = document.getElementById("input-weight").value / (Math.pow(document.getElementById("input-height").value, 2) / 10000);
        var bmiindex = bmiindex.toFixed(2);

        document.getElementById("input-bmiindex").innerHTML = bmiindex;

        if (bmiindex < "18.5") {

            // echo "过轻"; $bmitype = "0";
            document.getElementById("input-bmitype").innerHTML = "过轻";
        }
        else if (bmiindex < "25") {
            //echo "正常"; $bmitype = "1";
            document.getElementById("input-bmitype").innerHTML = "正常";
        }
        else if (bmiindex < "28") {
            //echo "过重"; $bmitype = "2";
            document.getElementById("input-bmitype").innerHTML = "过重";
        }
        else if (bmiindex < "32") {
            //echo "肥胖"; $bmitype = "3";
            document.getElementById("input-bmitype").innerHTML = "肥胖";
        }
        else {
            //echo "非常肥胖"; $bmitype = "4";
            document.getElementById("input-bmitype").innerHTML = "非常肥胖";
        }

    }

    function calproductdate() {

        var lastyjdate = document.getElementsByName("lastmenstrualdate").item(0).value
        if(lastyjdate){
            document.getElementsByName("edc").item(0).innerHTML = addDate(lastyjdate,280);
        }

    };

    function addDate(date,days){
        var d=new Date(date);
        d.setDate(d.getDate()+days);
        var month=d.getMonth()+1;
        var day = d.getDate();
        if(month<10){
            month = "0"+month;
        }
        if(day<10){
            day = "0"+day;
        }
        var val = d.getFullYear()+"-"+month+"-"+day;
        return val;
    };

</script>
</html>
