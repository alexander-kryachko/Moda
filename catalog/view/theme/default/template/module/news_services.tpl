<div class="servicesBlock">
	<h2><?php echo $heading_title; ?></h2>
	<div class="row">
		<div class="owl-demo">
			<?php foreach ($article as $articles) { ?>
				<div class="item newsBox">
					<div class="image"><a href="<?php echo $articles['href']; ?>"><img class="article-image" align="left" src="<?php echo $articles['thumb']; ?>" title="<?php echo $articles['name']; ?>" alt="<?php echo $articles['name']; ?>" /></a></div>
					<h4><a href="<?php echo $articles['href']; ?>"><?php echo $articles['name']; ?></a></h4>
					<div class="description"><?php echo $articles['description']; ?></div>
					<a href="<?php echo $articles['href']; ?>" class="blog-button"><?php echo $button_more; ?>...</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$(".owl-demo").owlCarousel({
			autoPlay: 3000,
			items: 3,
			navigation: true,
			navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
			pagination: false
		});

	});
</script>