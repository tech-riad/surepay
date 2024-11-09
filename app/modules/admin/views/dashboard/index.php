<div class="col-xl-12" data-url="<?=admin_url('dashboard/get_data')?>" id="dashboard_data">
   <div class="card" style="background: linear-gradient(90deg, rgba(105,180,151,1) 0%, rgb(118 169 207 / 54%) 34%, rgb(218 177 18 / 33%) 71%, rgba(0,212,255,0.30575980392156865) 100%);">
      <div class="card-header border-0 flex-wrap">
         <h4 class="fs-20 font-w700 mb-2">Statistics</h4>
         <div class="d-flex align-items-center project-tab mb-2"> 
            <div class="card-tabs mt-3 mt-sm-0 mb-3 ">
               <ul class="nav nav-tabs">
                  <li class="nav-item ">
                     <a class="get_tab_records nav-link active" href="javascript:void()">Today</a>
                  </li>
                  <li class="nav-item ">
                     <a class="get_tab_records nav-link" href="javascript:void()">Weekly</a>
                  </li>
                  <li class="nav-item ">
                     <a class="get_tab_records nav-link" href="javascript:void()" >Monthly</a>
                  </li>
                  <li class="nav-item ">
                     <a class="get_tab_records nav-link" href="javascript:void()">Yearly</a>
                  </li>                  
               </ul>
            </div>
         </div>   
      </div>
      <div class="card-body"> 
         <div class="row">
            <div class="col-xl-3 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                           <i class="fa fa-users"></i>
                        </span>
                        <div class="media-body">
                           <p class="mb-1">Users</p>
                           <h4 class="mb-0"><span class="tot_users">0</span><span class="badge badge-xs badge-danger tot_in_users">0</span></h4>
                           <span class="badge badge-xs bg-primary"><span class="s_users">0</span> <span class="badge badge-danger s_in_users">0</span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                           <i class="fa fa-file-alt"></i>
                        </span>
                        <div class="media-body">
                           <p class="mb-1">Transactions</p>
                           <h4 class="mb-0"><span class="tot_trx">0</span><span class="badge badge-xs badge-danger tot_in_trx">0</span></h4>
                           <span class="badge badge-xs bg-primary"><span class="s_trx">0</span> <span class="badge badge-danger s_in_trx">0</span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                           <i class="fa fa-file-alt"></i>
                        </span>
                        <div class="media-body">
                           <p class="mb-1">Invoices</p>
                           <h4 class="mb-0"><span class="tot_invoice">0</span><span class="badge badge-xs badge-danger tot_in_invoice">0</span></h4>
                           <span class="badge badge-xs bg-primary"><span class="s_invoice">0</span> <span class="badge badge-danger s_in_invoice">0</span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-3 col-sm-6">
               <div class="widget-stat card">
                  <div class="card-body p-4">
                     <div class="media ai-icon">
                        <span class="me-3 bgl-primary text-primary">
                           <i class="fa fa-envelope"></i>
                        </span>
                        <div class="media-body">
                           <p class="mb-1">Tickets</p>
                           <h4 class="mb-0"><span class="tot_tickets">0</span><span class="badge badge-xs badge-success ans_tickets">0</span></h4>
                           <span class="badge badge-xs bg-primary"><span class="s_tickets">0</span> <span class="badge badge-success s_ans_tickets">0</span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>


<div class="row">
  <div class="col-12">
      <div class="card">
        <div class="card-body">
          <canvas id="canvas"></canvas>
        </div>
      </div>
   </div>
</div>


