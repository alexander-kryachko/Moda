function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}

/*
var logoTempFlag = true;
var min = false;
$(window).scroll(function() {

	console.log($(window).scrollTop());
	$("header #menu").css('top', $(document).scrollTop());

	if($(window).scrollTop()>61) {
		$("header #menu").css('top', $(window).scrollTop()-61).css({'z-index':'999'});

		min = true;//шапка в мини режиме
		var logoTemp = $('header .second-chars').html();
		var cartTemp = $('#cartTemp').html();

		if(logoTempFlag){
			logoTempFlag = false;
			$('#menu').prepend(logoTemp);
			$('#menu').append(cartTemp);
		}

		$('header #menu #cart').show();
		$('header #menu .logo').show();
	}
	if( $(window).scrollTop()<=61) {
		$("header #menu").css({'top':'0','z-index':'3'});
		$('header #menu .logo').hide();
		$('header #menu #cart').hide();

		min = false;//шапка в обычном режиме
	}
});
*/

var logoTempFlag = true;
var min = false;
$(window).scroll(function() {

	if($(window).scrollTop()>61) {
		$("header #menu").css({'position':'fixed','top':'0'});

		min = true;//шапка в мини режиме
		var logoTemp = $('header .second-chars').html();
		var cartTemp = $('#cartTemp').html();
		var faq = $('#faq').html();
		var menuTrigger = $('.menu-triggerS').html();
		var callme = $('.one-chars #callme-button').html();
		var callmes = $('.one-chars #callme-buttons').clone();
		var wish = $('#wishlistCount').clone();
		var login = $('#option_login_popup_trigger').clone();
		var phone = $('#menu .dropdown-menu[aria-labelledby]').clone();

		if(logoTempFlag){
			logoTempFlag = false;
			$('#menu').prepend(logoTemp);
			$('#menu').prepend(menuTrigger);
			$('#menu').append(cartTemp);
			$('#menu').append(callmes);
			$('#menu').append(faq);
			$('#menu #callme-buttons').prepend(wish);
			$('#menu #callme-buttons').prepend(login);


		}

		$('header').addClass('fixed');
		$('header #menu #cart').show();
		$('header #menu .menu-trigger').show();
		$('header #menu .logo').show();
		$('header #menu #callme-buttons').show();
		$('header #menu .faq').show();
		$('header #menu #wishlistCount').show();
/*		$('#menu #dropdownMenu1').wrap('<div class="call-min"></div>');
		$('.call-min').append(phone);*/

		$('body.checkout-checkout #cart_wrap').css({'position':'fixed','top':'26px'});
	}
	if( $(window).scrollTop()<=61) {
		$('header').removeClass('fixed');
		$("header #menu").css({'position':'relative'});
		$('header #menu .menu-trigger').hide();
		$('header #menu .logo').hide();
		$('header #menu #cart').hide();
		$('header #menu #callme-buttons').hide();
		$('header #menu .faq').hide();
		$('header #menu #callme-button').hide();
		$('header #menu #wishlistCount').hide();

		min = false;//шапка в обычном режиме

		$('body.checkout-checkout #cart_wrap').css({'position':'static','top':'0'});
	}
});

/* Top Div Arrow */
jQuery(document).ready(function(){
	// hide #back-top first
	jQuery("#topon").hide();
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#topon').fadeIn();
			} else {
				jQuery('#topon').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#topon a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});
});

$(document).on('click', '#menu-trigger', function(){
	$('.content_absolute').toggleClass('mp-pushed');
	$('.wrapper').toggleClass('mp-pushed');

	var myScroll;
	var i_loader;
	myScroll = new IScroll('.content_absolute .fixed', {mouseWheel: true, scrollbars: true, mouseWheelSpeed: 100});
	i_loader = true;

});

$(document).on('click', '.close_absolute', function(){
	$('.content_absolute').toggleClass('mp-pushed');
	$('.wrapper').toggleClass('mp-pushed');
});

$(document).on('click', '.qc-quantity button', function(event){
	event.preventDefault();

	var quantity = parseInt($(this).parent().parent().children('#input-quantity-popup').val()),
		key = $('#product-popup').data('key');

	if ($(this).is('.increase')) {
		quantity ++;
		$(this).parent().parent().children('#input-quantity-popup').val(quantity);
	} else if ($(this).is('.decrease')) {
		quantity --;
		$(this).parent().parent().children('#input-quantity-popup').val(quantity > 0 ? quantity: 0);
	}
	cart.update(key, quantity);
});

