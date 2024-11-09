<?php $this->load->view('layouts/common/modal/modal_top'); ?>

        <div class="modal-body">
          <table class="table table-striped table-sm">
            <tr>
              <td>Transaction ID</td>
              <td><?=@$item->transaction_id?></td>
            </tr>
            <tr>
              <td>Customer Name</td>
              <td><?=@$item->cus_name?></td>
            </tr>
            <tr>
              <td>Customer Email</td>
              <td><?=@$item->cus_email?></td>
            </tr>
            <tr>
              <td>Amount</td>
              <td><?=@$item->amount?></td>
            </tr>
            <tr>
              <td>Transaction Message</td>
              <td><?=@$item->message?></td>
            </tr>
          </table>
        </div>
<?php $this->load->view('layouts/common/modal/modal_bottom'); ?>
