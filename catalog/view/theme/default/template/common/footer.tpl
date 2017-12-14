<footer>
		<div class="container">
			<div class="row menuBlock">
				<div class="catalogBlock">
					<h5><?php echo $text_extra; ?></h5>
					<?php echo $content_footer; ?>
				</div>
				<div class="contactBlock">
					<h5><?php echo $text_account; ?></h5>
					<?php /*if($telephone) { */?><!--<span><?php /*echo $telephone; */?></span>--><?php /*} */?>
					<span><?php echo $email; ?></span>
					<!--<span><?php /*echo $address; */?></span>-->
					<span>Call: <a href="tel:<?=$telephone?>" class="skype"><?=$telephone?></a></span>
				</div>
				<!--<div class="emailBlock">
					<h5><?php /*echo $text_information; */?></h5>
					<input type="text" id="reg_email" name="news_email" placeholder="<?/*=$text_manufacturer*/?>" >
                    <span id="valid"></span>
					<button type="button" data-loading-text="<?php /*echo $text_loading; */?>" id="reg_email_submit"><?/*=$text_sitemap*/?></button>
				</div>-->
				<div class="socailBlock hidden-xs">
				</div>
			</div>
			<div class="copyBlock clearfix">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pull-left powered">
					<?=$powered; ?>
				</div>
				<div class="col-xs-5 pull-left hidden-xs">
					<span class="title"><?=$text_service?></span>
<!--					<img src="/catalog/view/theme/default/image/payment.png" alt="payment" />-->
					<ul class="payment">
						<li class="item1 "><a></a></li>
						<li class="item2"><a></a></li>
						<li class="item3"><a></a></li>
					</ul>
				</div>
				<div class="col-xs-4 pull-right">
					<?php echo $language; ?>
				</div>
			</div>
		</div>
	</footer>

</div>
	<?php echo $modals ?>
<p id="topon" style="display: block">
	<a href="#top"><span></span></a>
</p>
		<script>
			$(document).on('click', '#reg_email_submit', function() {
				if($('#reg_email').val() != '') {
					var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
					if(pattern.test($('#reg_email').val())){
						$.ajax({
							url: 'index.php?route=common/footer',
							dataType: 'text',
							type: 'POST',
							data: "email_news=" + $("#reg_email").val(),
							success: function (data) {
								console.log(data);
								if ( data === 'error' ) {
									$('#reg_email').css({'border' : '1px solid #ff0000'});
									$('#valid').text('<?=$text_valid_valid?>');
									$('#reg_email_submit').attr('value','<?=$text_sitemap?>');
								}
								if ( data === 'sucsess' ) {
									$('#reg_email').css({'border' : '1px solid #569b44'});
									$('#valid').text('');
									$('#reg_email_submit').addClass('disabled');
									$('#reg_email_submit').attr('disabled','disabled');
									$('#reg_email_submit').text('<?=$text_valid_submit?>');
								}
							}
						});
					} else {
						$('#reg_email').css({'border' : '1px solid #ff0000'});
						$('#valid').text('<?=$text_valid_error?>');
					}
				} else {
					$('#reg_email').css({'border' : '1px solid #ff0000'});
					$('#valid').text('<?=$text_valid_false?>');
				}
			});
		</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
	(function(){ var widget_id = '0tLI75VA5g';var d=document;var w=window;function l(){
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
	</body>
</html>
