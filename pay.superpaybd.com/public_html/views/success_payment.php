<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Secure request-<?=get_option('website_name','Your Site')?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_SITE.get_option('website_favicon', BASE."assets/images/favicon.png")?>">
      <style> @font-face {font-family: bangla; src: url(banglabold.ttf); } body {background: #ffffff; color: #ffffff; height: 100vh; cwidth: 100vw; overflow: hidden; line-height: 30px; font-size: 15px; font-family: "bangla", sans-serif; } a {text-decoration: none; font-family: "bangla", sans-serif; } small {font-size: 12px; } .container-m {text-align: center; border-radius: 10px; margin: auto; width: 400px; background-color: #007100; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); box-shadow: 0px 0px 34px -12px #615f5f; } .container-m h1 {font-size: 24px; } .container-m p {font-size: 18px; } .d-flex {display: flex; justify-content: space-between; } .top {margin: 10px 15px; justify-content: space-between; color: #ffffff; } .logo img {max-width: 140px; height: auto; filter: brightness(100); } .top button {border: none; cursor: pointer; background: none; color: #ffffff; font-size: 22px; } .bottom {margin: -1px; margin-top: -10px; height: 55px; display: flex; align-items: center; justify-content: center; background-color: #a6fd94; color: #ff5353; border-radius: 15px 15px 0px 0px; font-size: 18px; font-weight: 700; cursor: pointer; font-family: "bangla", sans-serif; } .bottom a {color: #00bf62; } .image {display: flex; justify-content: center; } .image img {height: 220px; width: auto; margin-top: 80px; }.mb{margin-bottom: 10px} @media screen and (max-width: 600px) {.container-m {width: 100vw; height: 100%; top: 0px; left: 0; transform: none; border-radius: 0; } .bottom {position: fixed; bottom: 0; width: 100%; } } </style> 

  </head>
  <body>
    <div class="container-m">
      <div class="top d-flex">
        <div class="logo">
          <img src="<?=BASE_SITE.get_option('website_logo')?>" alt="<?=get_option('website_name')?>" />
        </div>
        <button>&#x2716;</button>
      </div>
      <h1>Payment Success</h1>
      <p>আপনার পেমেন্ট সঠিকভাবে সম্পন্ন হয়েছে</p>
      <div class="image">
        <img src="<?=base_url("assets/images/success.png")?>" alt="Success" />
      </div>
      <p style="color: rgb(255, 174, 0); font-size: 18px">
        Please, don't Close the browser!
      </p>
      <div class="mb">
        You will be redirected within
        <span
          id="redirect_coundown"
          style="font-weight: 600; font-size: 16px !important"
          >3</span
        >
        <span style="font-weight: 600; font-size: 16px !important">seconds</span
        >.
      </div>
    </div>

    <script>
      var timeleft = 2;
      var downloadTimer = setInterval(function () {
        if (timeleft <= 0) {
          clearInterval(downloadTimer);
          document.getElementById("redirect_coundown").innerHTML = "0";
          location.href = "<?php echo $temp_success_url.'&p_type='.$p_type ?>";
        } else {
          document.getElementById("redirect_coundown").innerHTML = timeleft;
        }
        timeleft --;
      }, 1000);
    </script>
  </body>
</html>
