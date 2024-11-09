<?php
  $form_url = client_url($controller_name."/store/".$tab);
  $form_attributes = array('class' => 'form actionForm row', 'data-redirect' => get_current_url(), 'method' => "POST");
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $active = [  
    'personal' => 'Personal', 
    // 'agent' => 'Agent',
    // 'merchant' => 'Merchant'
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
    <h3 class="card-title"><i class="fe fe-sliders"></i> <?=lang("Cellfin Setup")?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php echo form_open($form_url, $form_attributes); ?>
        <?php echo render_elements_form($general_elements); ?>
        <div id="personal-Cellfin" class="type-class">
          <label>Cellfin Personal number</label>
          <input type="text" name="personal_number" class="form-control" value="<?=@get_value($payment_settings->params,'personal_number')?>" placeholder="Enter your Cellfin number">  
        </div>
        <div id="agent-Cellfin" class="d-none type-class">
          <label>Cellfin Agent number</label>
          <input type="text" name="agent_number" value="<?=@get_value($payment_settings->params,'agent_number')?>" class="form-control" placeholder="Enter your agent number">  
        </div>
        <div id="merchant-Cellfin" class="d-none type-class">
          <label>Cellfin Merchant Payment URL</label>
          <input type="text" name="merchant_url" value="<?=@get_value($payment_settings->params,'merchant_url')?>" class="form-control" placeholder="Cellfin Payment URL">  
        </div>
        <?=modal_buttons2('Save Cellfin Setting','');?>

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
            var contentDiv = $('#' + dataId + '-Cellfin');

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