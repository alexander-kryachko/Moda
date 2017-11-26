<?php echo $header; ?>
<div class="container page success">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
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
      <div class="success-checkout">
        <h1><span><?php echo $heading_title; ?></span></h1>
        <div class="text_message">
          <?php echo $text_message; ?>
        </div>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<script>
  $(document).ready(function () {
    if ( $('body').hasClass('checkout-success') ) {
      var window_h = $('#content').height();
      var content_h = $('.success-checkout').height();
      $('.success-checkout').css({'position':'absolute','left':'0','top':'50%','margin-top':-content_h/2,'width':'100%'});
    }
  });
</script>
<?php echo $footer; ?>