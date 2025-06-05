<?php
require_once 'init.php';

session_start();

$error = $_SESSION['payment_error'] ?? 'Payment was not completed.';
$paymentId = $_SESSION['payment_id'] ?? null;

// Clear session
unset($_SESSION['current_order']);
unset($_SESSION['payment_error']);
unset($_SESSION['payment_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        .failure-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .failure-icon {
            color: #f44336;
            font-size: 50px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="failure-container">
        <div class="failure-icon">✗</div>
        <h1>Payment Failed</h1>
        <p><?php echo htmlspecialchars($error); ?></p>
        
        <?php if ($paymentId): ?>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($paymentId); ?></p>
        <?php endif; ?>
        
        <p>Please try again or contact support if the problem persists.</p>
        <p><a href="payment-form.php">Try Again</a> | <a href="/">Return to Home</a></p>
    </div>
</body>
</html>