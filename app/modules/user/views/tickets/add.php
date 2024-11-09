
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
  $data['modal_title'] = 'Add Ticket';
?>
<?php $this->load->view('layouts/common/modal/modal_top',$data); ?>
        <?php echo form_open($form_url, $form_attributes); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?php echo render_elements_form($elements); ?>
          </div>
        </div>
        <?=modal_buttons();?>
        <?php echo form_close(); ?>
<?php $this->load->view('layouts/common/modal/modal_bottom'); ?>

 
<script>
  $(document).ready(function() {
    plugin_editor('.plugin_editor', {height: 100});
    $('.automatic-selection').select2({
          selectOnClose: true
    });
  });
        $(document).on("change", ".ajaxChangeTicketSubject", function(){
            event.preventDefault();
            var element   = $(this);
            var type    = element.val();
            switch(type) {

              case "subject_order":
                $(".subject-order").removeClass("d-none");
                $(".subject-payment").addClass("d-none");
                break;  
                              
              case "subject_payment":
                $(".subject-order").addClass("d-none");
                $(".subject-payment").removeClass("d-none");
                break;

              default:
                $(".subject-order").addClass("d-none");
                $(".subject-payment").addClass("d-none");
                break;
            }
        })
</script>