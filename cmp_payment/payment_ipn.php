<?php 

$receiver_email = urldecode($_POST['receiver_email']);
$payment_status = $_POST['payment_status'];
$token = $_POST['custom'];

include 'cmp_payment.php';

if ($payment_status == "Completed") {
    
    setToken($token, $receiver_email);

}


header("HTTP/1.1 200 OK");