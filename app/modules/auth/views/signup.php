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
                           <h2>Sign Up</h2>
                        </div>
                        <?=form_open('auth/signup_process', 'class="actionForm" data-redirect="/surepay/verify" ');?>
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="First name" name="first_name">
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Last name" name="last_name">
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-group ">
                                    <input type="phone" class="form-control" placeholder="Phone" name="phone">
                                 </div>
                              </div>
                              <!-- <div class="col-lg-6">
                                 <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email">
                                 </div>
                              </div> -->
                              
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Create a password" name="password">
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirm password" name="re_password">
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <button type="submit" class="btn">Sign Up</button>
                              </div>
                           </div>
                        <?=form_close();?>
                        <!-- <div class="bottom">
                           <p>Already Signed Up? <a href="<?=cn('signin')?>">Sign In</a></p>
                           <h4>OR</h4>
                           <ul>
                              
                              <li>
                                 <a href="<?=base_url('auth/google_process')?>">
                                 <i class="bx bxl-google"></i>
                                 Connect with Google
                                 </a>
                              </li>
                           </ul>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
    $(document).on('submit', '.actionForm', function (e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            const res = JSON.parse(response);  
            console.log('Response:', res);  

            if (res.status === 'success') {
                console.log('Redirecting to:', res.redirect);  // Log the redirect URL
                window.location.href = "https://localhost:4433/surepay/auth/verify"; // Redirect the browser to the new URL
            } else {
                alert(res.message);  // Alert the error message if any
            }
        },
        error: function (xhr) {
            console.error('Request failed', xhr);  // Log any request errors
        },
    });
});



</script>
