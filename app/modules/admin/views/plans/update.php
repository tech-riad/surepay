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

 $duration_type = [
    '' => 'Select one...',
    '1'  => 'Day',
    '2'  => 'Month',
    '3'  => 'Year',
  ];
  $general_elements = [
    [
      'label'      => form_label('Plans name'),
      'element'    => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Maximum device (* keep -1 for unlimited device) '),
      'element'    => form_input(['name' => 'device', 'value' => @$item['device'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Regular Price'),
      'element'    => form_input(['name' => 'pre_price', 'value' => @$item['pre_price'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Offer Price'),
      'element'    => form_input(['name' => 'price', 'value' => @$item['price'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Maximum Website'),
      'element'    => form_input(['name' => 'website', 'value' => @$item['website'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Duration Type'),
      'element'    => form_dropdown('duration_type', $duration_type, @$item['duration_type'], ['class' => $class_element_select]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Maximum Duration'),
      'element'    => form_input(['name' => 'duration', 'value' => @$item['duration'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
  ];
  if (!empty($item['id'])) {
    $modal_title = 'Edit Plan';
  }else{
    $modal_title = 'Add Plan';
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


<?=script_asset('plugin/jquery-upload/js/vendor/jquery.ui.widget.js');?>
<?=script_asset('plugin/jquery-upload/js/jquery.fileupload.js');?>

<script type="text/javascript">
   //automatic selection
  $('.automatic-selection').select2({
      selectOnClose: true
  });
</script> 