<?php echo $header; ?>
<div class="container page forgotten">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><span><?php echo $heading_title; ?></span></h1>
      <p class="text-center"><?php echo $text_email; ?></p>
      <br>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <fieldset>
          <div class="form-group required">
            <div class="col-xs-12">
              <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control two-height" />
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="text-center">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-black btn-large" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>