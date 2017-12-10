<?php echo $header; ?><?php if( ! empty( $mfilter_json ) ) { echo '<div id="mfilter-json" style="display:none">' . base64_encode( $mfilter_json ) . '</div>'; } ?>
<div class="container page search">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <h1><span><?php echo $heading_title; ?></span></h1>
  <div class="row">
  <?php if ($products) { echo $column_left; } ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-xs-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-xs-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-xs-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>" <?php if (!$products) { echo 'style="padding-left:269px;"'; } ?>>
      <?php echo $content_top; ?>
      <div id="mfilter-content-container">
        <div class="row searchRow">
          <div class="col-lg-5 col-md-3 col-sm-4 col-xs-12">
            <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <select name="category_id" data-jcf="{&quot;wrapNative&quot;: false, &quot;wrapNativeOnMobile&quot;: false}" class="jcf-hidden">
              <option value="0"><?php echo $text_category; ?></option>
              <?php foreach ($categories as $category_1) { ?>
                <?php if ($category_1['category_id'] == $category_id) { ?>
                  <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
                <?php } ?>
                <?php foreach ($category_1['children'] as $category_2) { ?>
                  <?php if ($category_2['category_id'] == $category_id) { ?>
                    <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                  <?php } else { ?>
                    <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                  <?php } ?>
                  <?php foreach ($category_2['children'] as $category_3) { ?>
                    <?php if ($category_3['category_id'] == $category_id) { ?>
                      <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              <?php } ?>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-black" />
          </div>
        </div>
        <div class="row searchRow" style="margin: 15px -15px 0;">
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <label class="checkbox-inline">
              <?php if ($sub_category) { ?>
                <input type="checkbox" name="sub_category" value="1" id="description" checked="checked" />
              <?php } else { ?>
                <input type="checkbox" name="sub_category" value="1" id="sub_category" />
              <?php } ?>
              <span><?php echo $text_sub_category; ?></span></label>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <label class="checkbox-inline">
              <?php if ($description) { ?>
                <input type="checkbox" name="description" value="1" id="description" checked="checked" />
              <?php } else { ?>
                <input type="checkbox" name="description" value="1" id="description" />
              <?php } ?>
              <span><?php echo $entry_description; ?></span></label>
          </div>
        </div>
        <?php if ($products) { ?>
          <br>
          <div class="row editProduct">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 sortBlock text-right">
              <select data-jcf="{&quot;wrapNative&quot;: false, &quot;wrapNativeOnMobile&quot;: false}" id="input-sort" class="two-height form-control" onchange="location = this.value;">
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
                      <?php if ($product['discount']) { ?><div class="top-seller"></div><?php }?>
                      <?php if($product['special_end'] > 0):?>
                        <span class="counter<?php if($product['add_images']):?> and_images<?php endif;?>" id="counter_<?php print $product['product_id'];?>_featured"></span>
                        <script>counter($('#counter_<?php print $product['product_id']?>_featured'), <?php print $product['special_end']; ?>);</script>
                      <?php endif;?>
                      <?php if($product['percent']):?><div class="percent">-<?php echo $product['percent']; ?>%</div><?php endif;?>
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
                    <?php if ($product['price']) { ?>
                      <p class="price">
                        <?php if (!$product['discount']) { ?>
                          <span class="price-default"><?php echo $product['price']; ?></span>
                        <?php }else{?>
                            <span class="price-old"><?php echo $product['price']; ?></span>
                            <span class="price-new"><?php echo $product['discount']; ?></span>
                          <p class="economy">You save <?php echo $product['save']; ?></p>
                        <?php }?>
                      </p>
                    <?php } ?>
                  </div>

                  <button class="add-to-cart btn btn-lg btn-block" type="button" <?php if ( $product['quantity'] >= '1' ) { ?>onclick="cart.add('<?php echo $product['product_id']; ?>');"<?php } ?> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                  <button class="hidden" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                  <button class="hidden" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                  <a class="hidden" href="<?php echo $product['href']; ?>" data-page="fast-review" data-title="<?php echo $product['name']; ?>" data-toggle="modal" data-target="#myModal" class="ajaxPage" class="ajaxPage"><i class="fa fa-eye"></i></a>

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
          <br>
          <p class="text_empty"><i class="fa fa-bell-o"></i> <?php echo $text_empty; ?></p>
        <?php } ?>
      </div>
      <?php echo $content_bottom; ?>
    </div>
    <?php echo $column_right; ?>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>