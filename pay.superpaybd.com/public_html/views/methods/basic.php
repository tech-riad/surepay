<style> :root {--bg1: #43A047; --bg2: #C8E6C9; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } #transaction_id,#payment_slip{display: none; } .bank-pay{padding: 15px; margin: 12px; margin-bottom: 0; max-height: 80px; max-width: 100%; } .bank-pay .input{position: relative; padding: 4px; border-radius: 15px; background: #ffffff; max-height: 25px; overflow: hidden; } .bank-pay label{margin-left: 25%; } .bank-pay label:before {position: absolute; top: 0; left: 0; bottom: 0; content: "Choose File"; background: #f2f4f6; padding: 2px; border-radius: 10px; } .method-text p{border: none; } .method-text div{font-family: "bangla",sans-serif;border-bottom: 1px solid #00000014; margin-top: 15px; padding-bottom: 5px; } 
</style> 
<div class="bg2 bank-pay">
    <div class="input">
        <label for="payment_slip">পেমেন্ট স্লিপ আপলোড করুন</label>
        <input type="file"id="payment_slip" name="payment_slip[]">
    </div>
</div>
<div class="method-text">
    <div class="d-flex-s">
        <span class="bg2-t">Account Number: &nbsp;<span style="color:#74848C;font-size: 16px;"><?=get_value($setting['params'],'bank_account_number')?></span></span>
        <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'bank_account_number')?>"> Copy !</span>
    </div>
    <div class="d-flex-s">
        <span class="bg2-t">Account Name: &nbsp;<span style="color:#74848C;font-size: 16px;"><?=get_value($setting['params'],'bank_account_name')?></span></span>
        <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'bank_account_name')?>"> Copy !</span>
    </div>
    <div class="d-flex-s">
        <span class="bg2-t">Branch: &nbsp;<span style="color:#74848C;font-size: 16px;"><?=get_value($setting['params'],'bank_account_branch_name')?></span></span>
        <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'bank_account_branch_name')?>"> Copy !</span>
    </div>
    <div class="d-flex-s">
        <span class="bg2-t">Routing Number: &nbsp;<span style="color:#74848C;font-size: 16px;"><?=get_value($setting['params'],'bank_account_routing_number')?></span></span>
        <span class="copy-btn bg2 text-to-cliboard"  data-value="<?=get_value($setting['params'],'bank_account_routing_number')?>"> Copy !</span>
    </div>
    <div class="d-flex-s" style="font-family: 'bangla';color: #797979;font-weight: 800;">
        <span>মোট টাকার পরিমাণঃ </span>
        <span> <?=currency_format($tmp['all_info']['total_amount'])?></span>
    </div>
</div>    
           
      
<script>
    const fileInput = document.getElementById('payment_slip');
    const label = document.querySelector('label[for="payment_slip"]');

    fileInput.addEventListener('change', (e) => {
        if (fileInput.files.length > 0) {
            label.textContent = fileInput.files[0].name;
        } else {
            label.textContent = 'পেমেন্ট স্লিপ আপলোড করুন';
        }
    });
</script>
