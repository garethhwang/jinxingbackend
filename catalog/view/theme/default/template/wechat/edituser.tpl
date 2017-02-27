<?php echo $header;?>
<link rel="stylesheet" href="catalog/view/theme/default/stylesheet/LArea.css">
<div class="userinfo_top">
    <img src="<?php echo $headimgurl; ?>"/>
</div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="register_form">
<div class="userinfo_title" style="margin-left: 2.25rem;">宝妈资料</div>
<div class="userinfo_content" style="margin-left: 2.25rem;margin-right: 2rem;">
    <table>
        <tr>
            <td style="width: 35%;">真实姓名：</td>
            <td>
                <input type="text" class="formcontroller" value="<?php echo $realname; ?>" name="realname"/>
            </td>
        </tr>
        <tr>
            <td>手机号码：</td>
            <td>
                <input type="text" class="formcontroller" name="telephone" value="<?php echo $telephone; ?>"/>
            </td>
        </tr>
        <tr>
            <td>条形码：</td>
            <td>
                <input type="text" class="formcontroller"  name="barcode" value="<?php echo $barcode; ?>"/>
            </td>
        </tr>
        <tr>
            <td>出生日期：</td>
            <td>
                <input type="date" class="formcontroller" name="birthday" value="<?php echo $birthday; ?>"/>
            </td>
        </tr>
        <tr>
            <td>保健科室：</td>
            <td>
                <input id="department" class="formcontroller" type="text" readonly="" placeholder="选择科室" name="depname" value="<?php echo $depname; ?>" />
                <input id="departmentvalue" type="hidden" name="department" value="<?php echo $department; ?>" />
            </td>
        </tr>
        <tr>
            <td>身高：</td>
            <td>
                <span class="whitebtn" style="width: 8.75rem"><input type="text" class="hiddenInput" name="height"
                                                                     value="<?php echo $height; ?>" id="input-height"/>cm</span>
            </td>
        </tr>
        <tr>
            <td>体重：</td>
            <td>
                <span class="whitebtn" style="width: 8.75rem"><input type="text" class="hiddenInput" name="weight" value="<?php echo $weight; ?>"onkeyup="countindex()" id="input-weight"/>kg</span>
            </td>
        </tr>
        <tr>
            <td>BMI指数：</td>
            <td>
                <span style="font-size: 1.75rem;margin-left: 1rem" id="input-bmiindex"></span>
            </td>
        </tr>
        <tr>
            <td>BMI类型：</td>
            <td>
                <span  style="font-size: 1.75rem;margin-right: 1rem" id="input-bmitype"></span>
            </td>
        </tr>
        <tr>
            <td>末次月经时间：</td>
            <td>
                <input type="date" class="formcontroller" name="lastmenstrualdate"
                       value="<?php echo $lastmenstrualdate; ?>" onchange="calproductdate()"/>
            </td>
        </tr>
        <tr>
            <td>预产期：</td>
            <td>
                <label style="font-size: 1.75rem;margin-right: 1rem" name="edc" ></label>
            </td>
        </tr>
        <tr>
            <td>孕次：</td>
            <td>
                <input type="number" class="formcontroller" name="gravidity"
                       value="<?php echo $gravidity; ?>"/>
            </td>
        </tr>
        <tr>
            <td>产次：</td>
            <td>
                <input type="number" class="formcontroller" name="parity"
                       value="<?php echo $parity; ?>"/>
            </td>
        </tr>
        <!--
        <tr>
            <td>胎次：</td>
            <td>
                <input type="number" class="formcontroller" name="fetal"
                       value="<?php echo $fetal; ?>"/>
            </td>
        </tr>
        -->
        <tr>
            <td>分娩次数：</td>
            <td>
                <input type="number" class="formcontroller" name="vaginaldelivery"
                value="<?php echo $vaginaldelivery; ?>"/>
            </td>
        </tr>
        <tr>
            <td>剖宫产次数：</td>
            <td>
                <input type="number" class="formcontroller"  name="aesarean"
                       value="<?php echo $aesarean; ?>"/>
            </td>
        </tr>
        <tr>
            <td>自然流产次数：</td>
            <td>
                <input type="number" class="formcontroller" name="spontaneousabortion"
                       value="<?php echo $spontaneousabortion; ?>"/>
            </td>
        </tr>
        <tr>
            <td>人工流产次数：</td>
            <td>
                <input type="number" class="formcontroller" name="drug_inducedabortion"
                       value="<?php echo $drug_inducedabortion; ?>"/>
            </td>
        </tr>
        <tr>
            <td>是否高危：</td>
            <td>
                <span class="whitebtn active" name="isrisk" id = "risk" style="margin-right: 4rem;">是</span>
                <span class="whitebtn" name="isrisk" id = "norisk">否</span>
                <input type="hidden" name="highrisk" id="highrisk" value="<?php echo $highrisk; ?>"/>
            </td>
        </tr>
        <tr>
            <td>高危因素：</td>
            <td >
                <input type="text" class="formcontroller" id="dangerousreason" name="highriskfactor"
                       value="<?php echo $highriskfactor; ?>"/>
            </td>
        </tr>
        <tr>
            <td >是否为本市户口户籍：</td>
            <td>
                <span class="whitebtn active" id = "native" name="household" style="margin-right: 4rem;">是</span>
                <span class="whitebtn" name="household" id="nonative" style="margin-left: 2rem">否</span>
                <input type="hidden" name="householdregister" id="householdregister" value="<?php echo $householdregister; ?>"/>
            </td>
        </tr>
        <tr>
            <td>居住地区：</td>
            <td>
                <input id="address" name="district" class="formcontroller" type="text" readonly="" placeholder="选择区域" value="<?php echo $district; ?>"/>
                <input id="addressvalue"   type="hidden"  />
            </td>
        </tr>
        <tr>
            <td>家庭详细住址：</td>
            <td>
                <input type="text" class="formcontroller" name="address_1" value="<?php echo $address_1; ?>"/>
            </td>
        </tr>
    </table>
