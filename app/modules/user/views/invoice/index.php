                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body table-responsive">

                                <table id="zero-conf" class="display table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Email</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if (!empty($items)) {
                                            $i=0;
                                            foreach($items as $item){
                                            $item_status        = show_item_status($controller_name, $item['id'], $item['status'], 'switch','','merchant');
                                            $show_item_buttons  = show_item_button_action($controller_name, $item['id'],'','','merchant');
                                            $i++;
                                            ?>
                                                                                <tr class="tr_<?=$item['ids']?>">
                                                                                    <td><?=$i?></td>
                                                                                    <td><?=$item['customer_email']?></td>
                                                                                    <td><?=$item['customer_amount']?> <span
                                                                                            class="badge bg-info"><?=$item['pay_status']==1?'Paid':'Unpaid'?><?php if(!empty($item['transaction_id'] )) {?>
                                                                                            <q class="text-dark"><?=$item['transaction_id']?></q>
                                                                                            <?php } ?></span> </td>
                                                                                    <td><?=$item_status?></td>
                                                                                    <td><?= show_item_datetime($item['created'], 'short'); ?></td>
                                                                                    <td><?=$show_item_buttons?></td>
                                                                                </tr>

                                                                                <?php
                                            }
                                        }

                                        ?>



                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Customer Email</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>