<?php
   $item_infor = $items['more_information'];
   $img = !empty(get_domain_data($items['domain'],$items['user_id'])->brand_logo)?get_domain_data($items['domain'],$items['user_id'])->brand_logo:get_value($item_infor,'business_logo');
?> 
<!DOCTYPE html> 
<html>
   <head>
      <meta charset="utf-8" />
      <title>Invoice of <?=get_option('business_name') ?> to <?=$items['customer_name']?></title>
      <link rel="shortcut icon" type="image/x-icon" href="<?=base_url($img)?>">

      <style>
         @media print {body {-webkit-print-color-adjust: exact; /* For Chrome and Safari */ background-image: initial !important; /* Override any background-image property */ } } .invoice-box {max-width: 800px; height: 842px; overflow: hidden; margin: auto; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #000000; } p{font-size: 14px; } p b{font-weight: 550 !important; color: #66686d; } tr th{font-size: 18px; border: none !important; } .border-table td{border: 1px solid #F5EEEE; text-align: center; } .btn{display: inline-block; margin-bottom: 0; font-weight: 400; text-align: center; white-space: nowrap; vertical-align: middle; -ms-touch-action: manipulation; touch-action: manipulation; cursor: pointer; background-image: none; border: 1px solid transparent; padding: 6px 12px; font-size: 14px; line-height: 1.42857143; border-radius: 4px; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; color: #333; text-decoration: none; background-color: #fff; border-color: #ccc; } .print-btn{position: fixed; bottom: 10px; right: 10px; } @media print {.no-print, .no-print * {display: none !important; } } .watermark {max-width: 120px; height: 120px; margin: auto; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #000000; position: relative;margin-top: 50px; background-image: url(<?=base_url($img)?>); background-repeat: repeat; background-size: cover; /* Adjust the size as needed */ opacity: .2; /* Adjust the opacity as needed */ }

      </style>
   </head>

   <body>
      <div class="invoice-box" >
         <div class="invoice-top" style="background-size: cover;height: 160px;background-image: url('<?=base_url("assets/images/website/invoice.jpg")?>');text-align: right;padding: 20px;">
            <h1>INVOICE</h1>
            
         <?php
            if ($items['pay_status']==1) { ?>
            <h3>Payment Status:<span style="color: blue;">Paid</span></h3>
         <?php }else{?>
            <h3>Payment Status:<span style="color: wheat;">Unpaid</span></h3>
            <a class="btn no-print" style="background:wheat;" onclick="location.href='?start_payment=<?=$items['ids']?>'">Pay Now</a>
         <?php } ?>
         </div>
         <div class="invoice-bottom" style="padding:0 20px;">
            <div style="display: flex;margin: 10px;">
               <div class="biller" style="width:50%;line-height: 7px;">
                  <h2>BILL TO</h2>
                  <p><b><?=$items['customer_name']?></b></p>
                  <p><b><?=$items['customer_number']?></b></p>
                  <p><b><?=$items['customer_email']?></b></p>                   
               </div>
               <div class="invoice" style="width:50%;" >
               <!-- <div class="invoice" style="width:50%;display:flex;"> -->
                  <table style="width:100%">
                     <tr>
                        <th style="text-align:left;">INVOICE</th>
                        <td style="text-align: right;"><span  style="box-shadow: 1px 1px 2px #fff;width: 100%;">#<?=$items['ids']?></span></td>
                     </tr>
                     <tr>
                        <th style="text-align:left;">Creation Date</th>
                        <td style="text-align: right;"><?=$items['created']?></td>
                     </tr>
                     <tr>
                        <th style="text-align:left;">Billers</th>
                        <td style="text-align: right;">
               <address class="small-text">
                  <img src="<?=base_url($img)?>" width="60px">
                     <br>

                  <b><?=!empty(get_domain_data($items['domain'],$items['user_id'])->brand_name)?get_domain_data($items['domain'],$items['user_id'])->brand_name: get_value($item_infor,'business_name')?></b><br>
                  Email: <?=!empty(get_domain_data($items['domain'],$items['user_id'])->support_mail)?get_domain_data($items['domain'],$items['user_id'])->support_mail: get_value($item_infor,'business_email')?>   <br>
               </address>

                        </td>
                     </tr>
                  </table>
               </div>
            </div> 

            <table style="width: 100%;border-spacing: 0px;">
               <tr style="background:#A65B59;color: #FFFFFF;height: 40px;">
                  <th width="50%;" style="text-align:left;"><span style="margin-left: 5px;">DESCRIPTION</span></th>
                  <th width="15%">QTY</th>
                  <th width="15%">PRICE</th>
                  <th width="20%">AMOUNT</th>
               </tr>
               <tr style="height: 40px;" class="border-table">
                  <td style="text-align:left;"><p style="margin-left:4px;"><?=$items['customer_description']?></p></td>                  
                  <td>1</td>                  
                  <td><?=$items['customer_amount']?><?=get_option('currency_symbol')?></td>                  
                  <td><?=$items['customer_amount']?><?=get_option('currency_symbol')?></td>                  
               </tr>
               <tr style="height:35px; color: #ffffff;">
                  <td></td>
                  <td></td>
                  <th style="background:#A65B59">Total Price</th>
                  <th style="background:#A65B59"><?=$items['customer_amount']?><?=get_option('currency_symbol')?></th>
               </tr>
            </table> 

         </div>
         <div class="watermark"></div>

         <a href="javascript:window.print()" class="btn print-btn no-print">
               <svg xmlns="http://www.w3.org/2000/svg" style="width: 18px;height: 18px;margin-bottom: -5px;" viewBox="0 0 24 24"><path fill="currentColor" d="M16 8V5H8v3H6V3h12v5ZM4 10h16H6Zm14 2.5q.425 0 .712-.288q.288-.287.288-.712t-.288-.713Q18.425 10.5 18 10.5t-.712.287Q17 11.075 17 11.5t.288.712q.287.288.712.288ZM16 19v-4H8v4Zm2 2H6v-4H2v-6q0-1.275.875-2.137Q3.75 8 5 8h14q1.275 0 2.138.863Q22 9.725 22 11v6h-4Zm2-6v-4q0-.425-.288-.713Q19.425 10 19 10H5q-.425 0-.713.287Q4 10.575 4 11v4h2v-2h12v2Z"/></svg>
               Print
         </a>
      </div>
   </body>
</html>