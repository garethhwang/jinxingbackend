<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username"><?php echo $entry_username; ?></label>
            <div class="col-sm-10">
              <input type="text" name="username" value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" id="input-username" class="form-control" />
              <?php if ($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group"><?php echo $entry_user_group; ?></label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user-group" class="form-control">
                <?php foreach ($user_groups as $user_group) { ?>
                <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
                <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-realname"><?php echo $entry_realname; ?></label>
            <div class="col-sm-10">
              <input type="text" name="realname" value="<?php echo $realname; ?>" placeholder="<?php echo $entry_realname; ?>" id="input-realname" class="form-control" />
              <?php if ($error_realname) { ?>
              <div class="text-danger"><?php echo $error_realname; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
            <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
              <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" autocomplete="off" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="filter_province_id"><?php echo $province; ?></label>
            <div class="col-sm-10">
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
          <div class="form-group">
            <label class="col-sm-2 control-label" for="filter_city_id"><?php echo $city; ?></label>
            <div class="col-sm-10">
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
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $district; ?></label>
            <div class="col-sm-10">
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
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $office_name; ?></label>
            <div class="col-sm-10">
            <select name="filter_office_id" id="office" class="form-control">
              <option value=""></option>
              <?php foreach ($officelist as $officed) { ?>
              <?php if($officed["office_id"]==$filter_office_id) { ?>
              <option value="<?php echo $officed['office_id']; ?>"
                      selected><?php echo $officed['name']; ?></option>
              <?php }else { ?>
              <option value="<?php echo $officed['office_id']; ?>"><?php echo $officed['name']; ?></option>
              <?php }} ?>
            </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">
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