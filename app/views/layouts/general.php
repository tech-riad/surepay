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

    <link rel="shortcut icon" type="image/x-icon" href="<?=BASE.get_option('website_favicon', "assets/images/website/favicon.png")?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320
    
    <meta property="og:url" content="https://superpaybd.com">
    <meta property="og:type" content="Payment Gateway">
    <meta property="og:title" content="SuperPay BD | Personal Account Automation">
    <meta property="og:description" content="SuperPay BD | Bangladeshi Simplified Payment Gateway - Easy to Use">
    <meta property="og:image" content="<?= PATH.get_option('website_logo') ?>">
    <meta property="og:image:alt" content="SuperPay BD">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="SuperPay BD">

    <!-- Twitter Card Meta Tags (optional but recommended for Twitter sharing) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SuperPay BD | Personal Account Automation">
    <meta name="twitter:description" content="SuperPay BD | Bangladeshi Simplified Payment Gateway - Easy to Use">
    <meta name="twitter:image" content="<?= PATH.get_option('website_logo') ?>">

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
<?php 
      if(get_option('enable_goolge_translator','1')){
         ?>
<style> .VIpgJd-ZVi9od-ORHb-OEVmcd,.goog-te-gadget-simple img{visibility: hidden!important;} .goog-te-gadget-simple {background-color: transparent!important; border: none!important; } 
</style>
      <?php 
   }
 ?>
<?php echo htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES); ?>
 
