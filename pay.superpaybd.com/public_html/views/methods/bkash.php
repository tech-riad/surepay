<style> :root {--bg1: #cf2772; --bg2: #f9bbd0; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } </style>

<?php
$acc_tp = $this->custom_encryption->decrypt($_GET['acc_tp']);

 if($acc_tp=='personal'){ ?>

<div class="method-text">
 <p>
   *247# ডায়াল করে আপনার BKASH মোবাইল মেনুতে অথবা BKASH অ্যাপে যান।
 </p>
 <p>"Send Money" তে ক্লিক করুন</p>
 <p>
   নিচে থাকা নাম্বারটি প্রাপক নাম্বার হিসেবে লিখুন
   <br />
   <br />
   <span class="d-flex-s">
     <span class="bg2-t"><?=get_value($setting['params'],'personal_number')?></span>
     <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'personal_number')?>"> Copy !</span>
   </span>
 </p>
 <p class="d-flex-s">
   <span>মোট টাকার পরিমাণ </span>
   <span class="bg2-t"><?=currency_format($tmp['all_info']['total_amount'])?></span>
 </p>
 <p>নিশ্চিত করতে আপনার BKASH পিন লিখুন</p>
</div>

<?php }elseif($acc_tp=='agent'){ ?>

<div class="method-text">
 <p>
   *247# ডায়াল করে আপনার BKASH মোবাইল মেনুতে অথবা BKASH অ্যাপে যান।
 </p>
 <p>"Cash Out"-এ ক্লিক করুন</p>
 <p>
   নিচে থাকা নাম্বারটি এজেন্ট নাম্বার হিসেবে লিখুন
   <br />
   <br />
   <span class="d-flex-s">
     <span class="bg2-t"><?=get_value($setting['params'],'agent_number')?></span>
     <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'agent_number')?>"> Copy !</span>
   </span>
 </p>
 <p class="d-flex-s">
   <span>মোট টাকার পরিমাণ </span>
   <span class="bg2-t"><?=currency_format($tmp['all_info']['total_amount'])?></span>
 </p>
 <p>নিশ্চিত করতে আপনার BKASH পিন লিখুন</p>
</div>

<?php }elseif($acc_tp=='merchant'){
   function RemoveSpecialChar($str) {
       $res = str_replace( array( 'https://shop.bkash.com/', '/paymentlink' ), '', $str);
       return $res;
   }

   $payment_lin = RemoveSpecialChar(get_value($setting['params'],'merchant_url'));
   
   $total_amount = (int)$tmp['all_info']['total_amount'];
 ?>
<style type="text/css">
  #transaction_id{
    display: none;
  }
  .container-m{
    position: unset;
    transform: unset;
  }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
    <!-- Function to show the bKash merchant wrapper and the iframe -->
<button id="bKash_button" style="display:none;">Pay with bKash</button>

<script type="text/javascript">
   var token = '<?php echo strip_tags($this->security->get_csrf_hash()); ?>';

   var paymentID = '<?=$tmp['all_info']['tmp_ids']?>';
   var transactionId ="<?=$tmp['all_info']['transaction_id']?>";
   var paymentRequest = {
           intent: "sale",
           basePath: "<?php echo $payment_lin?>",
           urlFragment: "paymentlink",
           trxType: "AMOUNT",
           amount: <?php echo $total_amount?>,
           "price": <?php echo $total_amount?>,
           packageName: "Customer Provided Amount",
           quantity: 0,
           customerName: "Uniquepay Gateway",
           customerPhoneNumber: "",
           customerEmail: "",
           customerReference: transactionId,
           customerAddress: "",
           customerMembershipId: "",
           customerBillMonth: "",
           useWalletAsContact: true
      };

   bKash.init({ 
      paymentMode: 'checkout', 
      paymentRequest: paymentRequest, 
      createRequest: function(request) { 
        $.ajax({ 
          url: "https://cpp.bka.sh/customer-portal-middleware/create-payment", 
          type: "POST", 
          contentType: "application/json",
         data: JSON.stringify(paymentRequest),    
          success: function(data) { 
            
            if (data && data.paymentID != null) { 
              paymentID = data.paymentID; 
              transactionId = data.transactionId; 
              bKash.create().onSuccess(data);
            } else { 
              bKash.create().onError(); 
            } 
          }, 
          error: function() { 
            bKash.create().onError(); 
          } 
        }); 
      },
     executeRequestOnAuthorization: function() { 
       $.ajax({ 
         url: "https://cpp.bka.sh/customer-portal-middleware/execute-payment", 
         type: "POST", 
         contentType: "application/json", 
         data: JSON.stringify({ 
            "transactionId": transactionId 
         }),
         success: function(data) { 
            $.ajax({type:"POST",url:"<?=base_url('request/auto_payment/bkash')?>",data:{token:token,id:"<?=$tmp['all_info']['tmp_ids'];?>"},success:function(a){window.location.href=a}});
         }, 
         error: function() { 
            bKash.execute().onError(); 
         }  
       }); 
     } 
   });

   $(document).ready(function() {
      $('#bKash_button').click()
   })
</script>

<?php } ?>

