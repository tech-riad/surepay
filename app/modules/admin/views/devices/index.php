<?php 
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<div class="row">
  <?php if(!empty($items)){
  ?>
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="card-header">
            <h3 class="card-title"><?=lang("Lists")?></h3>
            
          </div>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-vcenter card-table">
              <?php echo render_table_thead($columns); ?>
              <tbody>
                <?php if (!empty($items)) {
                  $i = $from;
                  foreach ($items as $key => $item) {
                    $i++;
                    $item_checkbox      = show_item_check_box('check_item', $item['id']);
                    $show_item_buttons  = show_item_button_action($controller_name, $item['id']);
                ?> 
                  <tr class="tr_<?=$item['id']?>">
                    <th class="text-center"><?php echo $item_checkbox; ?></th>
                    <td class="text-center text-muted w-5p"><?=$i?></td>
                    <td class="text-center text-muted w-5p"><?=$item['email']?></td>
                    <td class="text-center w-5p"><?=$item['device_name'].show_device_status($item['device_key'],$item['uid']);?></td>
                    <td class="text-center w-5p"><?= $item['device_key']; ?></td>
                    <td class="text-center w-5p"><?= $item['device_ip'];?></td>
                    <td class="text-center w-5p"><?php echo $show_item_buttons; ?></td>
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
