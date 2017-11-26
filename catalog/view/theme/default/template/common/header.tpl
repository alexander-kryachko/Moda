<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
  <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
  <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
  <script src="catalog/view/javascript/mf/jquery-ui.min.js" type="text/javascript"></script>

  <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

  <link href="catalog/view/theme/default/stylesheet/stylesheet.css?ver=1.3" rel="stylesheet">
  <link href="catalog/view/theme/default/stylesheet/stylesheets.css?ver=2.1" rel="stylesheet">
  <link href="catalog/view/theme/default/stylesheet/pe-icon-7-stroke.css" rel="stylesheet">

  <!-- jcf scripts and styles -->
  <link rel="stylesheet" href="/catalog/view/theme/default/stylesheet/jcf.css">
  <script src="/catalog/view/javascript/jcf/jcf.js"></script>
  <script src="/catalog/view/javascript/jcf/jcf.radio.js"></script>
  <script src="/catalog/view/javascript/jcf/jcf.select.js"></script>
  <script src="/catalog/view/javascript/jcf/jcf.checkbox.js"></script>
  <script src="/catalog/view/javascript/jcf/jcf.scrollable.js"></script>

  <!-- Important Owl stylesheet -->
  <link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="catalog/view/javascript/jquery/owl-carousel/owl.theme.default.min.css">

<?php foreach ($styles as $style) { ?>
  <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>

  <script src="catalog/view/javascript/linkInPopup.js" type="text/javascript"></script>
  <script src="catalog/view/javascript/common.js" type="text/javascript"></script>
  <script src="catalog/view/javascript/ajax2login.js" type="text/javascript"></script>
  <script src="catalog/view/javascript/callme.js" type="text/javascript"></script>
  <script src="catalog/view/javascript/countdown.js" type="text/javascript"></script>
  <script type="text/javascript" charset="utf-8" src="catalog/view/javascript/jquery.maskedinput-1.3.min.js"></script>
  <script src="catalog/view/javascript/jquery.validate.js" type="text/javascript"></script>

  <!-- iScroll script -->
  <script src="catalog/view/javascript/mf/iscroll.js?v2.0.2.1" type="text/javascript"></script>

  <script>
    var LANGS = {};
    <?php $arr = $languagese; foreach($arr as $group => $langs){ ?>LANGS['<?php echo $group?>']={};<?php foreach($langs as $name_key => $value){?>LANGS['<?php echo $group?>']['<?php echo $name_key ;?>']='<?php echo $value ;?>';<?php } ?><?php } ?>
  </script>
<?php foreach ($scripts as $script) { ?>
  <script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body class="<?php echo $class; ?>" onload="loaded()">
<div class="wrapper">
  <?php echo $content_header; ?>
  <?php echo $content_absolute; ?>
  <header>
    <div class="container">
      <div class="row one-chars">
        <div class="col-xs-4 pull-left first-chars">
          <span class="menu-triggerS"><a onclick="return false;" href="javascript:void(0);" id="menu-trigger" class="menu-trigger"></a></span>
          <?php echo $search; ?>
        </div>
        <div class="col-xs-4 text-center second-chars">
          <a href="<?php echo $home; ?>" class="logo"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
        </div>
        <div class="col-xs-4 pull-right last-chars">
          <?php //echo $language; ?>
          <?php if (!$logged) { ?>
            <a class="login hidden-xs" id="option_login_popup_trigger" data-toggle="modal" data-target="#option_login_popup"><i class="fa fa-user"></i></a>
          <?php } else { ?>
            <a href="/account" class="login logged hidden-xs"><i class="fa fa-user"></i></a>
          <?php } ?>
          <a href="/wishlist" id="wishlistCount" class="wishlist<?php if ($text_wishlist) { echo ' active'; } ?> hidden-xs hidden-sm hidden-md"><i class="pe-7s-like"></i><span><?=$text_wishlist?></span></a>
          <!--<span id="faq" class="hidden-xs"><a href="/faq" class="faq"><i class="pe-7s-help1"></i></a></span>-->
          <div id="callme-buttons">
            <!--<div class="call-min">-->
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fa fa-phone"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><span><?=$telephone?></span></li>
                <?php if ($telephone_2) { ?><li><span><?=$telephone_2?></span></li><?php } ?>
                <?php if ($telephone_3) { ?><li><span><?=$telephone_3?></span></li><?php } ?>
                <?php if ($telephone_4) { ?><li><span><?=$telephone_4?></span></li><?php } ?>
                <li role="separator" class="divider"></li>
                <!--<li id="callme-button"><?/*=$callme_text*/?></li>-->
              </ul>
            <!--</div>-->

          </div>
          <div id="cartTemp"><?php echo $cart; ?> </div>
        </div>
      </div>
      <nav id="menu" class="navbar">
          <?php echo $mainmenu; ?>
      </nav>
      <div class="row hidden">
        <div class="col-sm-4">
          <div id="logo">
            <?php if ($logo) { ?>
              <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
            <?php } else { ?>
              <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
            <?php } ?>
          </div>
        </div>
        <div class="col-sm-5"><?php echo $search; ?>
        </div>
        <div class="col-sm-3"><?php echo $cart; ?></div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        $( '#menu>ul>li.dropdown' ).hover(
            function() {
              $('.headerbg').addClass('in').css({'height':'100%'});
            }, function() {
              $('.headerbg').removeClass('in').css({'height':'0'});
            }
        );
      });
    </script>
  </header>
  <div class="headerbg modal-backdrop fade"></div>
  <div class="modal fade" id="option_login_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">
            <?php echo $text_i_am_returning_customer; ?>
          </h4>
        </div>
        <div class="modal-body">
          <div class="form-group required">
            <input type="text" name="email" class="form-control" value="" id="login_email" placeholder="<?php echo $entry_email; ?>" />
          </div>
          <div class="form-group required">
            <input type="password" name="password" class="form-control" value="" id="login_password" placeholder="<?php echo $entry_password; ?>"/>
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" value="<?php echo $button_login; ?>" id="button_login_popup" class="btn btn-black" />
          <a href="<?php echo $register; ?>" class="btn btn-link"><?php echo $text_register; ?></a><span>/</span><a href="<?php echo $forgotten; ?>" class="btn btn-link"><?php echo $text_forgotten; ?></a>
        </div>
      </div>
    </div>
  </div>
  <?php echo $slideshow; ?>