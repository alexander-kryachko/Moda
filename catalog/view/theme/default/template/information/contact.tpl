<?php echo $header; ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPLWRChohShPz4NgDMvago4lKnIB1IaJo"></script>
<div class="container page contact">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
      <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
      <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
      <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><span><?php echo $heading_title; ?></span></h1>
      <div class="row contactbox">
        <div class="col-lg-offset-3 col-md-offset-3 text-right col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="phone">
            <span><b>Тел.</b><?=$telephone?></span>
            <?php if ($telephone_2) { ?><span><?=$telephone_2?></span><?php } ?>
            <?php if ($telephone_3) { ?> <span><?=$telephone_3?></span><?php } ?>
            <?php if ($telephone_4) { ?><span><?=$telephone_4?></span><?php } ?>
            <?php if ($telephone_5) { ?><span><b>WhatsApp:</b><?=$telephone_5?></span><?php } ?>
            <?php if ($viber) { ?><span><b>Vider:</b><?=$viber?></span><?php } ?>
          </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
          <span><?=$email_c?></span>
          <address><?=$address?></address>
          <span>Skype: <a href="skype:<?=$skype?>?call" class="skype"><?=$skype?></a></span>
          <?php if ($open) { ?><span><?php echo $text_open; ?>: <?php echo $open; ?></span><?php } ?>
        </div>
      </div>

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal col-lg-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <fieldset>
          <h3 class="text-center"><?php echo $text_contact; ?></h3>
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="form-group required">
                <div class="col-sm-12">
                  <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control two-height" placeholder="<?php echo $entry_name; ?>" />
                  <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
              <div class="form-group required">
                <div class="col-sm-12">
                  <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control two-height" placeholder="<?php echo $entry_email; ?>" />
                  <?php if ($error_email) { ?>
                    <div class="text-danger"><?php echo $error_email; ?></div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group required">
            <div class="col-sm-12">
              <textarea name="enquiry" rows="7" id="input-enquiry" class="form-control" placeholder="<?php echo $entry_enquiry; ?>"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
                <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php if ($site_key) { ?>
            <div class="form-group">
              <div class="col-lg-offset-2 col-md-offset-2 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                <?php if ($error_captcha) { ?>
                  <div class="text-danger"><?php echo $error_captcha; ?></div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </fieldset>
        <div class="buttons">
          <div class="text-center">
            <input class="btn btn-black btn-large" type="submit" value="<?php echo $button_submit; ?>" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript">
  function initialize() {

    var MY_MAPTYPE_ID = 'custom_style';

    var featureOpts = [
      {
        "stylers": [
          { "weight": 3 },
          { "saturation": -100 }
        ]
      },{
        "featureType": "road.arterial",
        "elementType": "labels",
        "stylers": [
          { "visibility": "on" }
        ]
      },{
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
          { "color": "#6f6e6f" },
          { "weight": 2 },
          { "lightness": 60 }
        ]
      },{
        "featureType": "transit",
        "stylers": [
          { "weight": 4 },
          { "hue": "#000000" },
          { "saturation": 50 }
        ]
      },{
        "featureType": "administrative",
        "elementType": "labels",
        "stylers": [
          { "color": "#000000" },
          { "lightness": -23 },
          { "weight": 0.4 }
        ]
      }
    ];

    var mapOptions = {
      zoom: 17,
      scrollwheel: false,
      center: new google.maps.LatLng(49.9998411, 36.2437855),
      mapTypeId: MY_MAPTYPE_ID
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    var image = 'label.png';
    var myLatLng = new google.maps.LatLng(49.9998411, 36.2437855);
    var beachMarker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      icon: image
    });

    var styledMapOptions = {
      name: 'Custom Style'
    };

    var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);

    map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

  }

  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="map-canvas" class="mapBlock"></div>
<?php echo $footer; ?>