$(document).on('click', '#button-cart', function () {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function () {
			$('#button-cart').button('loading');
		},
		complete: function () {
			$('#button-cart').button('reset');
		},
		success: function (json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				// $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				// $('html, body').animate({scrollTop: 0}, 'slow');

				$('#modal-cart')
					.addClass('cart-popup')
					.find('.modal-body')
						.html(json['success'])
					.end()
					.find('.modal-header .modal-title')
						.empty()
						.append($('#modal-cart .title'))
					.end()
					.find('.modal-footer')
						.empty()
						.append($('#modal-cart .cartFooter'))
					.end()
					.modal({show:true});

				$('#cart > button span').html(json['total']);

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		}
	});
});

var myScroll;
var i_loader;

function loadeds () {
	if ( i_loader !=  true ) {
		setTimeout(function(){
			//myScroll = new IScroll('#add-scroll', {mouseWheel: true, scrollbars: true, mouseWheelSpeed: 100});
			myScroll = new IScroll('#add-scroll', {mouseWheel: true, scrollbars: true, mouseWheelSpeed: 100});
			i_loader = true;
		}, 2000);

	}
}

function loaded () {
	if ( i_loader !=  true ) {
		myScroll = new IScroll('#html', {mouseWheel: true, scrollbars: true, mouseWheelSpeed: 100});
		i_loader = true;
	}
}


$(function() {
	jcf.replaceAll();
});

$(document).on('click', 'select', function () {
	jcf.replaceAll();
});

$(document).on('click', '.product-thumb .image .add_images img', function () {
	$(this).parent().parent().parent().children('a').children('img').attr('src', $(this).data('image'));
});

$(document).ready(function () {

	callme.init('#callme-button');

	$('.product-thumb .image .add_images img').hover(function () {
		$(this).parent().parent().parent().children('a').children('img').attr('src', $(this).data('image'));
	});

	// Highlight any found errors
	$('.text-danger').each(function () {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});

	if ($(".descriptionBlock").height() < '420') {
		$('.descriptionMore').hide();
	} else {
		$('.descriptionBlock').addClass('descr-text');
		//$( ".descr-text").css({'height':'420px'})
	}

	// Drop down text
	$('#button-dt').on('click', function () {
		$(".descr-text").toggleClass("newClass", 500);
		$(this).toggleClass("active", 0);

		if ($("#button-dt").hasClass('active')) {
			$("#button-dt span").text($("#button-dt").attr('data-short-test'));
			$("#button-dt i").removeClass('fa-angle-down');
			$("#button-dt i").addClass('fa-angle-up');
		}
		if (!$("#button-dt").hasClass('active')) {
			$("#button-dt span").text($("#button-dt").attr('data-full-test'));
			$("#button-dt i").removeClass('fa-angle-up');
			$("#button-dt i").addClass('fa-angle-down');
		}
	});

	// Currency
	$('#currency .currency-select').on('click', function (e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

		$('#currency').submit();
	});

	// Language
	$('#language a').on('click', function (e) {
		e.preventDefault();

		$('#language input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#language').submit();
	});

	/* Search */
	$('#search input[name=\'search\']').parent().find('button').on('click', function () {
		url = $('base').attr('href') + 'index.php?route=product/search';
		var value = $('#search input[name=\'search\']').val();
		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}
		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function (e) {
		if (e.keyCode == 13) {
			$('header input[name=\'search\']').parent().find('button').trigger('click');
		}
	});

	// Menu
	$('#menu .dropdown-menu').each(function () {
		var menu = $('#menu').offset();
		var dropdown = $(this).parent().offset();

		var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});

	localStorage.setItem('display', 'grid');

	// Product Grid
	$(document).on('click', '#grid-view', function () {
		$( '.viewBlock .btn').removeClass('active');
		$( this).addClass('active');
		$('#maincontent > .product-layout').css({'height': 'auto'});
		$('#maincontent .product-layout > .clearfix').remove();
		cols = $('#column-right, #column-left').length;
		if (cols == 2) {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6');
		} else if (cols == 1) {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6');
		} else {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-4 col-sm-6 col-xs-6');
		}

		setTimeout(function () {
			var max_product_height = 0;
			$('#maincontent > .product-layout').each(function () {
				var product_height = parseInt($(this).height());
				if (product_height > max_product_height) {
					max_product_height = product_height;
				}
			});
			$('#maincontent > .product-layout').height(max_product_height + 'px');
		}, 1000);
		localStorage.setItem('display', 'grid');
	});

	// Product List
	$(document).on('click', '#list-view', function () {
		$( '.viewBlock .btn').removeClass('active');
		$( this).addClass('active');
		$('#maincontent > .product-layout').css({'height': 'auto'});
		$('#maincontent .product-layout > .clearfix').remove();
		cols = $('#column-right, #column-left').length;
		if (cols == 2) {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-6');
		} else if (cols == 1) {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-6');
		} else {
			$('#maincontent .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-3 col-sm-6 col-xs-6');
		}
		setTimeout(function () {
			var max_product_height = 0;
			$('#maincontent > .product-layout').each(function () {
				var product_height = parseInt($(this).height());
				if (product_height > max_product_height) {
					max_product_height = product_height;
				}
			});
			$('#maincontent > .product-layout').height(max_product_height + 'px');
		}, 1000);
		localStorage.setItem('display', 'list');
	});

	if (localStorage.getItem('display') == 'grid') {
		$('#grid-view').trigger('click');
	} else {
		$('#list-view').trigger('click');
	}

	// tooltips on hover
	$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});

	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function () {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
	});
});

