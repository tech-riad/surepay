<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Language" content="en" />
<meta name="description" content="<?=get_option('website_desc', "Site Desc")?>">
<meta name="keywords" content="<?=get_option('website_keywords', "keywords")?>">
<title><?=get_option('website_title', "Title")?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?=BASE.get_option('website_favicon', "assets/images/favicon.png")?>">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">

<link href="<?=PATH?>assets/plugins/select2/css/select2.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&amp;display=swap" rel="stylesheet">
<link href="<?=PATH?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=PATH?>assets/css/font.min.css" rel="stylesheet">
<link href="<?=PATH?>assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">

<!-- datatable -->
<link href="<?=PATH?>assets/plugins/DataTables/datatables.min.css" rel="stylesheet">   

<!-- Theme Styles -->
<link href="<?=PATH?>assets/css/main.min.css" rel="stylesheet">
<link href="<?=PATH?>assets/css/custom.css" rel="stylesheet">
<link href="<?=PATH?>assets/css/theme-dark2.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?=PATH?>assets/plugins/jquery-toast/css/jquery.toast.css">


<script type="text/javascript">
    var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>',
        PATH  = '<?php echo PATH; ?>',
        BASE  = '<?php echo BASE; ?>';
    var    deleteItem = "<?php echo lang('Are_you_sure_you_want_to_delete_this_item'); ?>";
    var    deleteItems = "<?php echo lang('Are_you_sure_you_want_to_delete_all_items'); ?>";
</script>
