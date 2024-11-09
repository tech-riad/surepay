
<style>
  .page-title h1{margin-bottom: 5px; } .page-title .border-line {height: 5px; width: 270px; background: #eca28d; background: -webkit-linear-gradient(45deg, #eca28d, #f98c6b) !important; background: -moz- oldlinear-gradient(45deg, #eca28d, #f98c6b) !important; background: -o-linear-gradient(45deg, #eca28d, #f98c6b) !important; background: linear-gradient(45deg, #eca28d, #f98c6b) !important; position: relative; border-radius: 30px; } .page-title .border-line::before {content: ''; position: absolute; left: 0; top: -2.7px; height: 10px; width: 10px; border-radius: 50%; background: #fa6d7e; -webkit-animation-duration: 6s; animation-duration: 6s; -webkit-animation-timing-function: linear; animation-timing-function: linear; -webkit-animation-iteration-count: infinite; animation-iteration-count: infinite; -webkit-animation-name: moveIcon; animation-name: moveIcon; } @-webkit-keyframes moveIcon {from {-webkit-transform: translateX(0); } to {-webkit-transform: translateX(215px); } } 
</style>

<?php $data['modal_title']=''; $this->load->view('layouts/common/modal/modal_top',$data); ?>

<?php
  if (!empty($payments) ){
?>
<section class="add-funds m-t-30">   
  <div class="container-fluid">
    <div class="row justify-content-md-center" id="result_ajaxSearch">
      <div class="col-md-8">
        <div class="card">
          
          <div class="card-body">
            <div class="tab-content">
<?php
  $option           = get_value($payments->params, 'option');
  $min_amount       = get_value($payments->params, 'min');
  $max_amount       = get_value($payments->params, 'max');
  $type             = get_value($payments->params, 'type');
  $tnx_fee          = get_value($option, 'tnx_fee');
?>

<div class="add-funds-form-content">
  <form class="form actionAddFundsForm" action="#" method="POST">
    <div class="row">
      <div class="col-md-12">
        <div class="for-group text-center">
          <img src="<?=BASE.get_value($option, 'logo')?>" alt="<?=$payments->name?>" width="160">
          <p class="p-t-10"><small><?=lang("deposit_via_".$payments->name."_will_be_added_into_your_account")?></small></p>
        </div>

        <div class="form-group">
          <input class="form-control square" type="number" name="amount" placeholder="<?php echo $min_amount; ?>">
        </div>                      

        <div class="form-group mt-2">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="agree" value="1">
            <span class="custom-control-label text-uppercase"><strong>I understand that after adding the funds, I will not make fraudulent disputes or chargebacks.</strong></span>
          </label>
        </div>
        
        <div class="form-actions left">
          <input type="hidden" name="payment_id" value="<?=$payments->id; ?>">
          <input type="hidden" name="payment_method" value="<?=$payments->type; ?>">
          <button type="submit" class="btn round btn-primary btn-min-width mr-1 mb-1">
            <?=lang("Pay")?>
          </button>
        </div>
      </div>  
    </div>
  </form>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php }; ?>

<?php $this->load->view('layouts/common/modal/modal_bottom'); ?>

