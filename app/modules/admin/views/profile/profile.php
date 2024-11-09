<?php
  $class_element = app_config('template')['form']['class_element'];
  $config_status = app_config('config')['status'];
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 
$elements = [
    [
      'label'      => form_label('First name'),
      'element'    => form_input(['name' => 'first_name', 'value' => @$item['first_name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Last name'),
      'element'    => form_input(['name' => 'last_name', 'value' => @$item['last_name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
    ],
    [
      'label'      => form_label('Email'),
      'element'    => form_input(['name' => 'email', 'value' => @$item['email'], 'type' => 'email', 'readonly' => 'readonly', 'class' => $class_element.' disabled']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ]
  ];

  $elements_change_password = [
    [
      'label'      => form_label('Old Password'),
      'element'    => form_input(['name' => 'old_password', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => 'password',
    ],
    [
      'label'      => form_label('New Password'),
      'element'    => form_input(['name' => 'password', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => 'password',
    ],
    [
      'label'      => form_label('Confirm Password'),
      'element'    => form_input(['name' => 'confirm_password', 'value' => '', 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
      'type'       => 'password',
    ],
  ];
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url('profile');
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids']];
?>
<div class="row">
  <?php
    $form_hidden = ['ids' => @$item['ids'] , 'store_type' => 'update_info'];
  ?>
  <div class="col-md-6">
    <div class="card"> 
      <div class="card-header">
        <h3 class="card-title">Your account</h3>
      </div>
      <div class="card-body">
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
          <div class="form-body">
            
            <div class="settings">
                <input type="text" name="avatar" class="d-none" value="<?=$item['avatar']?>">
                <span class="input-group-append wrapper">
                  <label for="img" class="profile-photo content"> 
                    <img src="<?=get_avatar($item['avatar'])?>" class="img-fluid rounded-circle b-1" alt="" width="120">
                    <span class="myCl text-center"><i class="fas fa-camera"></i></span>
                  </label>
                      <input id="img" class="settings_fileupload d-none" type="file" name="files[]" multiple="">
                    
              </span>
            </div>


            <div class="row">
              <?php echo render_elements_form($elements); ?>
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn1 btn-primary float-end mt-2">Save</button>
          </div>
        <?php echo form_close(); ?>  
      </div>
    </div>
  </div>
  <?php
    $form_hidden = ['ids' => @$item['ids'] , 'store_type' => 'change_pass'];
  ?>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Change your password</h3>
        <div class="card-options">
          <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
          <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
      </div>
      <div class="card-body">
        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
          <div class="form-body">
            <div class="row">
              <?php echo render_elements_form($elements_change_password); ?>
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary float-end mt-2">Save</button>
          </div>
        <?php echo form_close(); ?>  
      </div>
    </div>
  </div> 

</div>