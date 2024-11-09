<?php
  $form_url = client_url("transactions/add_manual_sms");
  $redirect_url = client_url('transactions');
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor     = app_config('template')['form']['class_element_editor'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  
  $address = [
    '' => 'Select one address...',
    'bkash'  => 'Bkash',
    'NAGAD'  => 'Nagad',
    '16216'  => 'Rocket',
    'upay'  => 'Upay',
    '01730031864'  => 'Cellfin',
    'tap'  => 'Tap',
  ];
  $general_elements = [
    [
      'label'      => form_label('Message Address'),
      'element'    => form_dropdown('address', $address, '', ['class' => $class_element_select]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],    
    [
      'label'      => form_label('Message'),
      'element'    => form_textarea(['name' => 'message','id'=>'ckeditor', 'value' => '', 'class' => $class_element_editor]),
      'class_main' => "col-md-12",
    ],
    
  ];
  $data['modal_title']='Add manually transaction message';

?>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>

        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <input type="hidden" name="add_m" value="ll">
            <?php echo render_elements_form($general_elements); ?>
          </div>
        </div>
        <?=modal_buttons();?>
        <?php echo form_close(); ?>
 <?php $this->load->view('layouts/common/modal/modal_bottom'); ?>

<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 200});

  });
  $('.automatic-selection').select2({
      selectOnClose: true
  });
</script>
