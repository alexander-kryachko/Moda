<?php echo $header; ?>
<div class="container page note-found">
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
      <h1><?php echo $heading_title; ?></h1>
      <p class="text-error"><?php echo $text_error; ?></p>
      <div class="buttons text-center">
        <a href="javascript: history.go(-1)" class="btn btn-black"><?php echo $go_back; ?></a>
        <a href="/" class="btn btn-black"><?php echo $go_home; ?></a>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
  <script>
    $(document).ready(function () {
      var window_h = $(window).height();
      var content_h = $('#content').height();
      $('#content').css({'position':'absolute','left':'0','top':'50%','margin-top':-content_h/2});
      if ( !$('body').hasClass('error-not_found') ) {
        $('body').addClass('error-not_found');
      }
    });
  </script>
</div>
<?php echo $footer; ?>