<?php
require_once 'init.php';

// Get course details from URL or session
$type = $_GET['type'] ?? '';
$courseLevel = $_GET['level'] ?? null;
$coursePrice = $_GET['price'] ?? null;
$courseDescription = '';

if ($type === 'tea') {
    $courseDescription = "Buy me a tea";
    $coursePrice = null; // Allow custom amount
} else {
    $courseDescription = "Dropshipping Course Level $courseLevel Enrollment";
}

// Store in session
$_SESSION['current_order'] = [
    'order_id' => uniqid('ORDER-'),
    'amount' => $coursePrice,
    'description' => $courseDescription,
    'course_level' => $courseLevel
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money Payment - Kuzamarket</title>
    <style>
        .payment-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #7E001F;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Complete Payment via Mobile Money</h1>
        <?php if ($type === 'tea'): ?>
            <p>Buy me a tea ☕️</p>
            <div class="form-group">
                <label for="amount">Amount (TZS)</label>
                <input type="number" id="amount" name="amount" min="1000" required>
            </div>
        <?php else: ?>
            <p>Course: Level <?php echo htmlspecialchars($courseLevel); ?></p>
            <p>Amount: <?php echo number_format($coursePrice); ?> TZS</p>
        <?php endif; ?>
        
        <form action="process-payment.php" method="POST">
            <div class="form-group">
                <label for="buyer_name">Full Name</label>
                <input type="text" id="buyer_name" name="buyer_name" required>
            </div>
            <div class="form-group">
                <label for="buyer_email">Email Address</label>
                <input type="email" id="buyer_email" name="buyer_email" required>
            </div>
            <div class="form-group">
                <label for="buyer_phone">Mobile Money Number (Tanzania)</label>
                <input type="tel" id="buyer_phone" name="buyer_phone" 
                       pattern="[0]{1}[0-9]{9}" placeholder="07XXXXXXXX" required>
                <small>Format: 07XXXXXXXX (e.g., 0744963858)</small>
            </div>
            <input type="hidden" name="order_id" value="<?php echo $_SESSION['current_order']['order_id']; ?>">
            <input type="hidden" name="amount" value="<?php echo $coursePrice; ?>">
            <input type="hidden" name="course_level" value="<?php echo $courseLevel; ?>">
            <button type="submit">Pay with Mobile Money</button>
        </form>
    </div>
</body>
</html>