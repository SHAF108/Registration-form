<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();
//
use Razorpay\Api\Api;

$api = new Api($keyId,$keySecret);
// create the razorpay order
// if (isset($_POST['submit_form'])) {
$amount = $_GET['amount'];


//
// we create an razorpay order using order api
// doc: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => 'rcptid_11',
    'amount'          => $amount*100, // 39900 rupees in paise
    'currency'        => 'INR'
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];
$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$displayAmount = $amount = $orderData['amount'];

if($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);
    $displayAmount = $exchange['rates'][$displayCurrency]*$amount/100;
}
$checkout = 'automatic';
if(isset($_GET['checkout']) and in_array($_GET['checkout'],['automatic','manual'], true))
{
    $checkout = $_GET['checkout'];
}
$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "Mopedo",
    "description"       => " Thank you for Mopedo Rides ",
    "image"             => "",
    "prefill"           => [
    "name"              => "Naseeb khan",
    "email"             => "naseeb7385@gmail.com",
    "contact"           => "7385990564",
    ],
    "notes"             => [
    "address"           => "Hyderabad",
    "merchant_order_id" => "",
    ],
    "theme"             => [
    "color"             => "#99cc33"
    ],
    "order_id"          => $razorpayOrderId,
];
if($displayCurrency !== 'INR')
{
    $data['display_currency'] = $displayCurrency;
    $data['displayAmount'] = $displayAmount;
}
$json = json_encode($data);
require("checkout/manual.php");


// }
?>