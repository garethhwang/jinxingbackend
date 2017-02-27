<?php echo $header; ?>
<div class="container">
    <h1>帮助手册</h1>
    <form>
        <fieldset>
            <legend>FAQ</legend>
            <?php foreach ($faq as $faqOne) { ?>
            <div class="form-group ">
                <label class="col-sm-2 control-label"><?php echo $faqOne["title"]; ?></label>
                <div class="col-sm-10">
                    <label><?php echo $faqOne["content"]; ?></label>
                </div>
            </div>
            <?php } ?>
        </fieldset>
    </form>
</div>
