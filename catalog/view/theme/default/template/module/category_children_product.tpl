<div class="category-children">
  <div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
    <?php $item_cat = 0; foreach ($categories as $category) { ?>
      <li role="presentation" class="<?php if ( ( $category_id == 60 && $item_cat == 0 ) || ( '60_'.$category['category_id'] == '60_'.$category_id ) ) { echo 'active'; } else { echo ''; } ?>"><a href="#category_60_<?php echo $category['category_id']; ?>" aria-controls="category_60_<?php echo $category['category_id']; ?>" role="tab" data-toggle="tab"><span><?php echo $category['name']; ?></span></a></li>
    <?php $item_cat++;} ?>
    </ul>
    <div class="tab-content">
      <?php $item_cat = 0; foreach ($categories as $category) { ?>
        <div role="tabpanel" class="tab-pane <?php if ( ( $category_id == 60 && $item_cat == 0 ) || ( '60_'.$category['category_id'] == '60_'.$category_id ) ) { echo 'active'; } else { echo ''; } ?>" id="category_60_<?php echo $category['category_id']; ?>">
          <?php if ($category['children']) { ?>
            <ul class="list-unstyled row">
              <?php foreach ($category['children'] as $child) { ?>
                <li class="col-xs-3">
                  <?php if ($child['category_id'] == $child_id) { ?>
                    <a href="<?php echo $child['href']; ?>" class="list-group-item active">
                      <img src="<?php echo $child['thumb']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>">
                      <span><?php echo $child['name']; ?></span>
                    </a>
                  <?php } else { ?>
                    <a href="<?php echo $child['href']; ?>" class="list-group-item">
                      <img src="<?php echo $child['thumb']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>">
                      <span><?php echo $child['name']; ?></span>
                    </a>
                  <?php } ?>
                </li>
              <?php } ?>
            </ul>
          <?php } else { ?>

          <?php } ?>
        </div>
      <?php $item_cat++;} ?>
    </div>
  </div>
</div>