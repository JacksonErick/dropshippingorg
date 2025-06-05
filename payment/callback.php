<?php
require_once 'init.php';

// Get webhook payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_ZENOPAY_SIGNATURE'] ?? '';

// Verify webhook signature
if (!verifyWebhookSignature($payload, $signature)) {
    http_response_code(401);
    die('Invalid signature');
}

// Parse payload
$event = json_decode($payload, true);

// Handle different event types
switch ($event['type']) {
    case 'payment.succeeded':
        $payment = $event['data'];
        updateTransactionStatus($payment['id'], 'succeeded', $payment);
        break;
        
    case 'payment.failed':
        $payment = $event['data'];
        updateTransactionStatus($payment['id'], 'failed', [
            'failure_reason' => $payment['failure_reason'] ?? 'unknown'
        ]);
        break;
        
    case 'payment.processing':
        $payment = $event['data'];
        updateTransactionStatus($payment['id'], 'processing', $payment);
        break;
        
    default:
        // Log unhandled event type
        error_log("Unhandled Zenopay webhook event: " . $event['type']);
        break;
}

http_response_code(200);
echo 'OK';
?>