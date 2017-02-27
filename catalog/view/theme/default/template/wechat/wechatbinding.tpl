<?php echo $header?>
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/LArea.css">
<div class="orderTitle">绑定手机</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" id="bindingform">
    <table class="bind">
        <tr>
            <td>姓名</td>
            <td style="width: 23rem;">
                <input type="text" name="realname" class="formcontroller" value="<?php echo $realname; ?>"/>
            </td>
        </tr>
        <tr>
            <td>手机</td>
            <td>
                <input type="text" name="telephone" id="telephone" class="formcontroller" value="<?php echo $telephone; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
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
            <td>服务区域</td>
            <td>
                <!--<input type="text" name="address" class="formcontroller"/>-->
                <input id="address" name="district" class="formcontroller" type="text" readonly="" placeholder="选择区域"/>
                <input id="addressvalue" type="hidden"/>
            </td>
        </tr>
        <tr>
            <td>详细地址</td>
            <td>
                <input type="text" name="address_1" class="formcontroller" value="<?php echo $address_1; ?>"/>
            </td>
        </tr>
    </table>
    <!--?php echo $provs_data; ?-->
    <div class="bindBottom">
        <span class="whitebtn active bindBtn" style="margin: 3rem" onclick="" id="register_submitbtn">提交</span>
    </div>
</form>
<script src="catalog/view/javascript/wechat/LArea.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

       if("<?php echo $isnotright?>" == "1") {
           alertConfirm("验证码不正确");
       }


        $("#btnSendCode").click(function(e){
            e.preventDefault();
            if($(this).hasClass("sendMsgBtn")){
                sendMessage();
            }
        });

        $("#register_submitbtn").click(function () {
            if ($("[name='realname']").val().trim().length < 1 || $("[name='realname']").val().trim().length > 32) {
                alertConfirm("姓名格式不正确");
            }else if ($("[name='telephone']").val().trim().length < 1 || $("[name='telephone']").val().trim().length > 11) {
                alertConfirm("手机号码格式不正确");
            }else if ($("[name='smscode']").val().trim().length != 6) {
                alertConfirm("验证码格式不正确");
            }/*else if("<?php echo $isnotright?>" == "1"){
                alertConfirm("验证码不正确");
            }*/else if($("[id='addressvalue']").val().trim().length < 1){
                alertConfirm("服务区域不能为空");
            }else if($("[name='address_1']").val().trim().length < 1 ){
                alertConfirm("详细地址不能为空");
            }else {
                $("#bindingform").submit();
            }
        });
    });
    var provs_data = <?php echo $provs_data;?>;
    var citys_data =<?php echo $citys_data; ?>;
    var dists_data =<?php echo $dists_data; ?>;
    var area2 = new LArea();
    area2.init({
        'trigger': '#address',
        'valueTo': '#addressvalue',
        'keys': {
            id: 'id',
            name: 'name'
        },
        'type': 2,
        'data': [provs_data, citys_data, dists_data]
    });


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
            url: 'http://opencart.meluo.net/index.php?route=wechat/wechatbinding/validcode', //目标地址.
            dataType: "json", //数据格式:JSON
            //data: "dealType=" + dealType +"&uid=" + uid + "&code=" + code,
            data: "telephone=" + telephone,
            success: function (json) {
                if (json.msgid == 1) {
                    alertConfirm(json.html);
                }
                else if (json.msgid == 2) {
                    alertConfirm(json.html);
                }
                else if (json.msgid == 0) {
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
</script>
