<?php
require_once 'init.php';

$paymentId = $_GET['id'] ?? null;

if (!$paymentId) {
    header('Location: payment-form.php');
    exit;
}

// Get transaction details
try {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM transactions WHERE zenopay_id = ?");
    $stmt->execute([$paymentId]);
    $transaction = $stmt->fetch();
} catch(PDOException $e) {
    error_log("Failed to fetch transaction: " . $e->getMessage());
    header('Location: payment-form.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process enrollment form submission
    $name = $_POST['enroll_name'] ?? '';
    $whatsapp = $_POST['enroll_whatsapp'] ?? '';
    $email = $_POST['enroll_email'] ?? '';
    
    // Handle file upload
    $screenshotPath = '';
    if (isset($_FILES['payment_screenshot']) && $_FILES['payment_screenshot']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = uniqid() . '_' . basename($_FILES['payment_screenshot']['name']);
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($_FILES['payment_screenshot']['tmp_name'], $targetPath)) {
            $screenshotPath = $targetPath;
        }
    }
    
    // Send email
    $to = 'kuzamarketonline@gmail.com';
    $subject = 'New Course Enrollment - Payment ID: ' . $paymentId;
    $message = "
        <h2>New Enrollment Details</h2>
        <p><strong>Transaction ID:</strong> $paymentId</p>
        <p><strong>Name:</strong> $name</p>
        <p><strong>WhatsApp:</strong> $whatsapp</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Course Level:</strong> " . ($transaction['raw_data']['course_level'] ?? 'N/A') . "</p>
        <p><strong>Amount:</strong> " . ($transaction['amount'] ?? '0') . " TZS</p>
    ";
    
    if ($screenshotPath) {
        $message .= "<p><strong>Screenshot:</strong> <a href='" . SITE_URL . "/$screenshotPath'>View Screenshot</a></p>";
    }
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: no-reply@kuzamarket.com\r\n";
    
    mail($to, $subject, $message, $headers);
    
    // Redirect to homepage
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Complete</title>
    <style>
        .enrollment-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .success-icon {
            color: #4CAF50;
            font-size: 4rem;
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input, textarea {
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
    <div class="enrollment-container">
        <div class="success-icon">✓</div>
        <h1 style="text-align: center;">Payment Successful!</h1>
        <p style="text-align: center;">Please complete your enrollment details below:</p>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="enroll_name">Full Name</label>
                <input type="text" id="enroll_name" name="enroll_name" required>
            </div>
            <div class="form-group">
                <label for="enroll_whatsapp">WhatsApp Number</label>
                <input type="tel" id="enroll_whatsapp" name="enroll_whatsapp" 
                       pattern="[0]{1}[0-9]{9}" placeholder="07XXXXXXXX" required>
            </div>
            <div class="form-group">
                <label for="enroll_email">Email Address</label>
                <input type="email" id="enroll_email" name="enroll_email" required>
            </div>
            <div class="form-group">
                <label for="payment_screenshot">Payment Screenshot</label>
                <input type="file" id="payment_screenshot" name="payment_screenshot" accept="image/*" required>
            </div>
            <button type="submit">Complete Enrollment</button>
        </form>
    </div>
</body>
</html>