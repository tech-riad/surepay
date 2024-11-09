<?php
  $class_element = app_config('template')['form']['class_element'];
  $config_status = app_config('config')['status'];
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status); 
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name')); 

  $item_infor = $item['more_information'];
 

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
    ],
  ];
  $elements2 = [
    [
      'label'      => form_label('Business Name'),
      'element'    => form_input(['name' => 'business_name', 'value' => @get_value($item_infor, 'business_name'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
      'type'       => 'password',
    ],
    [
      'label'      => form_label('Business Email'),
      'element'    => form_input(['name' => 'business_email', 'value' => @get_value($item_infor, 'business_email'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
      'type'       => 'password',
    ],
    [
      'label'      => form_label('Website'),
      'element'    => form_input(['name' => 'website', 'value' => @get_value($item_infor, 'website'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-6",
      'type'       => 'password',
    ],
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
  $form_url = client_url($controller_name."/store/");
  $redirect_url = client_url('profile');
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
                    <img src="<?=get_avatar($item['avatar'],'user')?>" class="img-fluid rounded-circle b-1" alt="" width="120">
                    <span class="myCl text-center"><i class="fas fa-camera"></i></span>
                  </label>
                      <input id="img" class="settings_fileupload d-none" type="file" name="files[]" multiple="">
                    
              </span>
            </div>


            <div class="row mb-3">
              <?php echo render_elements_form($elements); ?>
            </div>
            <hr>
            <div class="row">
              <?php echo render_elements_form($elements2); ?>
              <div class="col-md-6">
              <div class="form-group settings">
                <label>Business Logo</label>
                <input type="text" name="business_logo" class="d-none" value="<?=get_value($item_infor, 'business_logo')?>">
                <span class="input-group-append wrapper">
                    <label for="img2" class="profile-photo content"> 
                      <img src="<?=PATH.get_value($item_infor, 'business_logo')?>" class="img-fluid rounded-circle b-1" alt="No Image" width="120" style="min-height: 80px;">
                      <span class="myCl text-center"><i class="fas fa-camera"></i></span>
                    </label>
                    <input id="img2" class="settings_fileupload d-none" type="file" name="files[]" multiple="">
                      
                </span>
              </div>
            </div>
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

    <div class="card">
      <div class="card-header text-info">
        Refferal
      </div>
      <div class="card-body">
          <div class="form-group mb-2">
            <label class="form-label">Your Refferal Link</label>
              <div class="input-group">
                <input readonly type="text" class="form-control text-to-cliboard" value="<?=base_url('refferal/'.get_current_user_data()->ids)?>" >
                <span class="input-group-text my-copy-btn cursor-pointer myb" ><i class="fas fa-copy"></i></span>
              </div>
          </div>

          <details>
            <summary class="text-warning">Show Your Lists</summary>
            <p>
              
                  <?php

                    $ref_id = get_current_user_data()->ref_id; 
                    $ref_user = !empty($ref_id)?get_current_user_data($ref_id):'';


                    $this->db->where('ref_id', session('uid'));
                    $res = $this->db->get(USERS)->result_array();
                    if(!empty($res)){
                      foreach($res as $re){
                        $created = show_item_datetime($re['created_at']);
                  ?>
                        <details>
                          <summary><?= $re['email'] ?> <small class="text-warning">Joined at: <?=$created ?> </small> </summary>
                          <p><?=$re['first_name'].' '.$re['last_name'] ?> joined by your link at <?=$created?> </p>
                        </details>
                  <?php
                      }
                      echo "<hr>";
                    }
                  ?>  

            </p>
          </details>

          <h6>Your Parent User : <span class="text-primary"><?=@$ref_user->email?></span></h6>

      </div>
    </div>

  </div> 


</div>
 



<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>

<script type="text/javascript"> 
  $(".my-copy-btn").click(function(){
    let vl = $(this).prev('.text-to-cliboard').val();
    let params = {
            'type': 'text',
            'value': vl,
          };
    copyToClipBoard(params,'toast','Refferal Link Copied Successfully')
  });
</script>