<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip"
                                       title="<?php echo $button_add; ?>" class="btn btn-primary"><i
                            class="fa fa-plus"></i></a>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"
                        onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-office').submit() : false;"><i
                            class="fa fa-trash-o"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
            </div>
            <div class="panel-body">
                <div class="well">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="filter_province_id"><?php echo $province; ?></label>
                                <select name="filter_province_id" id="province" class="form-control">
                                    <option value=""></option>
                                    <?php foreach ($provincelist as $provinced) { ?>
                                    <?php if($provinced["province_id"]==$filter_province_id) { ?>
                                    <option value="<?php echo $provinced['province_id']; ?>"
                                            selected><?php echo $provinced['name']; ?></option>
                                    <?php }else { ?>
                                    <option value="<?php echo $provinced['province_id']; ?>"><?php echo $provinced['name']; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="filter_city_id"><?php echo $city; ?></label>
                                <select name="filter_city_id" id="city" class="form-control">
                                    <option value=""></option>
                                    <?php foreach ($citylist as $cityd) { ?>
                                    <?php if($cityd["city_id"]==$filter_city_id) { ?>
                                    <option value="<?php echo $cityd['city_id']; ?>"
                                            selected><?php echo $cityd['name']; ?></option>
                                    <?php }else { ?>
                                    <option value="<?php echo $cityd['city_id']; ?>"><?php echo $cityd['name']; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $district; ?></label>
                                <select name="filter_district_id" id="district" class="form-control">
                                    <option value=""></option>
                                    <?php foreach ($districtlist as $districtd) { ?>
                                    <?php if($districtd["district_id"]==$filter_district_id) { ?>
                                    <option value="<?php echo $districtd['district_id']; ?>"
                                            selected><?php echo $districtd['name']; ?></option>
                                    <?php }else { ?>
                                    <option value="<?php echo $districtd['district_id']; ?>"><?php echo $districtd['name']; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $office_name; ?></label>
                                <select name="filter_name" id="office" class="form-control">
                                    <option value=""></option>
                                    <?php foreach ($officelist as $officed) { ?>
                                    <?php if($officed["office_id"]==$filter_name) { ?>
                                    <option value="<?php echo $officed['office_id']; ?>"
                                            selected><?php echo $officed['name']; ?></option>
                                    <?php }else { ?>
                                    <option value="<?php echo $officed['office_id']; ?>"><?php echo $officed['name']; ?></option>
                                    <?php }} ?>
                                </select>
                            </div>
                            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i
                                        class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
                        </div>
                    </div>
                </div>
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-office">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td style="width: 1px;" class="text-center"><input type="checkbox"
                                                                                   onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"/>
                                </td>
                                <td class="text-left"><?php if ($sort == 'office_id') { ?>
                                    <a href="<?php echo $sort_office_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $office_id; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_office_id; ?>"><?php echo $office_id; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'name') { ?>
                                    <a href="<?php echo $sort_name; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $office_name; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_name; ?>"><?php echo $office_name; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'province_id') { ?>
                                    <a href="<?php echo $sort_province_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $province; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_province_id; ?>"><?php echo $province; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'city_id') { ?>
                                    <a href="<?php echo $sort_city_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $city; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_city_id; ?>"><?php echo $city; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'district_id') { ?>
                                    <a href="<?php echo $sort_district_id; ?>"
                                       class="<?php echo strtolower($order); ?>"><?php echo $district; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_district_id; ?>"><?php echo $district; ?></a>
                                    <?php } ?></td>
                                <td class="text-right"><?php echo $column_action; ?></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($offices) { ?>
                            <?php foreach ($offices as $office) { ?>
                            <tr>
                                <td class="text-center"><?php if (in_array($office['office_id'], $selected)) { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $office['office_id']; ?>"
                                           checked="checked"/>
                                    <?php } else { ?>
                                    <input type="checkbox" name="selected[]"
                                           value="<?php echo $office['office_id']; ?>"/>
                                    <?php } ?></td>
                                <td class="text-left"><?php echo $office['office_id']; ?></td>
                                <td class="text-left"><?php echo $office['name']; ?></td>
                                <td class="text-left"><?php echo $office['province_name']; ?></td>
                                <td class="text-left"><?php echo $office['city_name']; ?></td>
                                <td class="text-left"><?php echo $office['district_name']; ?></td>
                                <td class="text-right">
                                    <a href="<?php echo $office['edit']; ?>" data-toggle="tooltip"
                                       title="<?php echo $button_edit; ?>" class="btn btn-primary"><i
                                                class="fa fa-pencil"></i></a>
                                    <a href="<?php echo $office['office_customer']; ?>" data-toggle="tooltip"
                                   title="<?php echo $button_office_customer; ?>" class="btn btn-primary"><i
                                            class="fa fa-list"></i></a></td>

                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#button-filter').on('click', function () {
            url = 'index.php?route=clinic/clinic&token=<?php echo $token; ?>';

            var filter_province_id = $('[name=\'filter_province_id\']').val();

            if (filter_province_id) {
                url += '&filter_province_id=' + filter_province_id;
            }

            var filter_city_id = $('[name=\'filter_city_id\']').val();

            if (filter_city_id) {
                url += '&filter_city_id=' + encodeURIComponent(filter_city_id);
            }

            var filter_district_id = $('[name=\'filter_district_id\']').val();

            if (filter_district_id) {
                url += '&filter_district_id=' + encodeURIComponent(filter_district_id);
            }

            var filter_name = $('[name=\'filter_name\']').val();

            if (filter_name) {
                url += '&filter_name=' + encodeURIComponent(filter_name);
            }

            location = url;
        });

        $("#province").change(function(){
            var token=getUrlParam("token");
            var provinceid=$(this).val();
            var url="/admin/index.php?route=clinic/clinic/getallcity&provinceid="+provinceid+"&token="+token;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html="<option></option>";
                    for(var i=0;i<data.length;i++){
                        html+="<option value='"+data[i].city_id+"'>"+data[i].name+"</option>";
                    }
                    $("#city").html(html);
                }
            });
        });

        $("#city").change(function(){
            var token=getUrlParam("token");
            var cityid=$(this).val();
            var url="/admin/index.php?route=clinic/clinic/getalldistinct&cityid="+cityid+"&token="+token;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html="<option></option>";
                    for(var i=0;i<data.length;i++){
                        html+="<option value='"+data[i].district_id+"'>"+data[i].name+"</option>";
                    }
                    $("#district").html(html);
                }
            });
        });

        $("#district").change(function(){
            var token=getUrlParam("token");
            var districtid=$(this).val();
            var url="/admin/index.php?route=clinic/clinic/getalloffice&districtid="+districtid+"&token="+token;
            $.ajax({
                url: url,
                type: 'GET', //GET
                async: true,    //或false,是否异步
                dataType: 'json',
                success: function (data) {
                    var html="<option></option>";
                    for(var i=0;i<data.length;i++){
                        html+="<option value='"+data[i].office_id+"'>"+data[i].name+"</option>";
                    }
                    $("#office").html(html);
                }
            });
        });


    </script>
</div>
<?php echo $footer; ?>
