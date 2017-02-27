<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-product" data-toggle="tooltip" title="保存"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="取消"
                   class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
            <h1>科室管理</h1>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if(isset($office_id)) { ?>
                <h3 class="panel-title"><i class="fa fa-pencil"></i> 编辑科室</h3>
                <?php }else { ?>
                <h3 class="panel-title"><i class="fa fa-pencil"></i> 添加科室</h3>
                <?php } ?>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product"
                      class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="office_name">科室名称</label>

                        <div class="col-sm-10">
                            <input type="text" name="office_name"
                                   value="<?php if($office_name != null) echo $office_name; ?>" placeholder="科室名称"
                                   id="office_name"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="province_name">省</label>
                        <div class="col-sm-10">
                            <select name="province_id" id="province" class="form-control">
                                <option value=""></option>
                                <?php foreach ($provincelist as $provinced) { ?>
                                <?php if($provinced["province_id"]==$province_id) { ?>
                                <option value="<?php echo $provinced['province_id']; ?>"
                                        selected><?php echo $provinced['name']; ?></option>
                                <?php }else { ?>
                                <option value="<?php echo $provinced['province_id']; ?>"><?php echo $provinced['name']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="city_name">市</label>

                        <div class="col-sm-10">
                            <select name="city_id" id="city" class="form-control">
                                <option value=""></option>
                                <?php foreach ($citylist as $cityd) { ?>
                                <?php if($cityd["city_id"]==$city_id) { ?>
                                <option value="<?php echo $cityd['city_id']; ?>"
                                        selected><?php echo $cityd['name']; ?></option>
                                <?php }else { ?>
                                <option value="<?php echo $cityd['city_id']; ?>"><?php echo $cityd['name']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="district_name">区</label>

                        <div class="col-sm-10">
                            <select name="district_id" id="district" class="form-control">
                                <option value=""></option>
                                <?php foreach ($districtlist as $districtd) { ?>
                                <?php if($districtd["district_id"]==$district_id) { ?>
                                <option value="<?php echo $districtd['district_id']; ?>"
                                        selected><?php echo $districtd['name']; ?></option>
                                <?php }else { ?>
                                <option value="<?php echo $districtd['district_id']; ?>"><?php echo $districtd['name']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
    <script>
        $("#province").change(function () {
            var token = getUrlParam("token");
            var provinceid = $(this).val();
            var url = "/admin/index.php?route=clinic/clinic/getallcity&provinceid=" + provinceid + "&token=" + token;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html = "<option></option>";
                    for (var i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i].city_id + "'>" + data[i].name + "</option>";
                    }
                    $("#city").html(html);
                }
            });
        });

        $("#city").change(function () {
            var token = getUrlParam("token");
            var cityid = $(this).val();
            var url = "/admin/index.php?route=clinic/clinic/getalldistinct&cityid=" + cityid + "&token=" + token;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html = "<option></option>";
                    for (var i = 0; i < data.length; i++) {
                        html += "<option value='" + data[i].district_id + "'>" + data[i].name + "</option>";
                    }
                    $("#district").html(html);
                }
            });
        });

    </script>