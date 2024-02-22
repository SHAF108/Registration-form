<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the amount from the POST data
    $amount = $_POST["amountEnterByUsers"];

    // Use the $amount variable in your PHP logic
    echo "Amount received: " . $amount;
} else {
    // Handle non-POST requests
    echo "Invalid request";
}
?>