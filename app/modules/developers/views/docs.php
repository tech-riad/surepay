<div class="section">
         <div class="container">
            <div class="row">
               <div class="col-md-4">
                  <div class="sections-list-wrapper">
                     <div class="sections-list js-sections js-affix js-scrollspy hidden-xs hidden-sm">
                     </div>
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="content">
                     <h2 id="overview">Overview</h2>
                     <h5>Documentation ( Version: 1.00 )</h5>
                     <h6>Updated: 1st September, 2023</h6>
                     <h3 id="general-overview">General overview</h3>
                     <p>
                        Connect effortlessly through our system. Link apps and data sources, automate tasks, and enjoy smooth workflows with ease.Receive payments directly into your personal account using UniquePay BD's payment automation software. No need to handle payments manually anymore.
                     </p>

                     <h3 id="overview-process">Setup your panel</h3>
                     <div class="callout callout--success">
                        <strong>Checkpoint Tips:</strong>
                        <p>
                        <ul>
                           <li>For registration, click the link <a href="<?=base_url('signup')?>"><?=base_url('signup')?></a></li>
                           <li>
                              Complete the following process:
                              <ol>
                                 <li>Setup your profile from <a href="<?=client_url('profile') ?>"><?=client_url('profile') ?></a></li>
                                 <li>Buy a plan from <a href="<?=client_url('plans') ?>"><?=client_url('plans') ?></a></li>
                                 <li>Add a domain from<a href="<?=client_url('domain_whitelist') ?>"><?=client_url('domain_whitelist') ?></a></li>
                                 <li>Setup methods from <a href="<?=client_url('settings') ?>"><?=client_url('settings') ?></a></li>
                              </ol>
                           </li>
                           <li>
                              Setup your credentials:
                              <ol>
                                 <li>Your Api Key</li>
                                 <li>Your Secret Key</li>
                              </ol>
                           </li>
                        </ul>
                        </p>
                     </div>
                     <h3 id="mobile-process">Setup your Mobile App</h3>
                     <div class="callout callout--success">
                        <strong>Checkpoint Tips:</strong>
                        <p>
                        <ul>
                           <li>Click the link <a href="<?=get_option('app_link','') ?>">TO DOWNLOAD MOBILE APP </a></li>
                           <li>
                              Complete the following process:
                              <ol>
                                 <li>Install the app with necessary permission <a href="<?=get_option('app_link','') ?>"><?=get_option('app_link','') ?></a></li>
                                 <li>Register a device from user panel <a href="<?=client_url('devices') ?>"><?=client_url('devices') ?></a></li>
                                 <li>Copy the device key </li>
                                 <li>Get Back to mobile app and Enter Your Email and device key. </li>
                                 <li>Give SMS and Notification Permission to the App. </li>
                              </ol>
                           </li>
                           
                        </ul>
                        </p>
                     </div>
                     

                     <h2 id="payment-process-environment">Payment Process</h2>
                     <p>We have made Live environment to process payments.</p>
                     <div class="callout callout--info">
                        <p><strong>Live Environment</strong></p>
                        <p>All the transaction made using this environment are counted as real transaction, URL starts with <b><?=PAYMENT_URL?></b></p>
                     </div>
                     
                     
                     <span>REST API</span><br>
                     <div class="callout callout--info">
                        <b>API Endpoint (Live Environment):</b> <?=PAYMENT_URL?>
                        <br>
                        <b>Method:</b> POST
                     </div>
                     <h3 id="qrs-request-parameters">Request Parameters</h3>
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th style="text-align: left">Param Name</th>
                                 <th style="text-align: left">Data Type</th>
                                 <th style="text-align: left">Description</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">cus_name</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> - This parameter will be returned only when the request successfully initiates
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">cus_email</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> - This parameter will be returned only when the request successfully initiates
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">success_url</code></td>
                                 <td style="text-align: left">string (100)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> - This parameter will be returned only when the request successfully initiates
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">cancel_url</code></td>
                                 <td style="text-align: left">string (100)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> - This parameter will be returned only when the request successfully initiates
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">amount</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> - This parameter will be returned only when the request successfully initiates
                                 </td>
                              </tr>
                              
                           </tbody>
                        </table>
                     </div>
                     <h3 id="qrs-request-headers">Request Headers</h3>
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th style="text-align: left">Param Name</th>
                                 <th style="text-align: left">Data Type</th>
                                 <th style="text-align: left">Description</th>
                              </tr>
                           </thead>
                           <tbody>
                              
                              
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">Content-Type</code></td>
                                 <td style="text-align: left">application/x-www-form-urlencoded</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> 
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">app-key</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> Your API KEY
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">secret-key</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> Your SECRET KEY
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">host-name</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    <span class="label label-danger">Mandatory</span> Valid Domain
                                 </td>
                              </tr>
                              
                           </tbody>
                        </table>
                     </div>
                     <h3 id="qrs-returned-parameters">Returned Parameters</h3>
                     <p>In GET Request</p>
                     <div class="table-responsive">
                        <table class="table table-bordered">
                           <thead>
                              <tr>
                                 <th style="text-align: left">Param Name</th>
                                 <th style="text-align: left">Data Type</th>
                                 <th style="text-align: left">Description</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">transactionId</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    Receive it by $_GET['transactionId'] in your success and cancel url
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">paymentAmount</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    Receive it by $_GET['paymentAmount'] in your success and cancel url
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">paymentFee</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    Receive it by $_GET['paymentFee'] in your success and cancel url
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">success</code></td>
                                 <td style="text-align: left">int (2)</td>
                                 <td style="text-align: left">
                                    Receive (0/1) by $_GET['success'] in your success and cancel url
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left"><code class="highlighter-rouge">p_type</code></td>
                                 <td style="text-align: left">string (50)</td>
                                 <td style="text-align: left">
                                    Receive it by $_GET['p_type'] in your success url
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>

                     <h2 id="qrs-sample-parameters">Create Payment Request</h2>
                     <div class="callout callout--warning">
                        <p><strong>Security Check Points:</strong></p>
                        <ul>
                           <li>Your Public IP must be registered at <?=get_option('website_name') ?> Live System</li>
                        </ul>
                     </div>
                     <h4 id="c-payment">Payment Create code</h4>                                         

                     <div class="editor-block block1">
                        <div class="row">
                           <div class="col-12" style="text-align: right;border-bottom: 1px solid #efdddd !important;">
                              <select id="select-request">
                                 <option value="php-request">PHP</option>
                                 <option value="php-guzzle-request">PHP Guzzle</option>
                                 <option value="js-node-request">JS Node</option>
                              </select>
                           </div>
                           <div class="col-12">
                              <div id="php-request" class="code-block code-open">
                                 <pre><code>
