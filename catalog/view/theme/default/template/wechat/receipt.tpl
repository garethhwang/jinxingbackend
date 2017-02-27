<!DOCTYPE html>
<html lang="en">
<!--<?php echo $header; ?>-->
<header>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="catalog/view/javascript/bootstrap/switch/docs/css/highlight.css" rel="stylesheet">
  <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
  <link href="catalog/view/javascript/bootstrap/switch/docs/css/main.css" rel="stylesheet">
  <link href="catalog/view/javascript/bootstrap/switch/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
</header>
<body>
<!--
<?php if ($categories) { ?>
<div class="container visible-xs">
  <nav id="menu" class="navbar">
    <div class="navbar-header"><span id="category" class="visible-xs"><?php echo $text_faq_category ?></span>
      <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex2-collapse"><i class="fa fa-bars"></i></button>
    </div>
    <div class="collapse navbar-collapse navbar-ex2-collapse">
      <ul class="nav navbar-nav">
        <?php foreach ($categories as $category) { ?>
        <?php if ($category['children']) { ?>
        <li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
          <div class="dropdown-menu">
            <div class="dropdown-inner">
              <?php foreach ($category['children'] as $children) { ?>
              <ul class="list-unstyled">
                <li><a href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a></li>
              </ul>
              <?php } ?>
            </div>
          </div>
        </li>
        <?php } else { ?>
        <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
  </nav>
</div>
<?php } ?>-->
<div class="container">
  <!--
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <?php if ($faqs) { ?>

        <div class="panel-group" id="accordion">
          <?php for($x=0; $x<count($faqs); $x++) { ?>
          <?php $faq = $faqs[$x] ?>
          <?php $aid = 'faqlink'.$x ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <div class="row">
                <div class="col-xs-6 text-left">
                  <h4 class="panel-title" style="margin-top: 0.7rem"><?php echo $faq['title']; ?><a hidden id="<?php echo $aid?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $faq['faq_id']; ?>"></a></h4>
                </div>
                <div class="col-xs-6 text-right">
                  <input id="switch" type="checkbox" data-on-text="是" data-off-text="否" value="<?php echo $aid?>">
                </div>
              </div>
            </div>
            <div id="collapse<?php echo $faq['faq_id']; ?>" class="panel-collapse collapse">
              <div class="panel-body"><?php echo $faq['answer']; ?></div>
            </div>
          </div>
          <?php } ?>
        </div>

        <div class="row">
            <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
            <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>

<script src="catalog/view/javascript/bootstrap/switch/docs/js/bootstrap.min.js"></script>
<script src="catalog/view/javascript/bootstrap/switch/dist/js/bootstrap-switch.js"></script>
<script>
    $(function(argument) {
        $('[type="checkbox"]').bootstrapSwitch();
    })


    $('input[id="switch"]').on('switchChange.bootstrapSwitch', function(event, state) {
        //console.log(this); // DOM element
        //console.log(event); // jQuery event
        //console.log(state); // true | false

        document.getElementById(this.value).click();

    });
</script>
</body>
</html>