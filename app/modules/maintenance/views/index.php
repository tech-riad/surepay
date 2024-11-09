
        <div class="container">
            <img src="<?=get_option('website_logo')?>" class="logo">
            <div class="content">
                <p>website Is Under Maintenance</p>
                <h1>We're <span>Launching</span> Soon</h1>
                <div class="launch-time">
                    <div>
                        <p id="days">00</p>
                        <span>Days</span>
                    </div>
                    <div>
                        <p id="hours">00</p>
                        <span>Hours</span>
                    </div>
                    <div>
                        <p id="minutes">00</p>
                        <span>Minutes</span>
                    </div>
                    <div>
                        <p id="seconds">00</p>
                        <span>Seconds</span>
                    </div>
                </div>
                
            </div>
            <img src="<?=base_url('assets/images/website/maintainance.png');?>" class="rocket">
        </div>
   <script type="text/javascript">
var countDownDate=new Date('<?=get_option('maintenance_mode_time');?>');var x=setInterval(function(){var now=new Date().getTime();var distance=countDownDate-now;var days=Math.floor(distance /(1000*60*60*24));var hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60));var minutes=Math.floor((distance%(1000*60*60))/(1000*60));var seconds=Math.floor((distance%(1000*60))/ 1000);document.getElementById("days").innerHTML=days;document.getElementById("hours").innerHTML=hours;document.getElementById("minutes").innerHTML=minutes;document.getElementById("seconds").innerHTML=seconds;if(distance<0){clearInterval(x);document.getElementById("days").innerHTML="00";document.getElementById("hours").innerHTML="00";document.getElementById("minutes").innerHTML="00";document.getElementById("seconds").innerHTML="00";}},1000);   

   </script>