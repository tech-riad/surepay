<div class="user-form-area">
   <div class="container-fluid p-0">
      <div class="row m-0">
         <div class="col-lg-6 p-0">
            <div class="user-img">
               <img src="<?=base_url()?>assets/img/user-form-bg.jpg" alt="User">
            </div>
         </div>
         <div class="col-lg-6 p-0">
            <div class="user-content">
               <div class="d-table">
                  <div class="d-table-cell">
                     <div class="user-content-inner">
                        <div class="top">
                           <a href="<?=base_url()?>">
                              <img src="<?=PATH.get_option('website_logo')?>" class="logo-one" alt="Logo" height="60">
                              <img src="<?=PATH.get_option('website_logo_mark')?>" class="logo-two" alt="Logo" height="60">
                           </a>
                           <h2>Forgot Password</h2>
                        </div>
                        <?=form_open('auth/ajax_forgot_password', 'class="actionForm" data-redirect= "'.base_url('signin').'" ');?>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                 </div>
                              </div>
                              
                              <?php
                                  if (get_option('enable_goolge_recapcha') &&  get_option('google_capcha_site_key') != "" && get_option('google_capcha_secret_key') != "") {
                                ?>
                                <div class="form-group">
                                  <div class="g-recaptcha" data-sitekey="<?=get_option('google_capcha_site_key')?>"></div>
                                </div>
                                <?php } ?>
                              <div class="col-lg-12">
                                 <button type="submit" class="btn">Reset Password</button>
                              </div>
                           </div>

                        <?=form_close();?>
                        <div class="bottom">
                           <p>Are You New Member? <a href="<?=base_url('signup')?>">Sign Up</a></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>