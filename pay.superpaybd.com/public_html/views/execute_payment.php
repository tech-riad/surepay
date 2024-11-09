<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Secure request-<?=get_option('website_name','Your Site')?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_SITE.get_option('website_favicon', BASE."assets/images/favicon.png")?>">
        <?=link_asset('css/style.css')?>
        <?=link_asset('css/style2.css')?>     

  </head>
  <body>
    <div id="loader"><div class="loadingio-spinner-ripple-wsf5cxo48ch"><div class="ldio-japzwhp0h9j"> <div> </div><div></div> </div></div></div>
    <div class="container-m bg1">
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
        <img src="<?=BASE_SITE.payment_option($setting['g_type'])?>" alt="<?=$setting['g_type']?>" />
        <div> 
            <input class="bg2"type="text"placeholder="ট্রান্সজেকশন আইডি দিন"id="transaction_id"autocomplete="off"autofocus/> 
        </div>

        <?php include 'methods/'.$setting['g_type'].'.php'; ?>
      </div>
      <div class="bottom bg2" id="payment_submit_done" data-tmp_id="<?=session('tmp_ids')?>" data-href="<?=base_url('request/save_payment/'.$setting['g_type'])?>">Confirm</div>
    </div>

    <!-- java script  -->
    <?=script_asset('jquery.js')?>
    <script>  
        var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>';
        $(document).on("click", "#payment_submit_done", function(event) {
            event.preventDefault();
            var element = $(this),
                url = element.attr("data-href"),
                tmp_id = element.attr("data-tmp_id"),
                t_type = "<?=$setting['t_type']?>",
                transaction_id = $('#transaction_id').val(),
                data = $.param({ token: token, tmp_id: tmp_id, transaction_id: transaction_id, t_type: t_type });

            element.prop("disabled", true);
            element.html('<p style="color:blue">🕥 Loading...</p>');
            $("#loader").css("display","block");

            setTimeout(function() {
                $.post(url, data, function(_result) {
                    showToast(_result.title, _result.message, _result.status);
                    if (_result.redirect) {
                        window.location.href = _result.redirect;
                    }
                }, 'json').always(function() {
                    element.prop("disabled", false);
                    element.html('CONFIRM'); 
                    $("#loader").css("display","none");

                });
            }, 5000);
        });


        $(document).on("click", ".text-to-cliboard" , function(){let vl = $(this).attr('data-value'), params = {'type': 'text', 'value': vl, }; copyToClipBoard(params,'toast') });

    </script>
    
    <?php if (!empty($setting['t_type']) && $setting['t_type']=='bank') { ?>
        <script type="text/javascript">
            $(document).on('change', '#payment_slip',function() {
                var file = this.files[0];
                var formData = new FormData();

                formData.append('fileToUpload', file);
                $("#loader").css("display","block");


                $.ajax({
                    url: "<?php echo base_url('files/upload_files'); ?>",
                    type: "post",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#loader").css("display","none");
                        var data = JSON.parse(response);
                        if (data.status == "success") {
                            var _img_link = data.link;
                            $('#transaction_id').val(_img_link);
                            showToast('Successfull',data.message, data.status);
                        }else{
                            showToast('Successfull',data.message, data.status);
                        }
                    }
                });
            });
        </script>
    <?php } ?>

    <!-- java script  -->
  </body>
</html>
