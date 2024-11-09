<?php
  $form_url = client_url($controller_name."/store/".$tab);
  $form_attributes = array('class' => 'form actionForm row', 'data-redirect' => get_current_url(), 'method' => "POST");
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  $status = [  
    '0' => 'Inactive',
    '1' => 'Active'
  ];
  
  $general_elements = [
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $status, @$payment_settings->status, ['class' => $class_element_select]),
      'class_main' => "col-md-6 mb-5",
    ],
    
    [
      'label'      => form_label('API URL(Leave as it is if don\'t need)'),
      'element'    => form_input(['name' => 'api_url', 'value' =>  get_value($payment_settings->params,'api_url')??'https://bpay.binanceapi.com/binancepay/openapi/' , 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('API KEY'),
      'element'    => form_input(['name' => 'api_key', 'value' =>  @get_value($payment_settings->params,'api_key'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Secret KEY'),
      'element'    => form_input(['name' => 'secret_key', 'value' =>  @get_value($payment_settings->params,'secret_key'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    
    
  ];
require_once 'common.php';
  
  
?>

<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-sliders"></i> <?=lang("Binance Setup")?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php echo form_open($form_url, $form_attributes); ?>
        <?php echo render_elements_form($general_elements); ?>
        
        <?=modal_buttons2('Save Setting','');?>

      <?php echo form_close(); ?>
  </div>
</div>

<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 100});
    $('.automatic-selection').select2({
          selectOnClose: true
    });
    
  });
</script>