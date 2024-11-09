<?php
  $info = get_current_user_data()->api_credentials;
  $form_url = client_url($controller_name."/store/api_credentials");
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => get_current_url(), 'method' => "POST");
  $form_hidden = ['type' => 'api_credentials'];

?>
<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-globe"></i> <?=lang("API Credentials")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes,$form_hidden); ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12 col-lg-12">
          
          
          <div class="form-group mb-2">
            <label class="form-label">Your API KEY</label>
              <div class="input-group">
                <input readonly type="text" class="form-control text-to-cliboard" value="<?=get_value($info,'apikey')?>" >
                <span class="input-group-text my-copy-btn cursor-pointer" ><i class="fas fa-copy"></i></span>
              </div>
          </div>  


          <div class="form-group">
            <label class="form-label">Your SECRET KEY</label>
              <div class="input-group">
                <input readonly type="text" class="form-control text-to-cliboard" value="<?=get_value($info,'secretkey')?>" >
                <span class="input-group-text my-copy-btn cursor-pointer" ><i class="fas fa-copy"></i></span>
              </div>
          </div>  

          
        </div>
      </div>
    </div>
    <div class="card-footer text-end">
      <button class="btn btn-primary btn-min-width text-uppercase"><?=lang("RESET KEY")?></button>
    </div>
  <?php echo form_close(); ?>
</div>

<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>

<script type="text/javascript"> 
  $(".my-copy-btn").click(function(){
    let vl = $(this).prev('.text-to-cliboard').val();
    let params = {
            'type': 'text',
            'value': vl,
          };
    copyToClipBoard(params,'toast','Credential Copied Successfully')
  });
</script>