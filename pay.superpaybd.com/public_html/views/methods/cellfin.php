<style> :root {--bg1: #388E3C; --bg2: #C8E6C9; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } </style>
<?php
$acc_tp = $this->custom_encryption->decrypt($_GET['acc_tp']);

 if($acc_tp=='personal'){ ?>
<div class="method-text">
 <p>
   আপনার Cellfin অ্যাপে যান।
 </p>
 <p>"Fund Transfer" এ ক্লিক করুন</p>
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
 <p>নিশ্চিত করতে আপনার CELLFIN পিন লিখুন</p>
</div>

<?php }elseif($acc_tp=='agent'){ ?>
<div class="method-text">
 <p>
   আপনার Cellfin অ্যাপে যান।
 </p>
 <p>"Cash Out" এ ক্লিক করুন</p>
 <p>
   নিচে থাকা নাম্বারটি উদ্দোক্তা নাম্বার হিসেবে লিখুন
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
 <p>নিশ্চিত করতে আপনার CELLFIN পিন লিখুন</p>
</div>

<?php }?>

