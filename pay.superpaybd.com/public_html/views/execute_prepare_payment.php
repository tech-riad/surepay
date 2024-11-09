<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Secure Payment-<?=get_option('website_name','Your Site')?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_SITE.get_option('website_favicon', BASE_SITE."assets/images/favicon.png")?>">
        <?=link_asset('css/style.css')?>
  </head>
  <body>
    <div class="container-m">
      <div class="top d-flex-s">
        <div class="logo">
          <img src="<?=BASE_SITE.get_option('website_logo')?>" alt="<?=get_option('website_name')?>" />
        </div>
        <button onclick="window.location.href='<?=base_url("request/execute/".session('tmp_ids')); ?>'">&#x2716;</button>
      </div> 
      <div class="brand">
        <div class="card d-flex">
          <div class="brand-logo">
            <img src="<?=BASE_SITE.$tmp['all_info']['brand_logo']?>" alt="<?=$tmp['all_info']['brand_name']?>" />
          </div>
          <div class="brand-info">
            <h1><?=$tmp['all_info']['brand_name']?></h1>
            <p>Transaction ID : <span class="bg2-t"><?=$tmp['all_info']['transaction_id']?></span></p>
          </div>
        </div>
      </div> 
      <div class="method">
        <!-- tab_content -->
        <?php if (!empty($act)) { ?>
        <div class="tab-content" id="mobile_banking">
            <div class="methods"> 
                <?php 
                    foreach($act as $mb){
                        $te = $this->custom_encryption->encrypt($mb);
                ?>
                <div class="row" onclick="location.href='<?=base_url('request/execute_payment/'.$setting['g_type'].'/'.$tmp['all_info']['tmp_ids'].'?acc_tp='.$te)?>' ">
                    <img src="<?=BASE_SITE.payment_option($setting['g_type'])?>" alt="<?=$setting['g_type']?>" />
                    <small class="ribbon"><?=strtoupper($mb)?></small>
                </div>        
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="bottom">Pay <?=currency_format($tmp['all_info']['total_amount'])?></div>
    </div>

    <!-- java script  -->
    <?=script_asset('jquery.js')?>
    <script>
      $(document).ready(function () {
        $(".tab-content:first").addClass("active");
        $(".menu .mbtn:first").addClass("active");

        $(".mbtn").click(function () {
          let id = $(this).attr("data-target");
          $(".mbtn").removeClass("active");
          $(this).addClass("active");
          $(".tab-content").removeClass("active");
          $("#" + id).addClass("active");
        });
      });
    </script>
    <!-- java script  -->
  </body>
</html>
