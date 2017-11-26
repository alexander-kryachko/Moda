<?php if ($reviews) { ?>
<div class="title show_hide"><span><?=$tab_review_text?></span> <i class="pe-7s-angle-down down"></i><i class="pe-7s-angle-up up"></i></div>
<div class="text slidingDiv">
  <div class="children">
<?php foreach ($reviews as $review) { ?>
<table class="table table-striped">
  <tr>
    <td style="width: 50%;"><strong><?php echo $review['author']; ?></strong></td>
    <td class="text-right"><?php echo $review['date_added']; ?></td>
  </tr>
  <tr>
    <td colspan="2">
      <p><?php echo $review['text']; ?></p>
      <div class="rating">
      <?php for ($i = 1; $i <= 5; $i++) { ?>
      <?php if ($review['rating'] < $i) { ?>
      <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } else { ?>
      <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
      <?php } ?>
      <?php } ?>
      </div>
    </td>
  </tr>
</table>
<?php } ?>
    <div class="row paginationBlock">
      <div class="text-center"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
