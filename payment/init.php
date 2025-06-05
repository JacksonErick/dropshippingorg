<?php
// Zenopay API Configuration
define('ZENOPAY_API_KEY', 'aCMAzrOwV81b9Tol-0rWRSwgvooiUj3oyiDhPXgDEZFEOwWucFIghYkcFYyks-KaBjH156mLLsSgUb2L8Lu4hA');
define('ZENOPAY_API_URL', 'https://api.zenopay.com/v1/'); // Update with actual API URL from docs
define('ZENOPAY_WEBHOOK_SECRET', 'your_webhook_secret'); // Set this in Zenopay dashboard

// Database configuration (for storing transactions)
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_pass');
define('DB_NAME', 'your_db_name');

// Site configuration
define('SITE_URL', 'https://binaryjack.online');
define('CURRENCY', 'USD');

// Initialize database connection
function getDB() {
    static $db = null;
    if ($db === null) {
        try {
            $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection error. Please try again later.");
        }
    }
    return $db;
}

// Make API request to Zenopay
function zenopayApiRequest($endpoint, $data = []) {
    $url = ZENOPAY_API_URL . $endpoint;
    
    $headers = [
        'Authorization: Bearer ' . ZENOPAY_API_KEY,
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode >= 400) {
        error_log("Zenopay API Error: HTTP $httpCode - $response");
        return false;
    }
    
    return json_decode($response, true);
}

// Verify webhook signature
function verifyWebhookSignature($payload, $signature) {
    $computedSignature = hash_hmac('sha256', $payload, ZENOPAY_WEBHOOK_SECRET);
    return hash_equals($computedSignature, $signature);
}

// Save transaction to database
function saveTransaction($data) {
    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO transactions 
                            (zenopay_id, order_id, amount, currency, status, created_at, customer_email, payment_method, raw_data) 
                            VALUES 
                            (:zenopay_id, :order_id, :amount, :currency, :status, NOW(), :customer_email, :payment_method, :raw_data)");
        
        $stmt->execute([
            ':zenopay_id' => $data['id'] ?? '',
            ':order_id' => $data['order_id'] ?? '',
            ':amount' => $data['amount'] ?? 0,
            ':currency' => $data['currency'] ?? CURRENCY,
            ':status' => $data['status'] ?? 'pending',
            ':customer_email' => $data['customer_email'] ?? '',
            ':payment_method' => $data['payment_method'] ?? '',
            ':raw_data' => json_encode($data)
        ]);
        
        return $db->lastInsertId();
    } catch(PDOException $e) {
        error_log("Failed to save transaction: " . $e->getMessage());
        return false;
    }
}

// Update transaction status
function updateTransactionStatus($zenopayId, $status, $additionalData = null) {
    try {
        $db = getDB();
        $sql = "UPDATE transactions SET status = :status, updated_at = NOW()";
        
        if ($additionalData) {
            $sql .= ", raw_data = JSON_MERGE_PATCH(raw_data, :additional_data)";
        }
        
        $sql .= " WHERE zenopay_id = :zenopay_id";
        
        $stmt = $db->prepare($sql);
        $params = [':status' => $status, ':zenopay_id' => $zenopayId];
        
        if ($additionalData) {
            $params[':additional_data'] = json_encode($additionalData);
        }
        
        return $stmt->execute($params);
    } catch(PDOException $e) {
        error_log("Failed to update transaction status: " . $e->getMessage());
        return false;
    }
}
?>