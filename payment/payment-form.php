<?php
require_once 'init.php';

// Get course details and type from URL
$type = $_GET['type'] ?? 'course';
$course = $_GET['course'] ?? '';
$level = $_GET['level'] ?? '';

// Set course price based on type and level
$courseDescription = '';
$coursePrice = 0;

if ($type === 'tea') {
    $courseDescription = "Buy me a tea";
    $coursePrice = null;
} elseif ($course === 'dropshipping') {
    switch ($level) {
        case '1':
            $coursePrice = 35000;
            $courseDescription = "Dropshipping Course - Level 1: Beginner Fundamentals";
            break;
        case '2':
            $coursePrice = 45000;
            $courseDescription = "Dropshipping Course - Level 2: Intermediate Growth";
            break;
        case '3':
            $coursePrice = 55000;
            $courseDescription = "Dropshipping Course - Level 3: Advanced Scaling";
            break;
    }
} elseif ($course === 'forex') {
    $coursePrice = 150000;
    $courseDescription = "Forex Trading Pro Course";
} elseif ($course === 'crypto') {
    $coursePrice = 150000;
    $courseDescription = "Cryptocurrency & Blockchain Course";
} else {
    header('Location: /');
    exit;
}

// Store in session
$_SESSION['current_order'] = [
    'order_id' => uniqid('ORDER-'),
    'amount' => $coursePrice,
    'description' => $courseDescription,
    'course' => $course,
    'level' => $level
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
            <p style="text-align: center; font-size: 1.2rem; margin-bottom: 1rem;">Buy me a tea ☕️</p>
            <div class="form-group">
                <label for="amount">Amount (TZS)</label>
                <input type="number" id="amount" name="amount" min="1000" required>
            </div>
        <?php else: ?>
            <div style="margin-bottom: 1.5rem; text-align: center;">
                <p style="font-size: 1.2rem; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($courseDescription); ?></p>
                <p style="font-size: 1.5rem; font-weight: bold; color: #7E001F;">
                    <?php echo number_format($coursePrice); ?> TZS
                </p>
            </div>
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
            <?php if (!$type === 'tea'): ?>
                <input type="hidden" name="amount" value="<?php echo $coursePrice; ?>">
            <?php endif; ?>
            <input type="hidden" name="course" value="<?php echo $course; ?>">
            <input type="hidden" name="level" value="<?php echo $level; ?>">
            <button type="submit">Pay with Mobile Money</button>
        </form>
    </div>
</body>
</html>