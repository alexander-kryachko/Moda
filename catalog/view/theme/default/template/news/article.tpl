<h1><span><?php echo $heading_title; ?></span></h1>
<div class="article-content">
	<div class="row">
		<?php if ($thumb) { ?><div class="image-col">
			<img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
			<span class="date"> <?php echo $text_posted_pon. ': ' .$date_added; ?></span>
		</div><?php } ?>
		<div class="<?php if ($thumb) { ?>description-col<?php } else { ?>description-col full<?php } ?>">
			<div class="descriptionBlock">
				<?php echo $description; ?>
			</div>
		</div>
	</div>
	<?php if ($gallery_images) { ?><div class="row article-gallery">
		<?php $i=1; foreach ($gallery_images as $gallery) { ?>
			<a class="gallery-element" href="<?php echo $gallery['popup']; ?>" title="<?php if ( !empty($gallery['text']) ) { echo $gallery['text']; } else { echo $heading_title.' галерея фото #'.$i; } ?>">
				<img src="<?php echo $gallery['thumb']; ?>" alt="<?php if ( !empty($gallery['text']) ) { echo $gallery['text']; } else { echo $heading_title.' галерея фото #'.$i; } ?>" title="<?php if ( !empty($gallery['text']) ) { echo $gallery['text']; } else { echo $heading_title.' галерея фото #'.$i; } ?>" />
			</a>
		<?php $i++;} ?>
	</div><?php }?>
</div>
