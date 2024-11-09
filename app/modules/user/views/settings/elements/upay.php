<?php
  $form_url = client_url($controller_name."/store/".$tab);
  $form_attributes = array('class' => 'form actionForm row', 'data-redirect' => get_current_url(), 'method' => "POST");
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $active = [  
    'personal' => 'Personal', 
    'agent' => 'Agent',
    'merchant' => 'Merchant'
  ];
  
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
    
    
  ];
require_once 'common.php';
  
  
?>

<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-sliders"></i> <?=lang("Upay Setup")?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php echo form_open($form_url, $form_attributes); ?>
        <?php echo render_elements_form($general_elements); ?>
        <div id="personal-Upay" class="type-class">
          <label>Upay Personal number</label>
          <input type="text" name="personal_number" class="form-control" value="<?=@get_value($payment_settings->params,'personal_number')?>" placeholder="Enter your Upay number">  
        </div>
        <div id="agent-Upay" class="type-class">
          <label>Upay Agent number</label>
          <input type="text" name="agent_number" value="<?=@get_value($payment_settings->params,'agent_number')?>" class="form-control" placeholder="Enter your agent number">  
        </div>
        <div id="merchant-Upay" class="type-class">
          <label>Upay Merchant ID</label>
          <input type="text" name="merchant_id" value="<?=@get_value($payment_settings->params,'merchant_id')?>" class="form-control"> 
          <label>Upay Merchant Key</label>
          <input type="text" name="merchant_key" value="<?=@get_value($payment_settings->params,'merchant_key')?>" class="form-control">
          <label>Upay Merchant Code</label>
          <input type="text" name="merchant_code" value="<?=@get_value($payment_settings->params,'merchant_code')?>" class="form-control"> 
          <label>Upay Merchant Name</label>
          <input type="text" name="merchant_name" value="<?=@get_value($payment_settings->params,'merchant_name')?>" class="form-control">  
        </div>
        <?=modal_buttons2('Save Upay Setting');?>

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

    $('.my').each(function () {
        $(this).change(function () {
            var dataId = $(this).data('id');
            var contentDiv = $('#' + dataId + '-Upay');

            if ($(this).prop('checked')) {
                contentDiv.show();
            } else {
                contentDiv.hide();
            }
        });

        $(this).change();
    });

  });
</script>