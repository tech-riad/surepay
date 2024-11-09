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

    <link rel="shortcut icon" type="image/x-icon" href="<?=get_option('website_favicon', BASE."assets/images/favicon.png")?>">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <style type="text/css"> *{margin: 0;padding: 0;font-family: 'poppins', sans-serif;box-sizing: border-box;background-color: black;}.container{width: 100vw;height: 100vh;padding: 10%;position: relative;overflow: hidden;}.content{top: 50%;position: absolute;transform: translateY(-50%);color: #fff;}.content h1{font-size: 64px;font-weight: 600;}.content h1 span{color:#ff3753;}.content button{background: transparent;border: 2px solid #fff;outline: none;padding: 12px 25px;color: #fff;display: flex;align-items: center;margin-top: 30px;cursor: pointer;}.content button img{width: 15px;margin-left: 10px;}.launch-time{display: flex;}.launch-time div{flex-basis: 200px;}.launch-time div p{font-size: 60px;margin-bottom: -4px;}.rocket{width: 250px;position: absolute;right: 10%;bottom: 0;animation: rocket 10s linear infinite;transform-origin: center bottom;}@keyframes rocket{0%{bottom: 10%;left:0;opacity: 0;transform: rotate(0deg);}100%{bottom: 90%;left: 100%;opacity: 1;transform: rotate(360deg);}}</style>
    <?=htmlspecialchars_decode(get_option('embed_head_javascript', ''), ENT_QUOTES)?>

</head>

<body>
<?=$template['body']?>

    <?=htmlspecialchars_decode(get_option('embed_javascript', ''), ENT_QUOTES)?>
</body>
</html>