// Cart add remove functions
var cart = {
	'add': function (product_id, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function () {
				$('#cart > button').button('loading');
			},
			complete: function () {
				$('#cart > button').button('reset');
			},
			success: function (json) {
				$('.alert, .text-danger').remove();

				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					// $('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					// $('html, body').animate({scrollTop: 0}, 'slow');

					setTimeout(function () { // Need to set timeout otherwise it wont update the total
						$('#cart > button span').html(json['total']);
					}, 100);

					$('#cart > ul').load('index.php?route=common/cart/info ul li');

					$('#modal-cart')
						.addClass('cart-popup')
						.find('.modal-body')
							.html(json['success'])
						.end()
						.find('.modal-header .modal-title')
							.empty()
							.append($('#modal-cart .title'))
						.end()
						.find('.modal-footer')
							.empty()
							.append($('#modal-cart .cartFooter'))
						.end()
						.modal({show:true});
				}
			}
		});
	},
	'update': function (key, quantity) {
		$.ajax({
			// url: 'index.php?route=checkout/cart/edit',
			url: 'index.php?route=checkout/cart/refresh',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			beforeSend: function () {
				$('#cart > button').button('loading');
			},
			complete: function () {
				$('#cart > button').button('reset');
			},
			success: function (json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('.cart-popup .price-total .value').html(json['product_total']);
					$('#cart > button').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'remove': function (key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function () {
				$('#cart > button').button('loading');
			},
			complete: function () {
				$('#cart > button').button('reset');
			},
			success: function (json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button span').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var voucher = {
	'add': function () {

	},
	'remove': function (key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function () {
				$('#cart > button').button('loading');
			},
			complete: function () {
				$('#cart > button').button('reset');
			},
			success: function (json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart > button').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

$(document).on('click', 'button.wishlist', function () {
	$(this).addClass('active');
});

var wishlist = {
	'add': function (product_id) {
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function (json) {
				$('.alert').remove();

				if (json['success']) {
					//$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['info']) {
					//$('#content').parent().before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> ' + json['info'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				$('button.wishlist').attr('data-original-title', json['total_in_wishlist']);
				$('#wishlistCount span').html(json['total']);

				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	},
	'remove': function () {

	}
}

var compare = {
	'add': function (product_id) {
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function (json) {
				$('.alert').remove();

				if (json['success']) {
					$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

					$('#compare-total').html(json['total']);

					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			}
		});
	},
	'remove': function () {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function (e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function (data) {
			html = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog" style="width: 552px;">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '<br></div>';
			html += '    </div';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function ($) {
	$.fn.autocomplete = function (option) {
		return this.each(function () {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function () {
				this.request();
			});

			// Blur
			$(this).on('blur', function () {
				setTimeout(function (object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function (event) {
				switch (event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function (event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function () {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function () {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function () {
				clearTimeout(this.timer);

				this.timer = setTimeout(function (object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function (json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);
