<div class="row">
 

  <div class="col-md-12">


    <div class="card">
      <div class="card-header text-info">
        Refferal Programs
      </div>
      <div class="card-body">
          <div class="form-group mb-2">
            <label class="form-label">Your Refferal Link</label>
              <div class="input-group">
                <input readonly type="text" class="form-control text-to-cliboard" value="<?=base_url('refferal/'.get_current_user_data()->ids)?>" >
                <span class="input-group-text my-copy-btn cursor-pointer myb" ><i class="fas fa-copy"></i></span>
              </div>
          </div>

          <details open>
            <summary class="text-warning">Show Your Lists</summary>
            <p>
              
                  <?php

                    $ref_id = get_current_user_data()->ref_id; 
                    $ref_user = !empty($ref_id)?get_current_user_data($ref_id):'';


                    $this->db->where('ref_id', session('uid'));
                    $res = $this->db->get(USERS)->result_array();
                    if(!empty($res)){
                      foreach($res as $re){
                        $created = show_item_datetime($re['created_at']);
                  ?>
                        <details >
                          <summary><?= $re['email'] ?> <small class="text-warning">Joined at: <?=$created ?> </small> </summary>
                          <p><?=$re['first_name'].' '.$re['last_name'] ?> joined by your link at <?=$created?> </p>
                        </details>
                  <?php
                      }
                      echo "<hr>";
                    }
                  ?>  

            </p>
          </details>

          <h6>Your Parent User : <span class="text-primary"><?=$ref_user->email??'No Parent User Found'?></span></h6>

      </div>
    </div>

  </div> 


</div>
 



<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>

<script type="text/javascript"> 
  $(".my-copy-btn").click(function(){
    let vl = $(this).prev('.text-to-cliboard').val();
    let params = {
            'type': 'text',
            'value': vl,
          };
    copyToClipBoard(params,'toast','Refferal Link Copied Successfully')
  });
</script>