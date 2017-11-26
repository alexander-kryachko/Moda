<div id="slideshow<?php echo $module; ?>" class="owl-carousel slideshowBlock hidden-xs"  style="opacity: 1;">
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['title']) { ?>
      <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
      <!--<div class="position">
        <span><?php /*echo $banner['title']; */?></span>
        <?php /*if ($banner['link']) { */?><a href="<?php /*echo $banner['link']; */?>"><?php /*echo $text_go_link; */?></a><?php /*} */?>
      </div>-->
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
  $('#slideshow<?php echo $module; ?>').owlCarousel({
/*    a
    autoplayTimeout:3000,
    autoplayHoverPause:true,
   // animate: 'fadeOut',
    items: 1,
    navigation: false,
    animateOut: 'fadeOut',
    pagination: true,
    loop:true,
    itemsDesktop : [1280,1],
    itemsDesktopSmall : [1024,1],
    itemsTablet : [768,1],
    itemsMobile : [479,1]*/
  autoPlay: 8000,
    items: 1,
    animateOut: 'fadeOut',
      stopOnHover: true,
      slideSpeed : 1500,
      paginationSpeed : 1500,
    loop: true,
  itemsDesktop : [1280,1],
  itemsDesktopSmall : [1024,1],
  itemsTablet : [768,1],
  itemsMobile : [479,1]
  });
--></script>