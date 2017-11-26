<?php echo $header; ?>
  <div class="container page information">
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
    <div class="row">
      <div id="content" class="col-xs-12">
        <h1><span><?php echo $heading_title; ?></span></h1>
        <?php echo $content_bottom; ?>
      </div>
    </div>
  </div>
<?php echo $footer; ?>