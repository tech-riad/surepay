<style> :root {--bg1: #FAC02E; --bg2: #FFFAC3; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } </style>

<?php
$acc_tp = $this->custom_encryption->decrypt($_GET['acc_tp']);

 if($acc_tp =='personal'){ ?>
<div class="method-text">
 <p>
   *268# ডায়াল করে আপনার UPAY মোবাইল মেনুতে অথবা UPAY অ্যাপে যান।
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
 <p>নিশ্চিত করতে আপনার UPAY পিন লিখুন</p>
</div>

<?php }elseif($acc_tp =='agent'){ ?>
<div class="method-text">
 <p>
   *268# ডায়াল করে আপনার UPAY মোবাইল মেনুতে অথবা UPAY অ্যাপে যান।
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
 <p>নিশ্চিত করতে আপনার UPAY পিন লিখুন</p>
</div>

<?php }elseif($acc_tp =='merchant'){ 
   define('BASE_URL','https://uat-pg.upay.systems/');

   $data = [
       "merchant_id"=> get_value($setting['params'],'merchant_id'),
       "merchant_key"=> get_value($setting['params'],'merchant_key')
      ];

   // Initialize cURL session
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, BASE_URL.'payment/merchant-auth/');
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   $response = curl_exec($ch);
   $response=json_decode($response);
   if (!empty($response) && !empty($token = $response->data->token) ) {
   
      if (isset($_GET['my_init'])) {
         $data = [
             "invoice_id"=> $_GET['invoice_id'],
         ];
         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL, BASE_URL.'payment/single-payment-status/'.$_GET['invoice_id']);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         $headers = [
             'Authorization: UPAY ' . $token,
         ];
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
         $response = curl_exec($ch);

         if (curl_errno($ch)) {
             echo 'cURL error: ' . curl_error($ch);
         }

         curl_close($ch);

         $response=json_decode($response);
         if(!empty($response->data->status) && $response->data->status=='success'){
            redirect(base_url('request/complete/upay/'.$this->encryption->encrypt_data($tmp['all_info']['tmp_ids'] )));
         }else{
            redirect(base_url('request/execute/'.$tmp['all_info']['tmp_ids']));
         }


      }
      $id = ids();

      $data = [
         "date" => date("Y-m-d"),
         "txn_id" => $id,
         "invoice_id" => $id,
         "amount" => (int)$tmp['all_info']['total_amount'],
         "merchant_id"=> get_value($setting['params'],'merchant_id'),
         "merchant_name"=> get_value($setting['params'],'merchant_name'),
         "merchant_code"=> get_value($setting['params'],'merchant_code'),
         "merchant_country_code"=> 'BD',
         "merchant_city"=> 'Dhaka',
         "merchant_mobile"=> '01756348921',
         "transaction_currency_code"=> 'BDT',
         "redirect_url"=> current_url().'?my_init=upay',
         "merchant_category_code"=> get_value($setting['params'],'merchant_code'),
         "merchant_key"=> get_value($setting['params'],'merchant_key')
      ];
      curl_setopt($ch, CURLOPT_URL, BASE_URL.'payment/merchant-payment-init/');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      $headers = [
          'Authorization: UPAY ' . $token, 
      ];
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

      $response = curl_exec($ch);

      if (curl_errno($ch)) {
          echo 'cURL error: ' . curl_error($ch);
      }

      curl_close($ch);

      $response=json_decode($response);
      
      if (!empty($response) ) {
         redirect($response->data->gateway_url);
      }
      echo "<p style='color:red'>Gateway Configuration error</p>";

      
   }else{
      echo "<p style='color:red'>Gateway Configuration error</p>";
   }

   


} ?>