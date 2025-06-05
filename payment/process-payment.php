<?php
require_once 'init.php';

session_start();

// Validate form data
if (empty($_POST['buyer_name']) || empty($_POST['buyer_phone']) || empty($_POST['amount'])) {
    header('Location: payment-form.php');
    exit;
}

// Prepare payment data for ZenoPay API
$paymentData = [
    'order_id' => $_POST['order_id'] ?? uniqid('ORDER-'),
    'buyer_email' => $_POST['buyer_email'],
    'buyer_name' => $_POST['buyer_name'],
    'buyer_phone' => $_POST['buyer_phone'],
    'amount' => (int)$_POST['amount']
];

// Make API request to ZenoPay
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://zenoapi.com/api/payments/mobile_money_tanzania');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($paymentData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'x-api-key: aCMAzrOwV81b9Tol-0rWRSwgvooiUj3oyiDhPXgDEZFEOwWucFIghYkcFYyks-KaBjH156mLLsSgUb2L8Lu4hA'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Process response
if ($httpCode === 200) {
    $responseData = json_decode($response, true);
    
    // Save transaction to database
    $transactionData = [
        'zenopay_id' => $paymentData['order_id'],
        'order_id' => $paymentData['order_id'],
        'amount' => $paymentData['amount'],
        'currency' => 'TZS',
        'status' => 'pending',
        'customer_email' => $paymentData['buyer_email'],
        'payment_method' => 'mobile_money',
        'raw_data' => $responseData
    ];
    
    saveTransaction($transactionData);
    
    // Redirect to status page
    header('Location: payment-status.php?id=' . $paymentData['order_id']);
    exit;
} else {
    // Handle error
    $_SESSION['payment_error'] = 'Payment processing failed. Please try again.';
    header('Location: failure.php');
    exit;
}
?>