<?php $this->load->view('layouts/common/modal/modal_top'); ?>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <?=strtoupper($item->type)?>
           <iframe src="<?=$item->files?>" style="border: none;  height: 70vh;"></iframe>
          </div>
        </div>
<?php
    $form_url = client_url($controller_name."/view_bank_transaction/".$id);
    $redirect_url = client_url('transactions/bank_transactions');
    $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
    
?>

    <?= form_open($form_url, $form_attributes); ?>

      <div class="modal-footer">
        <input type="hidden" name="k_status" value="">
        <button type="submit" onclick="this.form.k_status.value=this.value" class="btn btn-primary btn-min-width mr-1 mb-1" value="1">Verify Now</button>
        <button type="submit" onclick="this.form.k_status.value=this.value" class="btn btn-danger btn-min-width mr-1 mb-1" value="-1">Cancel Now</button>
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
      </div>
    <?php echo form_close(); ?>
     
    </div>
  </div>
</div>

