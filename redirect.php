<?php

// print_r($_POST);
    
    if (isset($_POST['code']) && !empty ($_POST['code']) && $_POST['code']=="PAYMENT_ERROR") {
       echo "Txn id: ".$_POST['transactionId']." Status: ".$_POST['code'];
    } else {
        echo "<h1>Payment Successful!</h1>";

        echo "Txn id: ".$_POST['transactionId']." Status: ".$_POST['code'];
    }

?>