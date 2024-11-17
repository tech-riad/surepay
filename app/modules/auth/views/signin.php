<?php
   $cookie_email='';
   $cookie_pass='';

   if (isset($_COOKIE["c_cookie_email"])) {
      $cookie_email = encrypt_decode($_COOKIE["c_cookie_email"]);
   }

   if (isset($_COOKIE["c_cookie_pass"])) {
      $cookie_pass = encrypt_decode($_COOKIE["c_cookie_pass"]);
   }

?>

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
                           <h2>Sign In</h2>
                        </div>
                        <?=form_open('auth/signin_process', 'class="actionForm" data-redirect= "user" ');?>
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <input type="number" name="phone" class="form-control" placeholder="Enter your phone" required value="<?=$cookie_phone?>">
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Enter your password" required value="<?=$cookie_pass?>">
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="form-check text-start">
                                   <input class="form-check-input" name="remember" type="checkbox" id="flexCheckChecked" <?=(isset($cookie_phone) && $cookie_phone != "") ? "checked" : ""?> >
                                   <label class="form-check-label" for="flexCheckChecked">
                                     Remember me
                                   </label>
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
                                 <button type="submit" class="btn">Sign In</button>
                              </div>
                           </div>

                        <?=form_close();?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>