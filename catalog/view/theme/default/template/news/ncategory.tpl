<h1><span><?php echo $heading_title; ?></span></h1>
<div class="blog-category">
	<?php if ($article) { ?>
		<div class="row">
			<?php foreach ($article as $articles) { ?>
				<div class="col-xs-12 itemArticle">
					<img class="article-image" align="left" src="<?=$articles['thumb']?>" title="<?=$articles['name']?>" alt="<?=$articles['name']?>" />
					<div class="item">
						<h2><a href="<?=$articles['href']?>"><?=$articles['name']?></a></h2>
						<div class="description"><?=$articles['description']?></div>
						<div class="more clearfix">
							<span class="date"><?=$articles['date_added']?></span>
							<a href="<?=$articles['href']?>"><?php echo $button_more; ?><i class="fa fa-angle-double-right"></i></a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<?php if ($pagination) { ?><div class="row paginationBlock">
			<div class="col-sm-12 text-center"><?=$pagination?></div>
		</div><?php } ?>
	<?php } else { ?>
		<div class="c_error"><?php echo $text_empty; ?></div>
	<?php } ?>
</div>