<div class="row flex-wrap ">
    <div class="col-12 d-flex justify-content-end">
        <div>
            <a href="<?=client_url('transactions/add_manual_sms');?>" class="btn btn-primary ajaxModal" data-confirm_ms=""><i class="fa fa-edit"></i> ADD SMS(If app is closed) </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body table-responsive">
                
                <table id="zero-conf" class="display table" style="width:100%">
                    <?php echo render_table_thead($columns, false, false, false); ?>
                    <tbody>
<?php

if (!empty($items)) {
$link = ($this->uri->segment(3)=='bank_transactions')?'view_bank_transaction/':'view_transaction/';
$i=0;
foreach($items as $item){
$item_payment_type  = show_item_transaction_type($item['type']);
$created            = show_item_datetime($item['created'], 'long');
$item_status        = show_item_status($controller_name, $item['id'], $item['status'], '');
$i++;
?>
                        <tr class="tr_<?php echo $item['id']; ?>">
                          <td><?=$i?></td>
                          <td><?php echo $item_payment_type ; ?></td>
                          <td><?php echo $item['cus_email'] ; ?></td>
                          <td><?php echo $item['transaction_id'] ; ?><a href="<?=client_url('transactions/'.$link.$item['transaction_id'])?>" class="btn btn-sm"><i class="fa fa-eye"></i></a></td>
                          <td><?php echo $item['amount'].$item['currency']; ?></td>
                          <td><?php echo $item_status; ?></td>
                          <td><?php echo $created; ?></td>
                        </tr>

<?php
}
}

?>

                        
                        
                    </tbody>
                    <?php echo render_table_thead($columns, false, false, false); ?>
                    
                </table>
            </div>
        </div>
    </div>
</div>