<div class="row">
  <div class="col-12">
      <div class="card">
          <div class="card-header">
              <h4 class="card-title">Latest Transactions</h4>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                 <table class="table table-xs card-table">
                     <?php echo render_table_thead($columns, false, false, false); ?>
                       <tbody>
                         <?php if (!empty($items)) {
                           $i = $from;
                           foreach ($items as $key => $item) {
                             $i++;
                             $item_payment_type  = show_item_transaction_type($item['type']);
                             $created            = show_item_datetime($item['created'], 'long');
                             $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '', 'user'); 
                         ?>
                           <tr class="tr_<?php echo $item['id']; ?>">
                             <td class="text-center w-5p text-muted"><?=$i?></td>
                             <td class="text-center w-5p"><?=@get_current_user_data($item['uid'])->email?></td>
                             <td class="text-center w-10p"><?php echo $item['cus_email'] ; ?></td>
                             <td class="text-center w-10p"><?php echo $item_payment_type ; ?></td>
                             <td class="text-center w-10p"><?php echo $item['transaction_id'] ; ?><a href="<?=admin_url('transactions/view_transaction/'.$item['id'])?>" class="btn btn-sm ajaxModal"><i class="fa fa-eye"></i></a></td>
                             <td class="text-center w-10p"><?php echo $item['amount'].$item['currency']; ?></td>
                             <td class="text-center w-5p text-muted"><?php echo $created; ?></td>
                           </tr>
                         <?php }}?>
                       </tbody>
                 </table>
              </div>

          </div>
      </div>
  </div>
</div>

<script src="<?=PATH?>assets/plugins/jquery/jquery-3.4.1.min.js"></script>
<script src="<?=PATH?>assets/plugins/chartjs/chart.bundle.min.js"></script>

<script type="text/javascript">function setCanvasHeight() {
  var canvas = document.getElementById("canvas"); canvas.height = window.innerWidth <= 600 ? 350 : 100; } setCanvasHeight();window.addEventListener('resize', setCanvasHeight);  function get_dashboard_values(dates = '') {$.post($('#dashboard_data').attr('data-url'), {token: token, dates: dates }, function(result) {var data = jQuery.parseJSON(result); $.each(data, function(index, element) {$("." + index).html(element); }); }); } jQuery(document).ready(function($) {get_dashboard_values('Today'); }); $(".get_tab_records").on("click", function(event) {event.preventDefault(); $(".get_tab_records").removeClass('active'); $(this).addClass('active'); get_dashboard_values($(this).html()); }); var chartData = <?=$bar_chart ?> ; var initialData = chartData.slice(0, 10); var labels = initialData.map(entry => entry.period); var datasets = [{label: 'bkash', backgroundColor: "rgba(0,60,100,1)", borderColor: "black", data: initialData.map(entry => entry.bkash) }, {label: 'nagad', backgroundColor: "rgba(255,0,0,1)", borderColor: "yellow", data: initialData.map(entry => entry.nagad) }, {label: 'rocket', backgroundColor: "rgba(25,50,0,1)", borderColor: "black", data: initialData.map(entry => entry.rocket) }, {label: 'other', backgroundColor: "rgba(128,128,0,1)", borderColor: "blue", data: initialData.map(entry => entry.other) }, ]; var ctx = document.getElementById("canvas").getContext("2d"); var barChartData = {labels: labels, datasets: datasets }; var barChartDemo = new Chart(ctx, {type: 'bar', data: barChartData, options: {responsive: true, barValueSpacing: 1, scales: {x: {type: 'category', labels: labels, scaleLabel: {display: true, labelString: 'Period'} }, y: {beginAtZero: true, scaleLabel: {display: true, labelString: 'Amount'} } }, plugins: {datalabels: {color: 'white', anchor: 'end', align: 'end', offset: 2,display: 'auto',z: 1, font: {weight: 'bold'} } } } }); var index = 0; var intervalId; function updateChart() {if (index < chartData.length) {labels = chartData.slice(index, index + 10).map(entry => entry.period); for (var i = 0; i < datasets.length; i++) {datasets[i].data = chartData.slice(index, index + 10).map(entry => entry[datasets[i].label.toLowerCase()]); } barChartData.labels = labels; barChartData.datasets = datasets; barChartDemo.update(); index++; if (index >= chartData.length) {index = 0; } } } function startUpdating() {intervalId = setInterval(updateChart, 3000); } function stopUpdating() {clearInterval(intervalId); } var canvas = document.getElementById("canvas"); canvas.addEventListener("mouseenter", stopUpdating); canvas.addEventListener("mouseleave", startUpdating); startUpdating();</script>