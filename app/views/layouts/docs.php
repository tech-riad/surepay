<!DOCTYPE html>
<html>
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
      <meta name="MobileOptimized" content="320">
      <link rel="stylesheet" href="<?=PATH?>assets/dev/css/style.css">
      <link rel="stylesheet" href="<?=PATH?>assets/dev/css/custom.css">
      <link rel="stylesheet" href="<?=PATH?>assets/dev/css/doc.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/go.min.js"></script>

   </head>
   <body class="" data-spy="scroll" data-target=".js-scrollspy">
      <header class="site-header">
         <div class="container">
            <div class="row">
               <div class="col-xs-12">
                  <a href="<?=base_url()?>" class="site-header__logo">
                     <img src="<?=PATH.get_option('website_logo')?>"style="max-height: 80px;max-width:200px;object-fit: contain;">
                  </a>
               </div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container -->
      </header>
      <!-- /.site-header -->
      <?=$template['body']?>
      
      <!-- /.js-footer-area -->
      <script src="<?=PATH?>assets/dev/js/vendor/jquery.min.js"></script>
      <script type="text/javascript" src="<?=PATH?>assets/dev/js/vendor/bootstrap/affix.min.js"></script>
      <script type="text/javascript" src="<?=PATH?>assets/dev/js/vendor/bootstrap/scrollspy.min.js"></script>
      <script type="text/javascript" src="<?=PATH?>assets/dev/js/vendor/matchHeight.min.js"></script>
      <script type="text/javascript" src="<?=PATH?>assets/dev/js/scripts.min.js"></script>
   </body>
</html>