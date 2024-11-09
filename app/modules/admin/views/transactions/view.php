<?php $this->load->view('layouts/common/modal/modal_top'); ?>

        <div class="modal-body">
          <div class="row">
            Transaction ID: <?=$item->transaction_id?>
            <br>
            Transaction Message: <?=$item->message?>
          </div>
        </div>
<?php $this->load->view('layouts/common/modal/modal_bottom'); ?>
