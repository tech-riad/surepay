<div class="row">
    <div class="col">
      <div class="card">
          <div class="card-body">
              <div class="row">
    <?php if(!empty($plans)){
      foreach($plans as $plan){
        $active = get_active_plan($plan['id']);
        ?>

                  <div class="col-sm-12 col-md-3 m-b-sm">
                    <ul class="list-group io-pricing-table">
                        <li class="list-group-item" >
                            <h3><?=$plan['name']?><?php if($active){?><span class="btn btn-success">Active</span><?php }?> </h3>
                        </li>
                        <li class="list-group-item"><?=$plan['website']?> Websites</li>
                        <li class="list-group-item"><?=$plan['device']==-1?'Unlimited':$plan['device']?> Device</li>
                        <li class="list-group-item">
                            <h5 class="text-danger"><strike><?=get_option('currency_symbol')?><?=!empty($plan['pre_price'])?$plan['pre_price']: ($plan['price']+20)?></strike></h5>
                            <h3><?=get_option('currency_symbol')?><?=$plan['price']?></h3>
                            <span><?= duration_type($plan['name'],$plan['duration_type'],$plan['duration']) ?></span>
                        </li>
                        <li class="list-group-item">                            
                            <a class="btn btn-primary ajaxModal" href="<?=client_url('plans/buy/'.$plan['id'])?>"><?= $active?'BUY AGAIN': 'BUY NOW'?></a>
                        </li>
                      </ul>

                  </div>
    <?php } ?>
    <?php }else{
      echo show_empty_item();
    }?>

              </div>
          </div>
      </div>
    </div>
</div>

