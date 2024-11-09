<?php
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'id'   => @$item['id'],
  ];
  $config_status = app_config('config')['status'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $general_elements = [
    [
      'label'      => form_label('Domain Name'),
      'element'    => form_input(['name' => 'domain', 'value' => @$item['domain'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Domain IP'),
      'element'    => form_input(['name' => 'ip', 'value' => @$item['ip'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "col-md-6 col-sm-12 col-xs-12",
    ],
    
  ];
  if (!empty($item['id'])) {
    $modal_title = 'Edit Domain';
  }else{
    $modal_title = 'Add Domain';
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
    </div>
  </div>
</div>

<?=script_asset('plugin/tinymce/tinymce.min.js');?>
<script>
  $(document).ready(function() {
    $('.automatic-selection').select2({
          selectOnClose: true
    });
  });
</script>
