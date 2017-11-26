<?php if($success){?>
    <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><?php echo $text_success;?></div>
<?php } ?>

<div class="row faq-grid">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 faq-list">
        <div class="text"><?=$text_faq?></div>
        <div class="box-content">
            <?php $i = 0; foreach ($faqs as $faq) { ?>
            <div class="faqs complaints">
                <div class="title review"><span class="name"><?=$faq['author_name']?></span> <span class="date pull-right"><?=$faq['date']?></span></div>
                <?php if( !empty($faq['title']) ) { ?>
                <div class="request"><?php echo $faq['title']; ?></div>
                <?php } ?>
                <?php if( !empty($faq['description']) ) { ?>
                    <hr>
                <div class="description"><?php echo $text_description.': '.$faq['description']; ?></div>
                <?php } ?>
            </div>
            <?php $i++; } ?>
            <script>
                $(function() {
                    $( ".title" ).click(function() {
                        $( this ).toggleClass( "active", 0 );
                        $( this ).next().toggleClass( "active", 300 );
                    });
                });
            </script>
        </div>
    </div>
    <div class="col-xs-1"></div>
    <div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 faq-form">
        <form action="/complaints" method="POST" class="form-horizontal">
            <fieldset>
                <legend><?=$text_info?></legend> 
            </fieldset>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group required">
                        <div class="col-xs-12">
                            <input type="text" name="author_name" value="<?php echo $author_name;?>" class="form-control default" placeholder="<?=$entry_author_name?>" />
                            <?php if($error_author_name){?>
                                <div class="text-danger"><?php echo $error_author_name;?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group required">
                        <div class="col-xs-12">
                            <input type="text" name="author_mail" value="<?php echo $author_mail; ?>" class="form-control default" placeholder="<?=$entry_author_mail?>" />
                            <?php if($error_author_email){?>
                                <div class="text-danger"><?php echo $error_email;?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group required">
                <div class="col-xs-12">
                    <textarea name="title" rows="5" class="form-control default" placeholder="<?=$entry_faq?>"><?php echo $title;?></textarea>
                    <?php if($error_title){?>
                        <div class="text-danger"><?php echo $error_title;?></div>
                    <?php }?>
                </div>
            </div>
            <div class="form-group required">
                <div class="col-xs-12 text-center">
                    <input type="submit" value="<?php echo $entry_submit;?>" class="btn btn-black btn-large"/>
                </div>
            </div>
        </form>
    </div>
</div>
<!--
<?php if ($faq['children']) { ?>
<ul>
<?php foreach ($faq['children'] as $child) { ?>
<li>
<?php if ($child['faq_id'] == $child_id) { ?>
<a href="<?php echo $child['href']; ?>" class="active"> - <?php echo $child['title']; ?></a>
<?php } else { ?>
<a href="<?php echo $child['href']; ?>"> - <?php echo $child['title']; ?></a>
<?php } ?>
</li>
<?php } ?>
</ul>
<?php } ?>
-->