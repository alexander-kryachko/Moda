<div id="cart" onclick="loadeds()">

  <button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="dropdown-toggle "><i class="fa fa-shopping-cart" aria-hidden="true"></i><?php if($text_items > 0){ ?><span><?php echo $text_items; ?></span> <?php }?></button>
  <ul class="dropdown-menu pull-right">
    <?php if ($products || $vouchers) { ?>
      <li id="add-scroll">
        <ul class="top-cart">
          <?php foreach ($products as $product) { ?>
            <li>
              <div class="remove"><button type="button" onclick="cart.remove('<?php echo $product['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-remove"><i class="fa fa-times"></i></button></div>
              <div class="thumb"><?php if ($product['thumb']) { ?>
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
                <?php } ?></div>
              <div class="product-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <span class="total"><?php echo $product['total']; ?></span>
                <?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                    <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                  <?php } ?>
                <?php } ?>
                <?php if ($product['recurring']) { ?>
                  <br />
                  - <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
                <?php } ?></div>
              <div class="product-quantity"><?php echo $product['quantity']; ?> шт.</div>
              <div class="text-right hidden"><?php echo $product['total']; ?></div>
            </li>
          <?php } ?>
          <?php foreach ($vouchers as $voucher) { ?>
            <li>
              <div class="text-left"><?php echo $voucher['description']; ?></div>
              <div class="text-right hidden">x&nbsp;1</div>
              <div class="text-right"><?php echo $voucher['amount']; ?></div>
              <div class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></div>
            </li>
          <?php } ?>
        </ul>
        <table class="table table-striped">

        </table>
      </li>

      <li>
        <div>
          <table class="table table-striped">
            <?php foreach ($totals as $total) { ?>
              <tr>
                <td class="text-right"><strong><?php echo $total['title']; ?></strong></td>
                <td class="text-right"><?php echo $total['text']; ?></td>
              </tr>
            <?php } ?>
          </table>
          <div class="text-center checkoutBlock">
            <!--<a href="<?php echo $cart; ?>"><strong><i class="fa fa-shopping-cart"></i> <?php echo $text_cart; ?></strong></a>-->
            <a href="<?php echo $checkout; ?>" class="btn btn-green btn-black"><?php echo $text_checkout; ?></a>
          </div>
        </div>
      </li>
    <?php } else { ?>
      <li>
        <p class="text-center"><?php echo $text_empty; ?></p>
      </li>
    <?php } ?>
  </ul>
</div>
