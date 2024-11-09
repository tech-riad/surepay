<?php
  $form_url = admin_url($controller_name."/user_plan_update");
  $redirect_url = admin_url('plans/user_plan');
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'id'   => @$item['id'],
    'expire' =>$item['expire']
  ];

  $class_element = app_config('template')['form']['class_element'];
  

  $general_elements = [
    
    [
      'label'      => form_label('Maximum device (* keep -1 for unlimited device) '),
      'element'    => form_input(['name' => 'device', 'value' => @$item['device'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Website'),
      'element'    => form_input(['name' => 'website', 'value' => @$item['website'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    [
      'label'      => form_label('Number of Expiry Day to be increased from '.$item['expire'].'(NB: Use 0 when you donot need to increase)' ),
      'element'    => form_input(['name' => 'duration', 'type' => 'number', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
  ];
  $data['modal_title']='Edit User Plan';

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

