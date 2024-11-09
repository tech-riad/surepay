<!DOCTYPE html>
<html lang="en" class="h-100">

<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="description" content="<?=get_option('website_desc', "Site Desc")?>">
    <meta name="keywords" content="<?=get_option('website_keywords', "keywords")?>">
    <title><?=get_option('website_title', "Title")?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?=BASE.get_option('website_favicon', BASE."assets/images/website/favicon.png")?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
 
    <?=link_asset('bootstrap.min')?>
    <?=link_asset('meanmenu')?>
    <?=link_asset('boxicons.min')?>
    <?=link_asset('magnific-popup.min')?>
    <?=link_asset('odometer.min')?>
    <?=link_asset('owl.carousel.min')?>
    <?=link_asset('owl.theme.default.min')?>
    <?=link_asset('animate.min')?>
    <?=link_asset('style')?>
    <?=link_asset('responsive')?>
    <?=link_asset('theme-dark')?>

    <link rel="stylesheet" type="text/css" href="<?=BASE?>assets/plugins/jquery-toast/css/jquery.toast.css">

   
</head>

<body>
    <div id="page-overlay" class="visible incoming"> <div class="loader-wrapper-outer"> <div class="loader-wrapper-inner"> <div class="lds-double-ring"> <div></div> <div></div> <div> <div></div> </div> <div> <div></div> </div> </div> </div> </div> </div>

    <?=$template['body']?>


    <?=script_asset('jquery.min')?>
    <?=script_asset('bootstrap.bundle.min')?>
    <?=script_asset('form-validator.min')?>
    <?=script_asset('contact-form-script')?>
    <?=script_asset('jquery.ajaxchimp.min')?>
    <?=script_asset('jquery.meanmenu')?>
    <?=script_asset('jquery.magnific-popup.min')?>
    <?=script_asset('odometer.min')?>
    <?=script_asset('jquery.appear')?>
    <?=script_asset('owl.carousel.min')?>
    <?=script_asset('thumb-slide')?>
    <?=script_asset('wow.min')?>
    <?=script_asset('custom')?>
    <script src="<?=base_url('assets/plugins/jquery-toast/js/jquery.toast.js')?>"></script>
    <?=script_asset('process')?>
    <?=script_asset('general')?>

    
   <?php
      if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
    ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php } ?>

    <?php
        if (!empty($msg = $this->session->flashdata('message'))) {
            ?>
    <script type="text/javascript">
        notify('<?=$msg['message']?>','<?=$msg['status']?>')
    </script>
            <?php
        }

    ?>
</body>
</html>