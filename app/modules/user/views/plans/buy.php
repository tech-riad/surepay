<?php
  $form_url = client_url($controller_name."/store/");
  $redirect_url = client_url($controller_name);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'id'   => @$item['id'],
  ];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor = app_config('template')['form']['class_element_editor'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  
  $general_elements = [
    [
      'label'      => form_label('Plan Name'),
      'element'    => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text','readonly'=>'readonly', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],

    [
      'label'      => form_label('Plan Price ('.get_option('currency_symbol').')'),
      'element'    => form_input(['name' => 'price', 'value' => @$item['price'], 'type' => 'text','readonly'=>'readonly', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],

    
  ];
  
  $data['modal_title']='Buy this Plan';

?>
<style type="text/css">
  .coupon{
    display: none;
  }
  .coupon.active{
    display: block;
  }
  .coupon-btn{
    cursor: pointer;
  }
</style>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>

        <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($general_elements); ?>

            <div class="col-md-12 col-sm-12 col-xs-12 coupon">
                <div class="form-group">
                    <label>Add Coupon</label>
                    <input type="text" name="coupon" value="" class="form-control coupon">
                </div>
            </div>
          </div>

          <span class="coupon-btn">Have a coupon? <span class="text-primary">Click here to enter your code</span></span>
        </div>
        <?=modal_buttons('BUY NOW');?>
        <?php echo form_close(); ?>
 <?php $this->load->view('layouts/common/modal/modal_bottom'); ?>
 
<script type="text/javascript">
  $(document).ready(function() {
      $(".coupon-btn").click(function(e) {
          $(".coupon").toggle(); 
      });
  });
</script>