<?php
  $form_url = admin_url($controller_name."/store/");
  $modal_title = 'Edit ' . ucfirst($item['type']);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => admin_url($controller_name), 'method' => "POST");
  $form_hidden = [
    'id'    => @$item['id'],
    'type'  => @$item['type'],
    'payment_params[type]'  => @$item['type']
  ];
  $class_element_select = app_config('template')['form']['class_element_select'];
  $class_element = app_config('template')['form']['class_element'];
  $config_status = app_config('config')['status'];
  $payment_params = json_decode($item['params']);
  $payment_option = @$payment_params->option;
  $payment_mode = @$payment_params->mode;

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 
  $form_new_users = [
    0 => "Not Allowed",
    1 => "Allowed",
  ];
  $form_environment = [
    'live'    => "Live (Product)",
    'sandbox' => "Sandbox (Test)",
  ];
  $currency_type = [
    'USD'    => "USD ($)",
    'BDT' => "BDT (৳)",
  ];
  $general_elements = [
    [
      'label'      => form_label('Method name'),
      'element'    => form_input(['name' => "payment_params[name]", 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Sort'),
      'element'    => form_input(['name' => 'sort', 'value' => @$item['sort'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('payment_params[status]', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Transaction Fee (%)'),
      'element'    => form_input(['name' => 'payment_params[option][tnx_fee]', 'value' => @$payment_option->tnx_fee, 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
  ];

  $data['modal_title']=$modal_title;
?>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>

        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <div class="form-group settings">
            <label class="form-label">Gateway logo</label>
            <div class="input-group">
              <input type="text" name="payment_params[option][logo]" class="form-control" value="<?=isset($payment_option->logo)?$payment_option->logo:''?>">
                <span class="input-group-append">
                  <label for="images">
                    <button class="btn" type="button">
                      <img src="<?=isset($payment_option->logo)?BASE.$payment_option->logo:''?>" height="40" alt="Add an image" onclick="$('#images').trigger('click'); return true;">
                    </button>
                  </label>
                      <input class="settings_fileupload d-none" id="images" type="file" name="files[]" multiple="">
                </span>
                
            </div>
          </div> 
            <?php echo render_elements_form($general_elements); ?>
            <?php /* include 'integrations/'. $item['type'] . '.php'; */ ?>

          </div>
        </div>
        <?=modal_buttons()?>
        <?php echo form_close(); ?>
    </div>
  </div>
</div>

<?=script_asset('plugin/jquery-upload/js/vendor/jquery.ui.widget.js');?>
<?=script_asset('plugin/jquery-upload/js/jquery.fileupload.js');?>

<script type="text/javascript">
   //automatic selection
  $('.automatic-selection').select2({
      selectOnClose: true
  });
</script> 