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
                           <h2>Verify Otp</h2>
                        </div>
                        <?=form_open('auth/verify_process', 'class="actionForm" data-redirect= "user" ');?>
                           <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-lg-8">
                                 <div class="form-group ">
                                    <input type="otp" class="form-control" placeholder="Enter Your Otp" name="otp">
                                 </div>
                              </div>
                              <div class="col-md-2"></div>

                              
                              <div class="col-lg-12">
                                 <button type="submit" class="btn">Submit</button>
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



<script>
    $(document).on('submit', '#otpForm', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert(res.message);
                    window.location.href = res.redirect; 
                } else {
                    alert(res.message);
                }
            },
            error: function (xhr) {
                console.error('Request failed', xhr);
            },
        });
    });
</script>
