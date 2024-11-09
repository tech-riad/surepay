<style> :root {--bg1: #ED2730; --bg2: #F7962A; } .bg1 {background-color: var(--bg1); } .bg2 {background-color: var(--bg2); color: var(--bg1); } .bg2-t {letter-spacing: -1px; color: var(--bg1); } input::placeholder {color: var(--bg1); } </style>

<?php
if (!empty($_GET['binance'])) {
	if ($_GET['binance'] == $this->custom_encryption->decrypt($tmp['all_info']['transaction_id'])) {
		redirect(base_url('request/complete/binance/'.$this->encryption->encrypt_data($tmp['all_info']['tmp_ids'] )));
	}
}
function generate_random_string()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 32; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$req = array(
    'env' => array('terminalType' => 'WEB'),
    'merchantTradeNo' => $tmp['all_info']['transaction_id']
);

$currency = get_option('currency_code');
if (empty($currency) || $currency == 'BUSD') {
    $currency = 'USDT';
}

if ($currency == 'USDT') {
    $req['orderAmount'] = $tmp['all_info']['total_amount'];
    $req['currency'] = $currency;
} else {
    $req['fiatAmount'] = $tmp['all_info']['total_amount'];
    $req['fiatCurrency'] = $currency;
}

$req['goods'] = array();
$req['returnUrl'] = current_url();
$req['cancelUrl'] = base_url("request/execute/" . session('tmp_ids'));
$req['webhookUrl'] = current_url() . '?binance='.$this->custom_encryption->encrypt($tmp['all_info']['transaction_id']);

$nonce = generate_random_string();
$body = json_encode($req);
$timestamp = round(microtime(true) * 1000);
$payload = $timestamp . "\n" . $nonce . "\n" . $body . "\n";
$secretKey = get_value($setting['params'], 'secret_key');
$signature = strtoupper(hash_hmac('sha512', $payload, $secretKey));
$apiKey = get_value($setting['params'], 'api_key');

$headers = array(
    'Content-Type: application/json',
    'BinancePay-Timestamp: ' . $timestamp,
    'BinancePay-Nonce: ' . $nonce,
    'BinancePay-Certificate-SN: ' . $apiKey,
    'BinancePay-Signature: ' . $signature,
);

$args = array(
    'body' => $body,
    'timeout' => '60',
    'redirection' => '8',
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => $headers,
    'cookies' => array(),
);

$apiUrl = get_value($setting['params'], 'api_url');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$responseBody = curl_exec($ch);

if (curl_errno($ch)) {
    error_log("cURL error: " . curl_error($ch));
}

curl_close($ch);

$result = json_decode($responseBody, true);

if ($result['code'] != '000000') {
    echo "<div style='color:red;font-size:14px; font-weight:900'>".$result['errorMessage']."</div>";
}else{
	$detail = $result['data'];
	redirect($detail['universalUrl']);
}
                 
	?>
<style type="text/css">
  #transaction_id,#payment_submit_done{
    display: none;
  }
  .container-m{
    position: unset;
    transform: unset;
  }

</style>