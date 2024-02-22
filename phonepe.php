<?php
// if (isset($_POST['submit_form'])) {

    $amount = $_GET['amount'];
$jayParsedAry = [
    "merchantId" => 'M1GMWENHTTUJ', // <THIS IS TESTING MERCHANT ID>
    "merchantTransactionId" => rand(111111,999999),
    "merchantUserId" => 'MUID' . time(),
    "amount" => $amount*100,
    "redirectUrl" =>  'http://localhost/payrr/redirect.php',
    "redirectMode" => "POST", // GET, POST DEFINE REDIRECT RESPONSE METHOD,
    "redirectUrl" =>  "http://localhost/payrr/redirect.php",
    "mobileNumber" => "7385990564",
    "paymentInstrument" => [
        "type" => "PAY_PAGE"
    ]
];

$encode = json_encode($jayParsedAry);
$encoded = base64_encode($encode);
$key = 'b66d7b7b-5ec6-48e5-bddc-795112c916d2'; // KEY
$key_index = 1; // KEY_INDEX
$string = $encoded . "/pg/v1/pay".$key;
$sha256 = hash("sha256", $string);
$final_x_header = $sha256 . '###'.$key_index;

$url = "https://api.phonepe.com/apis/hermes/pg/v1/pay";// <PRODUCTION URL>

// $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay"; // <TESTING URL>

$headers = array(
    "Content-Type: application/json",
    "accept: application/json",
    "X-VERIFY: " . $final_x_header,
);

$data = json_encode(['request' => $encoded]);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$resp = curl_exec($curl);

curl_close($curl);

$response = json_decode($resp);

header('Location:' . $response->data->instrumentResponse->redirectInfo->url);
// }

?>