</div>
<div class="register_outer" style="text-align: center;">
    <span class="whitebtn active" style="margin: 3rem" onclick="" id="register_submitbtn">提交</span>
</div>
</form>
<script src="catalog/view/javascript/wechat/LArea.js"></script>
<script>
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

        if("<?php echo $highrisk; ?>" == "是"){
            $("#dangerousreason").attr("disabled", false);
            document.getElementById("highrisk").value = "是";
            $("#risk").addClass("active");
            $("#norisk").removeClass("active");
        }else {
            $("#dangerousreason").attr("disabled", true);
            $("#dangerousreason").val("");
            document.getElementById("highrisk").value = "否";
            $("#risk").removeClass("active");
            $("#norisk").addClass("active");
        }

        if("<?php echo $householdregister; ?>" == "是"){
            $("#native").addClass("active");
            $("#nonative").removeClass("active");
        }else {
            $("#native").removeClass("active");
            $("#nonative").addClass("active");
        }

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

    $("#register_submitbtn").click(function () {

        if($("[name='realname']").val().trim().length<1 || $("[name='realname']").val().trim().length>32){
            alerter("姓名格式不正确");
        }
        else if($("[name='telephone']").val().trim().length<1 || $("[name='telephone']").val().trim().length>11){
            alerter("手机号码格式不正确");
        }
        else if($("[name='barcode']").val().trim().length==0){
            alerter("条形码不能为空");
        }
        else if($("[name='birthday']").val().trim().length == 0){
            alerter("出生日期不能为空");
        }
        else if($("[name='height']").val().trim().length == 0){
            alerter("身高不能为空");
        }
        else if($("[name='height']").val().trim().length == 0){
            alerter("体重不能为空");
        }
        else if($("[name='lastmenstrualdate']").val().trim().length == 0){
            alerter("末次月经时间不能为空");
        }
        else if($("[name='gravidity']").val().trim().length == 0){
            alerter("孕次不能为空");
        }
        else if(isNaN($("[name='gravidity']").val())){
            alerter("孕次必须为数字");
        }
        else if($("[name='parity']").val().trim().length == 0){
            alerter("产次不能为空");
        }
        else if(isNaN($("[name='parity']").val())){
            alerter("产次必须为数字");
        }
        else if($("[name='vaginaldelivery']").val().trim().length == 0){
            alerter("分娩次数不能为空");
        }
        else if(isNaN($("[name='vaginaldelivery']").val())){
            alerter("分娩次数必须为数字");
        }
        else if($("[name='aesarean']").val().trim().length == 0){
            alerter("剖宫产次不能为空");
        }
        else if(isNaN($("[name='aesarean']").val())){
            alerter("剖宫产次必须为数字");
        }
        else if($("[name='aesarean']").val().trim().length == 0){
            alerter("剖宫产次不能为空");
        }
        else if(isNaN($("[name='aesarean']").val())){
            alerter("剖宫产次必须为数字");
        }
        else if($("[name='highrisk']").val() == "true" && $("[name='highriskfactor']").val().trim().length == 0){

            alerter("高危因素不能为空");
        }
        else{
            $("#register_form").submit();
        }
    });

    function alerter(content){
        popTipShow.alert('提示', content, ['知道了'],
            function (e) {
                //callback 处理按钮事件
                var button = $(e.target).attr('class');
                if (button == 'ok') {
                    //按下确定按钮执行的操作
                    //todo ....
                    this.hide();
                }
            }
        );
    }

    var bmi = false;

    function countindex() {

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

        s = true;
    }

    if(!bmi){

        if(document.getElementById("input-weight").value == "" && document.getElementById("input-height").value == ""){
            document.getElementById("input-bmiindex").innerHTML = " ";
            document.getElementById("input-bmitype").innerHTML =  " ";

        }else {

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

    }

    var edc = false;

    function calproductdate() {

        var lastyjdate = document.getElementsByName("lastmenstrualdate").item(0).value
        if(lastyjdate){
            document.getElementsByName("edc").item(0).innerHTML = addDate(lastyjdate,280);
        }

    };

    if(!edc) {

        var lastyjdate = document.getElementsByName("lastmenstrualdate").item(0).value
        if(lastyjdate){
            document.getElementsByName("edc").item(0).innerHTML = addDate(lastyjdate,280);
        }

    }

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
