<?php if ($modules) { ?>
<div class="content_absolute">

    <div class="close_absolute"></div>
<div class="fixed">
    <div class="owh">
        <?php foreach ($modules as $module) { ?>
            <?php echo $module; ?>
        <?php } ?>
        <div class="infoBlock">
            <!--<span><?/*=$config_telephone*/?></span>-->
            <span><?=$config_email?></span>
            <!--<address><?/*=$config_address*/?></address>-->

        </div>
        <div class="loginBlock">
            <a href="<?=$account?>"><?=$text_login?></a>
            <a href="<?=$register?>"><?=$text_register?></a>
        </div>
        <!--<ul class="social-net">
            <li class="inst"><a href="#"></a></li>
        </ul>-->
    </div>
</div>
</div>
<?php } ?>