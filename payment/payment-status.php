<?php
require_once 'init.php';

$paymentId = $_GET['id'] ?? null;

if (!$paymentId) {
    header('Location: payment-form.php');
    exit;
}

// Check payment status with ZenoPay API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://zenoapi.com/api/payments/order-status?order_id=' . urlencode($paymentId));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'x-api-key: aCMAzrOwV81b9Tol-0rWRSwgvooiUj3oyiDhPXgDEZFEOwWucFIghYkcFYyks-KaBjH156mLLsSgUb2L8Lu4hA'
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $responseData = json_decode($response, true);
    
    if (isset($responseData['data'][0]['payment_status'])) {
        $status = strtolower($responseData['data'][0]['payment_status']);
        
        // Update transaction status
        updateTransactionStatus($paymentId, $status, $responseData);
        
        // Redirect based on status
        if ($status === 'completed') {
            header('Location: success.php?id=' . $paymentId);
            exit;
        } elseif ($status === 'failed') {
            $_SESSION['payment_error'] = 'Payment failed. Please try again.';
            header('Location: failure.php');
            exit;
        }
    }
}

// If still pending or error, show checking status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing</title>
    <style>
        .status-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #7E001F;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="status-container">
        <h1>Payment Processing</h1>
        <p>Your mobile money payment is being processed. Please wait...</p>
        <div class="loader"></div>
        <p>This may take a few moments. Do not refresh the page.</p>
        
        <script>
            // Check payment status every 5 seconds
            setTimeout(function() {
                window.location.reload();
            }, 5000);
        </script>
    </div>
</body>
</html>