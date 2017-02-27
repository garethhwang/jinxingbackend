<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-customer').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
                                <label class="control-label" for="input-name"><?php echo $province; ?></label>
                                <input type="text" name="filter_province_name" value="<?php if($filter_province_name != null) echo $filter_province_name; ?>" placeholder="<?php echo $province; ?>" id="province" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $city; ?></label>
                                <input type="text" name="filter_city_name" value="<?php if($filter_city_name != null) echo $filter_city_name; ?>" placeholder="<?php echo $city; ?>" id="province" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $district; ?></label>
                                <input type="text" name="filter_district_name" value="<?php if($filter_district_name != null) echo $filter_district_name; ?>" placeholder="<?php echo $district; ?>" id="district" class="form-control" />
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="input-name"><?php echo $office_name; ?></label>
                                <input type="text" name="filter_name" value="<?php if($filter_name != null) echo $filter_name; ?>" placeholder="<?php echo $office_name; ?>" id="office_name" class="form-control" />
                            </div>
                            <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
                        </div>
                    </div>
                </div>
                <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-office">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                                <td class="text-left"><?php if ($sort == 'office_id') { ?>
                                    <a href="<?php echo $sort_office_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $office_id; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_office_id; ?>"><?php echo $office_id; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'name') { ?>
                                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $office_name; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_name; ?>"><?php echo $office_name; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'province_id') { ?>
                                    <a href="<?php echo $sort_province_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $province; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_province_id; ?>"><?php echo $province; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'city_id') { ?>
                                    <a href="<?php echo $sort_city_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $city; ?></a>
                                    <?php } else { ?>
                                    <a href="<?php echo $sort_city_id; ?>"><?php echo $city; ?></a>
                                    <?php } ?></td>
                                <td class="text-left"><?php if ($sort == 'district_id') { ?>
                                    <a href="<?php echo $sort_district_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $district; ?></a>
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
                                    <input type="checkbox" name="selected[]" value="<?php echo $office['office_id']; ?>" checked="checked" />
                                    <?php } else { ?>
                                    <input type="checkbox" name="selected[]" value="<?php echo $office['office_id']; ?>" />
                                    <?php } ?></td>
                                <td class="text-left"><?php echo $office['office_id']; ?></td>
                                <td class="text-left"><?php echo $office['name']; ?></td>
                                <td class="text-left"><?php echo $office['province_name']; ?></td>
                                <td class="text-left"><?php echo $office['city_name']; ?></td>
                                <td class="text-left"><?php echo $office['district_name']; ?></td>

                                <td class="text-right">
                                    <a href="<?php echo $office['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
</div>
<script type="text/javascript"><!--
    $('#button-filter').on('click', function() {
        url = 'index.php?route=clinic/clinic&token=<?php echo $token; ?>';

        var filter_province_name = $('input[name=\'filter_province_name\']').val();

        if (filter_province_name) {
            url += '&filter_province_name=' + encodeURIComponent(filter_province_name);
        }

        var filter_city_name = $('input[name=\'filter_city_name\']').val();

        if (filter_city_name) {
            url += '&filter_city_name=' + encodeURIComponent(filter_city_name);
        }

        var filter_district_name = $('input[name=\'filter_district_name\']').val();

        if (filter_district_name) {
            url += '&filter_district_name=' + encodeURIComponent(filter_district_name);
        }

        var filter_name = $('input[name=\'filter_name\']').val();

        if (filter_name) {
            url += '&filter_name=' + encodeURIComponent(filter_name);
        }

        location = url;
    });
    //--></script>

<?php echo $footer; ?>


<!--
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $add; ?>" data-toggle="tooltip" title="增加" class="btn btn-primary"><i class="fa fa-plus"></i></a>
                <button type="button" data-toggle="tooltip" title="删除" class="btn btn-danger"
                        onclick="confirm('确定删除?') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i>
                </button>
            </div>
            <h1>科室管理</h1>
        </div>
    </div>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-product">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td class="text-center" style="width: 25px;">
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                </td>
                <td class="text-center">名称</td>
                <td class="text-center">市</td>
                <td class="text-center">区</td>
                <td class="text-center">地址</td>
                <td class="text-center" style="width: 25px;">操作</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">
                    <input type="checkbox" name="selected[]" value="1"/>
                </td>
                <td class="text-center">
                    name
                </td>
                <td class="text-left">
                    shi
                </td>
                <td class="text-left">
                    qu
                </td>
                <td class="text-left">
                    dizhi
                </td>
                <td class="text-center"><a href="#" data-toggle="tooltip" title="编辑" class="btn btn-primary"><i
                                class="fa fa-pencil"></i></a></td>
            </tr>
            <!--<?php if ($offices) { ?>
            <?php foreach ($offices as $office) { ?>
            <tr>
                <td class="text-center">
                    <?php if (in_array($office['office_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $office['office_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $office['office_id']; ?>" />
                    <?php } ?>
                </td>
                <td class="text-center">
                    <?php echo $office['city']; ?>
                </td>
                <td class="text-left">
                    <?php echo $office['district']; ?>
                </td>
                <td class="text-left">
                    <?php echo $office['office_desc']; ?>
                </td>
                <td class="text-right"><a href="<?php echo $product['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
                <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
</div>
<?php echo $footer; ?>
--!>