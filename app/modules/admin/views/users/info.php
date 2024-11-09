<?php
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  
  $elements = [
    [
      'label'      => form_label('Last History'),
      'element'    => form_input(['name' => 'history_ip', 'value' => @$item['history_ip'], 'type' => 'text', 'readonly'=>'true', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
    
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
  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'More Informations (' . $item['email'] . ')';
  }
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'email','query' => $item['email']]);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids'], 'store_type' => 'user_information'];

  $data['modal_title']=$modal_title;
?>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>

        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row">
            <?php echo render_elements_form($elements); ?>
            <div class="col-md-6">
              <div class="form-group settings">
                <label>Business Logo</label>
                <input type="text" name="business_logo" class="d-none" value="<?=get_value($item_infor, 'business_logo')?>">
                <span class="input-group-append wrapper">
                    <label for="img" class="profile-photo content"> 
                      <img src="<?=get_value($item_infor, 'business_logo')?>" class="img-fluid rounded-circle b-1" alt="No Image" width="120">
                      <span class="myCl text-center"><i class="fas fa-camera"></i></span>
                    </label>
                    <input id="img" class="settings_fileupload d-none" type="file" name="files[]" multiple="">
                      
                </span>
              </div>
            </div>
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