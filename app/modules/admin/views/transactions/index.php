<?php
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<div class="row">
  <?php if(!empty($items)){ 
  ?>
    <div class="col-md-12 col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="card-header">
            <h3 class="card-title"><?=lang("Lists")?></h3>
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-vcenter card-table">
              <?php echo render_table_thead($columns, false, false, false); ?>
              <tbody>
                <?php if (!empty($items)) {
                  $i = $from;
                  foreach ($items as $key => $item) {
                    $i++;
                    $item_payment_type  = show_item_transaction_type($item['type']);
                    $created            = show_item_datetime($item['created'], 'long');
                    $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '', 'user'); 
                ?>
                  <tr class="tr_<?php echo $item['id']; ?>">
                    <td class="text-center w-5p text-muted"><?=$i?></td>
                    <td class="text-center w-10p"><?=@get_current_user_data($item['uid'])->email?></td>
                    <td class="text-center w-10p"><?php echo $item['cus_email'] ; ?></td>
                    <td class="text-center w-10p"><?php echo $item_payment_type ; ?></td>
                    <td class="text-center w-10p"><?php echo $item['transaction_id'] ; ?><a href="<?=admin_url($controller_name.'/view_transaction/'.$item['id'])?>" class="btn btn-sm ajaxModal"><i class="fa fa-eye"></i></a></td>
                    <td class="text-center w-10p"><?php echo $item['amount'].$item['currency']; ?></td>
                    <td class="text-center w-5p text-muted"><?php echo $created; ?></td>
                  </tr>
                <?php }}?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php echo show_pagination($pagination); ?>
  <?php }else{
    echo show_empty_item();
  }?>
</div>
