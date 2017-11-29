<?php if (!$isXhr) { ?>
<?php echo $header; ?>
<div class="container page product">
	<ul class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
	<?php } ?>
	</ul>
	<div id="ajaxView" class="row"><?php echo $column_left; ?>
	<?php if ($column_left && $column_right) { ?>
	<?php $class = 'col-sm-6'; ?>
	<?php } elseif ($column_left || $column_right) { ?>
	<?php $class = 'col-sm-9'; ?>
	<?php } else { ?>
	<?php $class = 'col-sm-12'; ?>
	<?php } ?>
	<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
<?php } ?>
	<div class="row">
		<?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-xs-6'; ?>
		<?php } elseif ($column_left || $column_right) { ?>
		<?php $class = 'col-xs-6'; ?>
		<?php } else { ?>
		<?php $class = 'col-xs-8'; ?>
		<?php } ?>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 thumb">
			<button type="button" data-toggle="tooltip" class="btn btn-default wishlist<?php if ($issetwshlist) { ?> active<?php } ?>" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="pe-7s-like"></i></button>
			<?php if ($thumb || $images) { ?>
				<ul class="thumbnails">


				</ul>
				<script>

					$(window).load(function(){
						var res = '';
						<?php if($special_end > 0):?>
						res += '<span class="counter" id="counter_<?php print $product_id;?>_product"></span>';
						counter($('#counter_<?php print $product_id?>_product'), <?php print $special_end; ?>);
					<?php endif;?>
						res += '<?echo $promo_tag_product_top_right; ?>';
					<?php if ($thumb) { ?>
						res += '<li><a class="thumbnail gallery-element" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">';
						res += '<img id="zoom_mw" data-zoom-image="<?=$popup?>" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" class="img_main" />';
						res += '</a></li>';
						$('.thumbnails').append(res);
					<?php } ?>
						setTimeout(function(){
							<?php if ($images) { ?>
							var out = '';
							<?php foreach ($images as $image) { ?>
							out += '<li>';
							out += '<a class="thumbnail gallery-element" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>';
							out += '</li>';
							<?php } ?>
							$('.thumbnails').append(out);
							<?php } ?>
							$("#zoom_mw").elevateZoom({scrollZoom : true});
						}, 500);

					})
				</script>
			<?php } ?>
		</div>
		<div id="product" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 product">
			<h1><?=$heading_title?></h1>
			<span class="article"><?=$text_article_q.' '.$sku?></span>
			<?php if ($review_status) { ?>
			<div class="rating">
				<?php for ($i = 1; $i <= 5; $i++) { ?>
					<?php if ($rating < $i) { ?>
				<span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
					<?php } else { ?>
				<span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
					<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if ($price) { ?>
			<div class="price">
				<?php if (!$special) { ?>
				<span><?=$price?></span>
				<?php } else { ?>
				<span class="price-new"><?=$special?></span>
				<span style="text-decoration: line-through;"><?=$price?></span>
				<?php } ?>
				<?php if ($discounts) { ?>
				<ul class="list-unstyled">
					<?php foreach ($discounts as $discount) { ?>
					<li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
					<?php } ?>
				</ul>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if (mb_strlen( $description) > '15' ) { ?><div class="description">
				<?=$description?>
			</div><?php } ?>
			<?php if ($attribute_groups) { ?><div class="attribute-block">
				<div class="title"><span><?=$text_features_q?></span> <i class="pe-7s-angle-down down"></i><i class="pe-7s-angle-up up"></i></div>
				<div class="text slidingDiv">
					<ul class="list-unstyled">
						<?php foreach ($attribute_groups as $attribute_group) { ?>
						<li>
							<div class="title hidden"><span><?php echo $attribute_group['name']; ?></span></div>
							<ul class="list-unstyled">
								<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
								<li>
									<span class="name"><?php echo $attribute['name']; ?>:</span>
									<span class="text"><?php echo $attribute['text']; ?></span>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } ?>
						<?php if ($manufacturer) { ?>
							<li>
								<span class="name"><?php echo $text_manufacturer; ?></span>
								<span class="text"><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></span>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div><?php } ?>
			<?php if ($attribute_groups) { ?><div class="attribute-block" style="margin-top: -1px;">
				<div class="title"><span><?=$text_features_table?></span> <i class="pe-7s-angle-down down"></i><i class="pe-7s-angle-up up"></i></div>
				<div class="text slidingDiv">
					<?php echo $table_size; ?>
				</div>
			</div><?php } ?>
			<?php if ($options) { ?><div class="options-block">
				<?php foreach ($options as $option) { ?>
					<?php if ($option['type'] == 'select') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> <?php echo $option['style'] ?> select">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>:</label>
							<select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
										<?php if ($option_value['price']) { ?>
											(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
										<?php } ?>
									</option>
								<?php } ?>
							</select>
						</div>
					<?php } ?>
					<?php if ($option['type'] == 'radio') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> <?php echo $option['style'] ?> radio">
							<label class="control-label"><?php echo $option['name']; ?>:</label>
							<div id="input-option<?php echo $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<div class="radio">
										<label>
											<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
											<?php echo $option_value['name']; ?>
											<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
											<?php } ?>
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<?php if ($option['type'] == 'checkbox') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> <?php echo $option['style'] ?> checkbox">
							<label class="control-label"><?php echo $option['name']; ?>:</label>
							<div id="input-option<?php echo $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
											<?php echo $option_value['name']; ?>
											<?php if ($option_value['price']) { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
											<?php } ?>
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<?php if ($option['type'] == 'image') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> <?php echo $option['style'] ?> image">
							<label class="control-label"><?php echo $option['name']; ?>:</label>
							<div id="input-option<?php echo $option['product_option_id']; ?>">
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
									<div class="radio">
										<label data-toggle="tooltip" data-placement="top" title="<?php echo $option_value['name']; ?><?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>">
											<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" data-img="<?php echo $option_value['product_option_image']; ?>" data-popup="<?php echo $option_value['product_option_image_popup']; ?>" class="img_class" />
											<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
											<span><?php echo $option_value['name']; ?><?php if ($option_value['price']) { ?>(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?></span>
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				<?php } ?>
			</div><?php } ?>
			<div class="form-group">
				<input type="hidden" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
				<button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block" data-title="<?php echo $heading_title ?>" data-target="#modal-cart"><?php echo $button_cart; ?></button>
			</div>
			<?php if ($minimum > 1) { ?>
				<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?=$text_minimum?></div>
			<?php } ?>
			<a href="/index.php?route=information/information/agree&information_id=6" class="agree info hidden-xs"><?=$text_payment_q?></a>
			<!--<div class="consultation"><b><?/*=$text_consultation_q*/?>:</b> <?/*=$consultation*/?></div>-->
			<?php if ($review_status) { ?><div class="review-block">
				<form class="form-horizontal" id="form-review">
					<div id="review"></div>
					<div class="formReview">
						<div class="title show_hide"><span><?=$text_write?></span> <i class="pe-7s-angle-down down"></i><i class="pe-7s-angle-up up"></i></div>
						<div class="text slidingDiv">
							<div class="children"><?php if ($review_guest) { ?>
								<div class="form-group required">
									<div class="col-sm-12">
										<input type="text" name="name" value="" id="input-name" class="form-control" placeholder="<?php echo $entry_name; ?>" />
									</div>
								</div>
								<div class="form-group required">
									<div class="col-sm-12">
										<textarea name="text" rows="5" id="input-review" class="form-control" placeholder="<?php echo $entry_review; ?>"></textarea>
									</div>
								</div>
								<div class="form-group required">
									<div class="col-sm-12">
										<input type="radio" name="rating" value="1" />
										<input type="radio" name="rating" value="2" />
										<input type="radio" name="rating" value="3" />
										<input type="radio" name="rating" value="4" />
										<input type="radio" name="rating" value="5" />
									</div>
								</div>
								<?php if ($site_key) { ?>
									<div class="form-group">
										<div class="col-sm-12">
											<div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
										</div>
									</div>
								<?php } ?>
								<div class="buttons clearfix">
									<div class="text-center">
										<button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-black"><?php echo $button_send; ?></button>
									</div>
								</div>
							<?php } else { ?>
								<?php echo $text_login; ?>
							<?php } ?></div>
						</div>
					</div>
				</form>
			</div><?php } ?>
		</div>
	</div>
<?php if ($products && 1 ==2 ) { ?>
	<div class="moduleBox related">
		<h3><span><?php echo $text_related; ?></span></h3>
		<div <?php if (count($products) > '3') { ?>id="owl-related" <?php } ?>class="row">
			<?php foreach ($products as $product) { ?>
				<div class="product-layout col-xs-12">
					<div class="product-thumb transition">
						<div class="image">
							<a href="<?php echo $product['href']; ?>">
								<?php if($product['special_end'] > 0):?>
									<span class="counter" id="counter_<?php print $product['product_id'];?>_featured"></span>
									<script>counter($('#counter_<?php print $product['product_id']?>_featured'), <?php print $product['special_end']; ?>);</script>
								<?php endif;?>
								<?php echo $product['promotag']; ?>
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
			$(document).ready(function() {
				$("#owl-related").owlCarousel({
					//autoPlay: 5000,
					items : 3,
					pagination: false,
					navigation: true
				});
			});
		</script>
	</div>
<?php } ?>
<?php if (!$isXhr) { ?>
		<?php echo $content_bottom; ?>
	</div>
	<?php echo $column_right; ?>
	</div>
</div>
<script>
    $( document ).ready(function() {
        $( ".img_class" ).click(function() {
            var pathValid = "<?php echo $option_value['product_option_image']; ?>";
            console.log(pathValid);
            if(pathValid === "") {
                console.log('no photo');
            }else{
                var pathToImg = $(this).attr('data-img');
                var pathToPopup = $(this).attr('data-popup');
                $('.img_main').attr("src", pathToImg);
            <?php if (!$isXhr) { ?>$('.img_main').attr("data-zoom-image", pathToPopup);<?php } ?>
                $('.img_main').parent().attr("href", pathToPopup);
            }
        });
    });
</script>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
		clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#review').fadeOut('slow');

	$('#review').load(this.href);

	$('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});
//--></script>

	<script>
		$(document).ready(function () {
			setTimeout(function () {
				/*$('.slidingDiv').each(function () {
					var height = $(this).children().height();
					$(this).hide().height(height);
				});*/
				$(".show_hide").show();
				$('.title').click(function () {
					$(this).toggleClass('active');
					$(this).next().slideToggle();
				})
			}, 300);
		});
	</script>
	<script>
		$(document).on('click', 'a.gallery-element', function (event) {
			event = event || window.event;
			var target = event.target || event.srcElement;
			var link = target.src ? target.parentNode : target;
			var options = {
				index: link,
				event: event,
				fullScreen: false,
				thumbnailIndicators: true,
				carousel: false,
				startSlideshow: false,
				closeOnSwipeUpOrDown: true
			}
			var unique_links = [];
			var links = document.querySelectorAll('a.gallery-element');
			$(links).each(function () {
				var _this = this
				var exists = false;
				$(unique_links).each(function () {
					if ($(_this).attr('href') == $(this).attr('href')) {
						exists = true;
					}
				});
				if (!exists) {
					unique_links.push(this);
				}
			});
			blueimp.Gallery(unique_links, options);
		});
	</script>
	<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
	<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
		<div class="slides"></div>
		<h3 class="title"></h3>
		<a class="prev">‹</a>
		<a class="next">›</a>
		<a class="close">×</a>
		<a class="play-pause"></a>
		<ol class="indicator"></ol>
	</div>
<?php echo $footer; ?>
<?php } ?>