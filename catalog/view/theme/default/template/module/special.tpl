<div class="moduleBox special">
  <h3><span><?php echo $heading_title; ?></span></h3>
  <div class="row">
    <?php foreach ($products as $product) { ?>
      <div class="product-layout col-xs-12">
        <div class="product-thumb transition">
          <div class="image">
            <a href="<?php echo $product['href']; ?>">
              <?php if($product['special_end'] > 0):?>
                <span class="counter" id="counter_<?php print $product['product_id'];?>_bestseller"></span>
                <script>counter($('#counter_<?php print $product['product_id']?>_bestseller'), <?php print $product['special_end']; ?>);</script>
              <?php endif;?>
              <?php if($product['percent']):?><div class="percent">-<?php echo $product['percent']; ?>%</div><?php endif;?>
              <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
            </a>
            <?php $i = 0; if ($product['add_images']) { ?>
              <ul class="list-unstyled add_images">
                <li><img src="<?php echo $product['thumb']; ?>" data-image="<?php echo $product['thumb']; ?>" /></li>
                <?php foreach ($product['add_images'] as $image) { if ( $i == '4' ) { break; } ?>
                  <li><img src="<?php echo $image['thumb']; ?>" data-image="<?php echo $image['image']; ?>" /></li>
                  <?php $i++; } ?>
              </ul>
            <?php } ?>
          </div>
          <div class="caption">
            <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
            <?php if ($product['price']) { ?>
              <p class="price">
                <?php if (!$product['special']) { ?>
                  <span class="price-default"><?php echo $product['price']; ?></span>
                <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span><span class="price-old"><?php echo $product['price']; ?></span>
                <?php } ?>
              </p>
            <?php } ?>
          </div>
          <div class="button-group hidden">
            <button type="button" <?php if ( $product['quantity'] >= '1' ) { ?>onclick="cart.add('<?php echo $product['product_id']; ?>');"<?php } ?>><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
            <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
            <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
            <a href="<?php echo $product['href']; ?>" data-page="fast-review" data-title="<?php echo $product['name']; ?>" data-toggle="modal" data-target="#myModal" class="ajaxPage" class="ajaxPage"><i class="fa fa-eye"></i></a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <script>
    $('.moduleBox.special > .row').owlCarousel({
      //autoPlay: 5000,
      items: 3,
      navigation: true,
      pagination: false
    });
  </script>
</div>
