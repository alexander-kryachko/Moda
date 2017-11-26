<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<div class="container page manufacturer">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <h1><span><?php echo $heading_title; ?></span></h1>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div id="mfilter-content-container">
        <?php if ($products) { ?>
          <div class="row editProduct">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortBlock text-right">
              <select data-jcf='{"wrapNative": false, "wrapNativeOnMobile": false, "fakeDropInBody": false, "useCustomScroll": true}' id="input-sort" class="two-height form-control" onchange="location = this.value;">
                <?php foreach ($sorts as $sorts) { ?>
                  <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                    <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 viewBlock pull-right text-right">
              <div class="btn-group hidden-xs">
                <button type="button" id="grid-view" class="btn"><i class="fa fa-th-large"></i></button>
                <button type="button" id="list-view" class="btn"><i class="fa fa-th"></i></button>
              </div>
            </div>
          </div>
          <br>
          <div class="row product-layoutBlock" id="maincontent">
            <?php foreach ($products as $product) { ?>
              <div class="product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="product-thumb transition">
                  <div class="image">
                    <a href="<?php echo $product['href']; ?>">
                      <?php if($product['special_end'] > 0):?>
                        <span class="counter<?php if($product['add_images']):?> and_images<?php endif;?>" id="counter_<?php print $product['product_id'];?>_featured"></span>
                        <script>counter($('#counter_<?php print $product['product_id']?>_featured'), <?php print $product['special_end']; ?>);</script>
                      <?php endif;?>
                      <?php echo $product['promotag']; ?>
                      <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
                    </a>
                    <?php $i = 0; if ($product['add_images']) { ?>
                      <ul class="list-unstyled add_images">
                        <li><img src="<?php echo $product['thumb']; ?>" data-image="<?php echo $product['thumb']; ?>" /></li>
                        <?php foreach ($product['add_images'] as $image) { if ( $i == '3' ) { break; } ?>
                          <li><img src="<?php echo $image['thumb']; ?>" data-image="<?php echo $image['image']; ?>" /></li>
                          <?php $i++; } ?>
                      </ul>
                    <?php } ?>
                  </div>
                  <div class="caption">
                    <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                    <div class="model"><?php echo $text_model.' '.$product['model']; ?></div>
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
          <?php if ( !empty($pagination) ) { ?>
            <div class="row paginationBlock">
              <div class="col-sm-12 text-center"><?php echo $pagination; ?></div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <p class="text_empty"><i class="fa fa-bell-o"></i> <?php echo $text_empty; ?></p>
        <?php } ?>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<?php echo $footer; ?>