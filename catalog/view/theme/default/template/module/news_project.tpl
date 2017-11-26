<div class="projectBlock">
	<h2><?php echo $heading_title; ?></h2>
	<div class="row">
		<?php $count_ncategories = count($ncategories);
		foreach ($ncategories as $ncategory) {?>
		<div class="col-xs-4 effect-apollo">
			<img class="article-image" align="left" src="<?php echo $ncategory['thumb']; ?>" title="<?php echo $ncategory['name']; ?>" alt="<?php echo $ncategory['name']; ?>" />
			<div class="item">
				<p><?php $asd = utf8_substr($ncategory['description'], 0, 90); echo $asd; ?></p>
				<h3><?php echo $ncategory['name']; ?></h3>
				<a href="<?php echo $ncategory['href']; ?>"><?php echo $button_more; ?></a>
			</div>
		</div>
		<?php } ?>
		<?php $coun_article = 6 - $count_ncategories; $i = 0; foreach ($article as $articles) { ?>
		<div class="col-xs-4 effect-apollo">
			<img class="article-image" align="left" src="<?php echo $articles['thumb']; ?>" title="<?php echo $articles['name']; ?>" alt="<?php echo $articles['name']; ?>" />
			<div class="item">
				<p><?php $asd = utf8_substr($articles['description'], 0, 90); echo $asd.'..'; ?></p>
				<h3><?php echo $articles['name']; ?></h3>
				<a href="<?php echo $articles['href']; ?>"><?php echo $button_more; ?></a>
			</div>
		</div>
		<?php $i++;
			if ( $coun_article == $i ) { break; }
		} ?>
	</div>
	<div class="full-project">
		<a href="<?php echo $link_all_project; ?>" class="btn btn-orange"><?php echo $text_all_project; ?></a>
	</div>
</div>