</head>
<body>
    <div class="loader">
     <div class="d-table">
        <div class="d-table-cell">
           <div class="spinner">
              <div class="rect1"></div>
              <div class="rect2"></div>
              <div class="rect3"></div>
              <div class="rect4"></div>
              <div class="rect5"></div>
           </div>
        </div>
     </div>
    </div>
    <div class="navbar-area fixed-top">
     <div class="mobile-nav">
        <a href="<?=base_url()?>" class="logo">
            <img src="<?=PATH.get_option('website_logo')?>" class="logo-one" alt="Logo" >
        </a>
     </div>
     <div class="main-nav">
        <div class="container-fluid">
           <nav class="navbar navbar-expand-md navbar-light">
              <a class="navbar-brand" href="<?=base_url()?>">
                  <img src="<?=PATH.get_option('website_logo')?>" class="logo-one" alt="Logo" height="60">
                  <img src="<?=PATH.get_option('website_logo_mark')?>" class="logo-two" alt="Logo" height="60">
              </a>
              

              <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                 <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?=base_url()?>" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                       <a href="<?=base_url('#services')?>" class="nav-link">Service</a>
                    </li>
                    <li class="nav-item">
                       <a href="<?=base_url('#about')?>" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                       <a href="<?=base_url('#pricing')?>" class="nav-link">Pricing</a>
                    </li>
                    <li class="nav-item">
                       <a href="<?=base_url('#faq')?>" class="nav-link">Faq</a>
                    </li>
                    <li class="nav-item ml-2">
                       <a href="<?=base_url('developers')?>" class="nav-link" style="font-weight: 700; background-color: #CA4246; background-image: linear-gradient( 45deg, #CA4246 16.666%, #E16541 16.666%, #E16541 33.333%, #F18F43 33.333%, #F18F43 50%, #8B9862 50%, #8B9862 66.666%, #476098 66.666%, #476098 83.333%, #A7489B 83.333%); background-size: 100%; background-repeat: repeat; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Developer Tools</a> </li>

                 </ul>
                 <div class="side-nav">
                     <?php 
                           if(get_option('enable_goolge_translator','1')){
                              ?>
                     <a id="google_translate_element" class="left-btn" style="padding-left: 0;"></a>
                           <?php 
                        }
                      ?>                     

                     <?php if (session('uid')) {?>
                        <a class="left-btn" href="<?=base_url('user/dashboard')?>">
                        <i class="bx bxs-dashboard"></i>Dashboard
                        </a>
                     <?php }else{ ?>
                       <a class="left-btn" href="<?=base_url('signin')?>">
                       <i class="bx bx-log-out"></i>
                       Sign In
                       </a>
                       <a href="<?=base_url('signup')?>" class="cmn-btn">
                       Sign Up
                       <i class="bx bx-plus"></i>
                       </a>
                     <?php } ?>
                 </div>
              </div>
           </nav>
        </div>
     </div>
    </div>

    <?=$template['body']?>

    <footer class="pt-100 pb-70">
     <div class="container">
        <div class="row">
           <div class="col-sm-6 col-lg-3">
              <div class="footer-item">
                 <div class="footer-logo">
                    <a href="#">
                    <img src="<?=BASE.get_option('website_logo_mark') ?>" alt="Logo">
                    </a>
                    <p><?=get_option('website_desc') ?></p>
                 </div>
              </div>
           </div>
           <div class="col-sm-6 col-lg-3">
              <div class="footer-item">
                 <div class="footer-links">
                    <h3>Support</h3>
                    <ul>
                       <li>
                          <a href="<?=base_url('#faq')?>">FAQ</a>
                       </li>
                       <li>
                          <a href="<?=base_url('privacy-policy')?>" target="_blank">Privacy Policy</a>
                       </li>
                       <li>
                          <a href="<?=base_url('terms')?>" target="_blank">Terms & Condiitons</a>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
           <div class="col-sm-6 col-lg-2">
              <div class="footer-item">
                 <div class="footer-links">
                    <h3>Compnay</h3>
                    <ul>
                       <li>
                          <a href="#about" target="_blank">About Us</a>
                       </li>
                       <li>
                          <a href="#services" target="_blank">Services</a>
                       </li>
                       <li>
                          <a href="#pricing" target="_blank">Our Pricing</a>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
           <div class="col-sm-6 col-lg-4">
              <div class="footer-item">
                 <div class="footer-address">
                    <h3>Address</h3>
                    <ul>
                       <li>
                          <span>Address:</span>
                          <?=get_option('address') ?>
                       </li>
                       <li>
                          <span>Email:</span>
                          <a href="mailto:<?=get_option('contact_email')?>"><span class="__cf_email__">[email&#160;protected]</span></a>
                       </li>
                       <li>
                          <span>Phone:</span>
                          <a href="tel:<?=get_option('contact_tel') ?>"><?=get_option('contact_tel') ?></a>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>
        </div>
     </div>
    </footer>
    <div class="copyright-area">
     <div class="container">
        <div class="row">
           <div class="col-lg-6">
              <div class="copyright-item">
                 <p>
                    <?=get_option('copy_right_content') ?>@<script>document.write(new Date().getFullYear())</script>
                 </p>
              </div>
           </div>
           <div class="col-lg-6">
              <div class="copyright-item">
                 <ul>
                    <li>
                       <a href="<?=get_option('social_facebook_link')?>" target="_blank">
                       <i class="bx bxl-facebook"></i>
                       </a>
                    </li>
                    <li>
                       <a href="<?=get_option('social_twitter_link')?>" target="_blank">
                       <i class="bx bxl-twitter"></i>
                       </a>
                    </li>
                    <li>
                       <a href="<?=get_option('social_instagram_link')?>" target="_blank">
                       <i class="bx bxl-instagram"></i>
                       </a>
                    </li>
                    <li>
                       <a href="<?=get_option('social_pinterest_link')?>" target="_blank">
                       <i class="bx bxl-pinterest-alt"></i>
                       </a>
                    </li>
                    <li>
                       <a href="<?=get_option('social_youtube_link')?>" target="_blank">
                       <i class="bx bxl-youtube"></i>
                       </a>
                    </li>
                 </ul>
              </div>
           </div>
        </div>
     </div>
    </div>
    <div class="go-top">
     <i class="bx bx-up-arrow"></i>
     <i class="bx bx-up-arrow"></i>
    </div>

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
    
<?php 
      if(get_option('enable_goolge_translator','1')){
         ?>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'bn,hi,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

         <?php 
      }
    ?>
<?php 
   if(get_option('enable_notification_popup')==1 && get_cookie('home_popup')!=1){
      set_cookie("home_popup", "1", 180);
?>
<div class="modal-infor">
<div class="modal" id="notification">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><i class="fe fe-bell"></i> <?=lang("Notification")?></h4>
      </div>

      <div class="modal-body">
        <?=get_option('notification_popup_content')?>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?=lang("Close")?></button>
      </div>
    </div>
  </div>
</div>
</div>
<script>
$(document).ready(function(){
  var is_notification_popup = "<?=get_option('enable_notification_popup', 0)?>"
  setTimeout(function(){
      if (is_notification_popup == 1) {
        $("#notification").modal('show');
      }else{
        $("#notification").modal('hide');
      }
  },500); 
});
</script>
<?php } ?>

<?php echo htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES); ?>


</body>
</html>