<div class="row content-inside">
	<form method="post" action="#" name="cart_products" class="cartProductsForm">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 left-inside">
			<div class="row chars-one">
				<div class="col-xs-12 thumbBlock">
					<div class="thumb">
						<a class="thumbnail" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>">
							<img src="<?php echo $product['image']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>">
						</a>
					</div>
				</div>
			</div>
		</div>
		<div id="product-popup" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 right-inside" data-key="<?php echo $product['key'] ?>">
			<h1><?php echo $product['name']; ?></h1>
			<?php if (isset($product['option']) && !empty($product['option'])) { ?><div class="options-block">
				<div class="productOptions">
					<?php foreach ($product['option'] as $option) { ?>
					<div>
						<small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
					</div>
					<?php } ?>
				</div>
			</div><?php } ?>
			<div class="checkout-block clearfix">
				<div class="item-layout qc-quantity">
					<div class="input-group">
						<span class="input-group-btn"><button class="btn btn-defaut decrease"><i class="fa fa-minus"></i></button></span>
						<input name="product_id" value="<?php echo $product['product_id'] ?>" type="hidden">
						<input name="quantity" value="<?php echo $product['quantity'] ?>" size="2" id="input-quantity-popup" class="form-control" data-refresh="2" type="text" />
						<span class="input-group-btn"><button class="btn btn-defaut increase"><i class="fa fa-plus"></i></button></span>
					</div>
				</div>

				<div class="price-layout col-xs-12">
					<div class="price-single col-xs-12">
						<div class="col-xs-5 label"><?=$text_price_unit?>:</div>
						<div class="col-xs-7 value"><?php echo $product['price'] ?></div>
					</div>
					<div class="price-total col-xs-12">
						<div class="col-xs-5 label"><?=$text_price_total?>:</div>
						<div class="col-xs-7 value"><?php echo $product['total'] ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="cartFooter row">
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 text-left">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><?=$button_continue_buy?></button>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 text-right">
				<a href="<?php echo $checkout ?>" class="btn btn-black"><span><?=$button_checkout_now?></span></a>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).on('click', 'a.goToShop', function(event) {
		location.reload();
	});
</script> 