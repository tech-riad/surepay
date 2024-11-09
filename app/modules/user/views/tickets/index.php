<section class="page-title">
  <div class="row justify-content-between">
    <div class="col-md-6">
      <h1 class="page-title d-flex">
        <a href="<?=cn('user/'.$controller_name . "/add")?>" class="d-inline-block d-sm-none ajaxModal"><span class="add-new" data-bs-toggle="tooltip" data-bs-placement="bottom" title="<?=lang("add_new")?>" data-original-title="Add new"><i class="fas fa-plus text-primary" aria-hidden="true"></i></span></a> 
      </h1>
    </div>    
  </div>
</section>

<?php
  $class_element_select = app_config('template')['form']['class_element_select'];

  $class_element = app_config('template')['form']['class_element'];
  $result = [];
  foreach($form_payments as $row){
    $result[$row->type] = $row->name;
  }
  $form_subjects = [
    'subject_payment' => 'Payment',
    'invoice' => 'Invoice',
    'gateway_setup' => 'Gateway Setup',
    'subject_other'   => 'Other',
  ];
  
  $form_payments = $result;

  $elements = [
    [
      'label'      => form_label(lang('Subject')),
      'element'    => form_dropdown('subject', $form_subjects, '', ['class' => $class_element_select . ' ajaxChangeTicketSubject']),
      'class_main' => "col-md-12 col-sm-12 col-xs-12",
    ],
    
    [
      'label'      => form_label(lang('Payment')),
      'element'    => form_dropdown('payment', $form_payments, '', ['class' => $class_element_select]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-payment",
    ],
    [
      'label'      => form_label(lang('Transaction_ID')),
      'element'    => form_input(['name' => 'transaction_id', 'value' => '', 'placeholder' => lang("enter_the_transaction_id"),'type' => 'text', 'class' => $class_element]),
      'class_main' => "col-md-12 col-sm-12 col-xs-12 subject-payment",
    ],
    
    [
      'label'      => form_label(lang("Description")),
      'element'    => form_textarea(['name' => 'description','rows'=>'3', 'value' => '', 'class' => $class_element]),
      'class_main' => "col-md-12",
    ],
  ];
  $form_url     = cn('user/'.$controller_name. "/store/");
  $redirect_url = cn('user/'.$controller_name) ;
  $form_attributes = ['class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST"];
?>

<div class="row justify-content-end">
  <div class="col-md-5 d-none d-sm-block">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <h4 class="modal-title"><i class="fas fa-edit"></i> <?=lang("add_new_ticket")?></h4>
        </h3>
      </div>

      <div class="card-body o-auto" style="height: calc(100vh - 250px);">
        <?php echo form_open($form_url, $form_attributes); ?>
          <div class="form-body" id="add_new_ticket">
            <div class="row justify-content-md-center">
              <?php echo render_elements_form($elements); ?>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary btn-min-width mt-1 mb-1 float-end"><?=lang('Submit')?></button>
              </div>
            </div>
          </div>
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
  <div class="col-md-7">
    <div class="row" id="result_ajaxSearch">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"> <?=lang("Lists")?></h3>
          </div>
          <div class="card-body o-auto" style="height: calc(100vh - 250px);">
            <?php if(!empty($items)){?>
              <div class="ticket-lists">
                <?php
                  foreach ($items as $key => $item) {
                    $this->load->view('child/index', ['controller_name' => $controller_name, 'item' => $item]);
                  }
                ?>
              </div>
            <?php }else{
              echo show_empty_item();
            }?>  
          </div>
        </div>
      </div>
      <?php echo show_pagination($pagination); ?> 
    </div>
  </div>
</div>
<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>
 
<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 100});
    $('.automatic-selection').select2({
          selectOnClose: true
    });
  });
</script>