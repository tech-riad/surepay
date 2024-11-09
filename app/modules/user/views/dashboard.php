<div class="row flex-wrap ">
    <div class="col-12 d-flex justify-content-end">
        <div class="btn-group" role="group" data-url="<?=client_url('dashboard/get_data')?>" id="dashboard_data">
            <button type="button" class="btn btn-primary get_tab_records active">Today</button>
            <button type="button" class="btn btn-primary get_tab_records">Weekly</button>
            <button type="button" class="btn btn-primary get_tab_records">Monthly</button>
            <button type="button" class="btn btn-primary get_tab_records">Yearly</button>
        </div>
    </div>
</div>
<div class="row" data-url="<?=client_url('dashboard/get_data')?>" id="dashboard_data">
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
        <div class="card-body">
            <h5 class="card-title">Balance</h5>
              <h2><?=get_current_user_data()->balance?></h2>
              <p><?=get_option('currency_symbol')?></p>
              
        </div>
        <div style="margin-top: -25px;">
                <a href="<?=client_url('add_funds')?>" class="btn btn-outline-primary ajaxModal" >Add Balance</a>
              </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget bg-success">
        <div class="card-body">
            <h5 class="card-title">Payment </h5>
              <h2 class="s_payment">0</h2>
              <p><?=get_option('currency_symbol')?></p>              
        </div>
        <small class="p-1">Failed Payment<span class="badge bg-danger s_in_payment">0</span></small>

    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget bg-warning">
        <div class="card-body">
            <h5 class="card-title">Transactions<span class="badge bg-info tot_trx">0</span></h5>
              <h2 class="s_trx">0</h2>
              <p>Today Transaction</p>
              <div class="progress">
                <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
        </div>
    </div>
  </div>
  <div class="col-md-6 col-xl-3">
    <div class="card stat-widget">
        <div class="card-body">
            <h5 class="card-title">Invoice<span class="badge bg-info tot_invoice">0</span></h5>
              <h2 class="s_invoice">0</h2>
              <p>Today Invoice</p>
              <div class="progress">
                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
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
                    <thead>
                       <tr>
                          <th class="text-center">#</th>
                          <th class="text-center">Payment method</th>
                          <th class="text-center">Customer email</th>
                          <th class="text-center">Transaction_ID</th>
                          <th class="text-center">amount</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Created</th>
                       </tr>
                    </thead>
                      <tbody>
                      <?php if (!empty($items)) {
                        $i = 0;
                        foreach ($items as $key => $item) {
                          $i++;
                          $item_payment_type  = show_item_transaction_type($item['type']);
                          $created            = show_item_datetime($item['created'], 'long');
                          $item_status        = show_item_status($controller_name, $item['id'], $item['status'], '');
                      ?>
                        <tr class="tr_<?php echo $item['id']; ?>">
                          <td class="text-center w-5p text-muted"><?=$i?></td>
                          <td class="text-center w-10p"><?php echo $item_payment_type ; ?></td>
                          <td class="text-center w-10p"><?php echo $item['cus_email'] ; ?></td>
                          <td class="text-center w-10p"><?php echo $item['transaction_id'] ; ?><a href="<?=client_url('transactions/view_transaction/'.$item['transaction_id'])?>" class="btn btn-sm"><i class="fa fa-eye"></i></a></td>
                          <td class="text-center w-10p"><?php echo $item['amount'].$item['currency']; ?></td>
                          <td class="text-center w-5p text-muted"><?php echo $item_status; ?></td>
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