<?php
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'id'   => @$item['id'],
    'type' =>'edit'
  ];
  $config_status = app_config('config')['status'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor = app_config('template')['form']['class_element_editor'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $coupon_type = [  
    '0' => 'Fixed', 
    '1' => 'Percent'
  ];
  
  $general_elements = [
    [
      'label'      => form_label('Code'),
      'element'    => form_input(['name' => 'code', 'value' => @$item['code'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Limit'),
      'element'    => form_input(['name' => 'times', 'value' => @$item['times'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-6 col-xs-12",
    ],
    [
      'label'      => form_label('Price'),
      'element'    => form_input(['name' => 'price', 'value' => @$item['price'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-6 col-xs-12",
    ],
    [
      'label'      => form_label('Start Date'),
      'element'    => form_input(['name' => 'start_date', 'value' => @$item['start_date'], 'type' => 'date', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('End Date'),
      'element'    => form_input(['name' => 'end_date', 'value' => @$item['end_date'], 'type' => 'date', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Type'),
      'element'    => form_dropdown('type', $coupon_type, @$item['type'], ['class' => $class_element_select]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Description'),
      'element'    => form_textarea(['name' => 'description', 'value' => @$item['description'], 'class' => $class_element_editor]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
  ];
  if (!empty($item['id'])) {
    $modal_title = 'Edit Coupon';
  }else{
    $modal_title = 'Add Coupon';
  }
  $data['modal_title']=$modal_title;

?>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>

        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($general_elements); ?>
          </div>
        </div>
        <?=modal_buttons();?>
        <?php echo form_close(); ?>
 <?php $this->load->view('layouts/common/modal/modal_bottom'); ?>


<?=script_asset('plugin/tinymce/tinymce.min.js');?>
<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 100});
    $('.automatic-selection').select2({
          selectOnClose: true
      });
  });
</script>
