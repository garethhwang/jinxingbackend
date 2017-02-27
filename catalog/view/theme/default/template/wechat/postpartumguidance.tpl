<?php echo $header; ?>
<div class="container">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
    <h1>产后指导</h1>
    <form>
        <fieldset>
            <legend>您的个人资料</legend>
            <!--<div class="form-group ">
                <label class="col-sm-2 col-md-2 col-lg-2 control-label">昵称:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $openid; ?></label>
                </div>
            </div>-->
            <div class="form-group ">
                <label class="col-sm-2 col-md-2 col-lg-2 control-label">昵称:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $nickname; ?></label>
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-md-2 col-lg-2 control-label">科室:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $department; ?></label>
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2  col-md-2 col-lg-2 control-label">电话:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $telephone; ?></label>
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-md-2 col-lg-2 control-label">邮箱:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $email; ?></label>
                </div>
            </div>
            <div class="form-group ">
                <label class="col-sm-2 col-md-2 col-lg-2 control-label">生产日期:</label>

                <div class="col-sm-10 col-md-10 col-lg-10">
                    <label><?php echo $productiondate; ?></label>
                </div>
            </div>
        </fieldset>
    </form>
    <div class="pull-right">
        <a href="<?php echo $edit; ?>" class="btn btn-primary">编辑</a>
    </div>
</div>

<?php echo $footer; ?>