&lt;?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '<?=PAYMENT_URL ?>',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('cus_name' => 'demo','cus_email' => 'demo@gmail.com','amount' => '10','success_url' => 'success.php','cancel_url' => 'cancel.php'),
  CURLOPT_HTTPHEADER => array(
    'app-key: #########',
    'secret-key: ######',
    'host-name: ######',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?&gt;
                                 </code></pre>
                              </div>
                              <div id="php-guzzle-request" class="code-block">
                                 <pre><code>
&lt;?php
$client = new Client();
$headers = [
  'app-key' => '#####',
  'secret-key' => '#####',
  'host-name' => '######',
];
$options = [
  'multipart' => [
    [
      'name' => 'cus_name',
      'contents' => 'demo'
    ],
    [
      'name' => 'cus_email',
      'contents' => 'demo@gmail.com'
    ],
    [
      'name' => 'amount',
      'contents' => '10'
    ],
    [
      'name' => 'success_url',
      'contents' => 'success.php'
    ],
    [
      'name' => 'cancel_url',
      'contents' => 'cancel.php'
    ]
]];
$request = new Request('POST', '<?=PAYMENT_URL ?>', $headers);
$res = $client->sendAsync($request, $options)->wait();
echo $res->getBody();

?&gt;
                                 </code></pre>
                              </div>
                              </div>
                              <div id="js-node-request" class="code-block">
                                 <pre><code>
const axios = require('axios');
const FormData = require('form-data');
let data = new FormData();
data.append('cus_name', 'demo');
data.append('cus_email', 'demo@gmail.com');
data.append('amount', '10');
data.append('success_url', 'success.php');
data.append('cancel_url', 'cancel.php');

let config = {
  method: 'post',
  maxBodyLength: Infinity,
  url: '<?=PAYMENT_URL ?>',
  headers: { 
    'app-key': '#####', 
    'secret-key': '####', 
    'host-name': '###', 
    ...data.getHeaders()
  },
  data : data
};

axios.request(config)
.then((response) => {
  console.log(JSON.stringify(response.data));
})
.catch((error) => {
  console.log(error);
});
                                    
                                 </code></pre>
                              </div>
                           </div>
                        </div>

                     <h4 id="res-gateway">Response from GATEWAY</h4>
                     <div class="callout callout--success">
                        <strong>Response:</strong>
                        <p>
                        <ul>
                           <li>After Successfull Payment you will be redirect to :                            success.php?transactionId=******&paid_by=***&paymentAmount=**.**&paymentFee=**.**&success=1&p_type=****</li>
                           <small>paid_by can be bkash,nagad,rocket,cellfin,upay,ibl,ebl,sonali,paypal,mastercard,basic,jamuna,ific etc. </small>
                           <li>After failure of payment you will be redirect to : cancel.php?transactionId=******&paymentAmount=**.**&paymentFee=**.**&success=0 
                           </li>
                           
                        </ul>
                        </p>
                     </div>

                     <h2 id="qrs-verify-parameters">Verify Payment</h2>

                     <h4 id="v-payment">Payment verify code</h4>                                         
                     <div class="editor-block block2">
                        <div class="row">
                           <div class="col-12" style="text-align: right;border-bottom: 1px solid #efdddd !important;">
                              <select id="select-verify-request">
                                 <option value="php-verify-request">PHP</option>
                                 <option value="php-guzzle-verify-request">PHP Guzzle</option>
                                 <option value="js-node-verify-request">JS Node</option>
                              </select>
                           </div>
                           <div class="col-12">
                              <div id="php-verify-request" class="code-block code-open">
                                 <pre><code>
&lt;?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '<?=VERIFY_URL?>',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('transaction_id' => 'JJTG987652'),
  CURLOPT_HTTPHEADER => array(
    'app-key: ##########',
    'secret-key: #####',
    'host-name: ###',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
?&gt;
                                 </code></pre>
                              </div>
                              <div id="php-guzzle-verify-request" class="code-block">
                                 <pre><code>
&lt;?php
$client = new Client();
$headers = [
  'app-key' => '#########',
  'secret-key' => '#####',
  'host-name' => '###',
];
$options = [
  'multipart' => [
    [
      'name' => 'transaction_id',
      'contents' => '####'
    ]
]];
$request = new Request('POST', '<?=VERIFY_URL ?>', $headers);
$res = $client->sendAsync($request, $options)->wait();
echo $res->getBody();

?&gt;
                                 </code></pre>
                              </div>
                              </div>
                              <div id="js-node-verify-request" class="code-block">
                                 <pre><code>
const axios = require('axios');
const FormData = require('form-data');
let data = new FormData();
data.append('transaction_id', '#####');

let config = {
  method: 'post',
  maxBodyLength: Infinity,
  url: '<?=VERIFY_URL ?>',
  headers: { 
    'app-key': '#########', 
    'secret-key': '########', 
    'host-name': '######', 
    ...data.getHeaders()
  },
  data : data
};

axios.request(config)
.then((response) => {
  console.log(JSON.stringify(response.data));
})
.catch((error) => {
  console.log(error);
});

                                    
                                 </code></pre>
                              </div>
                           </div>
                        </div>
                        
                        <h4 id="v-res-gateway">Verify Payment Response</h4>
                        <div class="callout callout--success">
                           <strong>Response:</strong>
                           <p>
                           {"cus_name":"y8vf","cus_email":"f@m.m","amount":"10","transaction_id":"JJTG987652","status":"1","message":"success"}
                           </p>
                        </div>
                        <h2 id="modules">All Modules</h2>
                        <div class="callout callout--success">
                           <h5 id="whmcs">WHMCS</h5>
                           <a href="https://uniquepaybd.com/assets/downloads/UniquePay%20BD%20Whmcs%20Module%20V1.zip">WHMCS MODULE V1</a>

                           <h5 id="smm">SMM PANEL</h5>
                           <a href="https://uniquepaybd.com/assets/downloads/SMM%20Panel%20UniquePay%20BD.zip">SMM PANEL MODULE V1</a>

                           <h5 id="wordpress">WORDPRESS</h5>
                           <a href="https://uniquepaybd.com/assets/downloads/UniquePayBD_WORDRESS_MODULE_V2.zip">WORDPRESS MODULE V2.0</a>
                           <h5 id="wordpressw">SKETCHWARE</h5>
                           <a href="https://uniquepaybd.com/assets/downloads/SKETCHWARE.swb">SKETCHWARE SWB</a>
                        </div>

                        





                     </div>


                  </div>
                  <!-- /.content -->
               </div>
               <!-- /.col -->
            </div>
            <!-- /.row -->
         </div>
         <!-- /.container -->
      </div>