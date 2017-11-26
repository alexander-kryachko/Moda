<?php echo $header; ?>
<div class="container page account home">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <?php echo $content_top; ?>
      <div class="welcomeText">
        <h2><?php echo $text_my_account; ?></h2>
        <h4><?php echo $text_my_orders; ?></h4>
        <p><?php echo $text_my_newsletter; ?></p>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<script>
  $(document).ready(function () {
    var window_h = $('#content').height();
    var content_h = $('.welcomeText').height();
    $('.welcomeText').css({'position':'absolute','left':'0','top':'50%','margin-top':-content_h/2});
  });
</script>
<?php echo $footer; ?>