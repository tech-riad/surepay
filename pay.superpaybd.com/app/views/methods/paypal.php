<style> :root {--bg1: #ED2730; --bg2: #F7962A; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } </style>

<?php
$acc_tp = $this->custom_encryption->decrypt($_GET['acc_tp']);


 if($acc_tp=='business'){ 
	define('PAYPAL_CURRENCY', 'USD');
	if(get_value($setting['params'],'mode')=='live'){
		define('PAYPAL_URL','https://www.paypal.com/cgi-bin/webscr');
	}else{
		define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
	}
	    
	$payment_url = base_url('checkout/int_complete/'.$setting['g_type'].'/'.$this->encryption->encrypt_data($tmp['all_info']['tmp_ids']) );
	$nopayment_url = base_url('checkout/execute/'.$tmp['all_info']['tmp_ids']);
	$rate=1;
	if (get_option('currency_code')!='USD') {
		$new_currency_rate = get_option('new_currecry_rate');
		if ($new_currency_rate !== null && $new_currency_rate != 0) {
		    $rate = 1 / $new_currency_rate;
		}
		if (get_option('is_auto_currency_convert')=='1') {
			$rate = 1/currency_converter(get_option('currency_code'));
		}
	}
	$amount = $tmp['all_info']['total_amount']*$rate;
	                    
	?>
	        <form action="<?php echo PAYPAL_URL; ?>" method="post" class="form-container price">
	          <!-- Identify your business so that you can collect the payments. -->
	          <input type="hidden" name="business" value="<?=get_value($setting['params'],'business_paypal'); ?>">
	          <!-- Specify a Buy Now button. -->
	          <input type="hidden" name="cmd" value="_xclick">
	          <!-- Specify details about the item that buyers will purchase. -->
	          <input type="hidden" name="amount" value="<?=$amount?>">
	          <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
	          <!-- Specify URLs -->
	          <input type="hidden" name="return" value="<?=$payment_url; ?>">
	          <input type="hidden" name="cancel_return" value="<?=$nopayment_url; ?>">
	        <center><input type="submit" name="submit" id="paypal_button" value="Pay Now" style="display:none;"></center>

	      </form>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

      <script type="text/javascript">
      	$(document).ready(function() {
	      $('#paypal_button').click()
	   });
      </script>
<?php
}else{
?>
<div class="method-text">
 <p>
   Go to the PayPal website by typing WWW.PAYPAL.COM or go to PayPal Apps
   <br>
   "Pay & Send Money" তে ক্লিক করুন
 </p>
 <p>
   Enter this email as recipient email:
   <br />
   <br />
   <span class="d-flex-s">
     <span class="bg2-t"><?=get_value($setting['params'],'personal_paypal')?></span>
     <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'personal_paypal')?>"> Copy !</span>
   </span>
 </p>
 <p class="d-flex-s">
   <span>মোট টাকার পরিমাণ </span>
   <span class="bg2-t"><?=currency_format($tmp['all_info']['total_amount'])?></span>
 </p>
   Select the funding source and click on - <span class="marked_text">Send Money</span>

 <p>Now enter your <span class="marked_text">Transaction ID</span> in the above box and click on the <span class="marked_text">SUBMIT</span> button </p>
</div>

<?php
}
?>
