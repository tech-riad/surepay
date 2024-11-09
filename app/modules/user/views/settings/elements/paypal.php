<?php
  $form_url = client_url($controller_name."/store/".$tab);
  $form_attributes = array('class' => 'form actionForm row', 'data-redirect' => get_current_url(), 'method' => "POST");
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $active = [  
    'personal' => 'Personal', 
    // 'agent' => 'Agent',
    'business' => 'Business'
  ];
  
  $status = [  
    '0' => 'Inactive',
    '1' => 'Active'
  ];
  $mode = [  
    '' => 'Select one...', 
    'sandbox' => 'Sandbox', 
    'live' => 'Live'
  ];
  
    
  $general_elements = [
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $status, @$payment_settings->status, ['class' => $class_element_select]),
      'class_main' => "col-md-4 mb-5",
    ],
    
    
  ];

  $general_elements2 = [
    
    [
      'label'      => form_label('Mode'),
      'element'    => form_dropdown('mode', $mode, @get_value($payment_settings->params,'mode'), ['class' => $class_element_select]),
      'class_main' => "col-md-4 mb-5",
    ],
    
  ];

require_once 'common.php';

  
?>

<div class="card content">
  <div class="card-header">
    <h3 class="card-title"><i class="fe fe-sliders"></i> <?=lang("Paypal Setup")?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php echo form_open($form_url, $form_attributes); ?>
        <?php echo render_elements_form($general_elements); ?>
        <div id="personal-Paypal" class="type-class">
          <label>Paypal Personal number</label>
          <input type="text" name="personal_paypal" class="form-control" value="<?=@get_value($payment_settings->params,'personal_paypal')?>" placeholder="Enter your Paypal account email">  
        </div>
        <div id="business-Paypal" class="type-class">
          <hr>
          <h5>Business Paypal</h5>
          <?php echo render_elements_form($general_elements2); ?>
          <label>Paypal Business Email</label>
          <input type="text" name="business_paypal" value="<?=@get_value($payment_settings->params,'business_paypal')?>" class="form-control" placeholder="Enter your Paypal account email">  
        </div>
        <?=modal_buttons2('Save Paypal Setting','');?>

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
            var contentDiv = $('#' + dataId + '-Paypal');

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