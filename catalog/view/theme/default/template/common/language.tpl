<?php if (count($languages) > 1) { ?>
  <div class="languagesBlock">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="language">
      <div class="btn-group">
        <?php foreach ($languages as $language) { if ($code != $language['code']) { ?><button class="dropdown-toggle">
          <span><a href="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></a></span>
        </button><?php } } ?>
        <ul class="dropdown-menu pull-right hidden">
          <?php foreach ($languages as $language) { ?>
            <li><a href="<?php echo $language['code']; ?>"><?php echo $language['name']; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <input type="hidden" name="code" value="" />
      <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    </form>
  </div>
<?php } ?>
