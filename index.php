<?php
// Start session and include payment initialization
session_start();
require_once 'payment/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuzamarket Dropshipping Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --dark: #202020;
            --accent: #7E001F;
            --light-accent: #CEBBAA;
            --light: #F1EAE2;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        header {
            background-color: var(--dark);
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--light-accent);
        }
        
        .tagline {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .courses {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .course-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-10px);
        }
        
        .course-header {
            background-color: var(--accent);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .course-price {
            font-size: 2rem;
            font-weight: bold;
            margin: 1rem 0;
        }
        
        .course-content {
            padding: 1.5rem;
        }
        
        .course-content ul {
            list-style-type: none;
        }
        
        .course-content li {
            padding: 0.5rem 0;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .course-content li:before {
            content: "✓";
            color: var(--accent);
            position: absolute;
            left: 0;
            font-weight: bold;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            margin: 1rem 0;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .btn:hover {
            background-color: var(--dark);
            transform: scale(1.05);
        }
        
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #721003;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        
        footer {
            background-color: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 2rem;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            animation: modalopen 0.5s;
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: var(--dark);
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .form-group textarea {
            min-height: 100px;
        }
        
        .payment-success {
            text-align: center;
            padding: 2rem;
        }
        
        .payment-success i {
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }
        
        /* Status checking styles */
        .status-checking {
            text-align: center;
            padding: 2rem;
        }
        
        .status-checking i {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 1rem;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .courses {
                grid-template-columns: 1fr;
            }
            
            .modal-content {
                margin: 20% auto;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">BINARY JACK</div>
        <div class="tagline">Master Dropshipping</div>
    </header>
    
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 1rem;">Dropshipping Courses</h1>
        <p style="text-align: center; max-width: 700px; margin: 0 auto 2rem;">Choose the right level for your business growth. Our comprehensive courses will guide you from beginner to advanced dropshipping mastery.</p>
        
        <div class="courses">
            <!-- Level 1 Course -->
            <div class="course-card">
                <div class="course-header">
                    <h2>Level 1: Beginner Fundamentals</h2>
                    <div class="course-price">35,000 TZS</div>
                </div>
                <div class="course-content">
                    <ul>
                        <li>Introduction to Dropshipping</li>
                        <li>Choosing a Niche</li>
                        <li>Finding Reliable Suppliers</li>
                        <li>Setting Up Your Store</li>
                        <li>Product Selection Basics</li>
                        <li>Basic Marketing Overview</li>
                        <li>Legal and Financial Basics</li>
                    </ul>
                    <button class="btn enroll-btn" data-level="1" data-price="35000">APPLY NOW</button>
                </div>
            </div>
            
            <!-- Level 2 Course -->
            <div class="course-card">
                <div class="course-header">
                    <h2>Level 2: Intermediate Growth</h2>
                    <div class="course-price">45,000 TZS</div>
                </div>
                <div class="course-content">
                    <ul>
                        <li>Advanced Product Research</li>
                        <li>Store Optimization</li>
                        <li>Facebook/Instagram Ads Mastery</li>
                        <li>Email & SMS Marketing</li>
                        <li>Customer Service & Retention</li>
                        <li>Alternative Marketing Channels</li>
                        <li>Basic Automation</li>
                    </ul>
                    <button class="btn enroll-btn" data-level="2" data-price="45000">APPLY NOW</button>
                </div>
            </div>
            
            <!-- Level 3 Course -->
            <div class="course-card">
                <div class="course-header">
                    <h2>Level 3: Advanced Scaling</h2>
                    <div class="course-price">55,000 TZS</div>
                </div>
                <div class="course-content">
                    <ul>
                        <li>Advanced Facebook Ads</li>
                        <li>Building a Brand</li>
                        <li>Supply Chain Optimization</li>
                        <li>Advanced CRO & Funnel Building</li>
                        <li>Expanding Globally</li>
                        <li>Exit Strategies</li>
                        <li>Mindset & Business Management</li>
                    </ul>
                    <button class="btn enroll-btn" data-level="3" data-price="55000">APPLY NOW</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- WhatsApp Float Button -->
    <a href="https://wa.me/255675979428" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    
    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="paymentForm">
                <h2>Complete Your Enrollment</h2>
                <p>You're enrolling in <span id="courseLevelDisplay"></span> for <span id="coursePriceDisplay"></span> TZS</p>
                
                <form id="zenoPaymentForm" action="payment/process-payment.php" method="POST">
                    <div class="form-group">
                        <label for="buyer_name">Full Name</label>
                        <input type="text" id="buyer_name" name="buyer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="buyer_email">Email Address</label>
                        <input type="email" id="buyer_email" name="buyer_email" required>
                    </div>
                    <div class="form-group">
                        <label for="buyer_phone">Phone Number (Tanzanian)</label>
                        <input type="tel" id="buyer_phone" name="buyer_phone" pattern="[0]{1}[0-9]{9}" placeholder="07XXXXXXXX" required>
                        <small>Format: 07XXXXXXXX</small>
                    </div>
                    <input type="hidden" id="amount" name="amount">
                    <input type="hidden" id="course_level" name="course_level">
                    <input type="hidden" name="description" id="course_description">
                    <button type="submit" class="btn">PROCEED TO PAYMENT</button>
                </form>
            </div>
            
            <!-- Payment Status Section -->
            <div id="paymentStatus" style="display: none;">
                <div class="status-checking">
                    <i class="fas fa-spinner"></i>
                    <h3>Redirecting to Payment</h3>
                    <p>Please wait while we redirect you to the secure payment page...</p>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 Binaryjack Dropshipping Academy. All rights reserved.</p>
        <p>Contact: +255 675 979 428 | kuzamarketonline@gmail.com</p>
    </footer>
    
    <script>
    // Modal functionality - UPDATED VERSION
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("paymentModal");
        const enrollBtns = document.querySelectorAll(".enroll-btn");
        const closeBtn = document.querySelector(".close");
        const paymentForm = document.getElementById("paymentForm");
        const paymentStatus = document.getElementById("paymentStatus");
        
        // Debugging
        console.log("Modal elements loaded:", {
            modal, enrollBtns, closeBtn, paymentForm, paymentStatus
        });

        // Open modal when enroll button is clicked
        enrollBtns.forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                
                const level = this.getAttribute("data-level");
                const price = this.getAttribute("data-price");
                
                console.log("Button clicked - Level:", level, "Price:", price);
                
                // Update form fields
                document.getElementById("courseLevelDisplay").textContent = `Level ${level}`;
                document.getElementById("coursePriceDisplay").textContent = price;
                document.getElementById("amount").value = price;
                document.getElementById("course_level").value = level;
                document.getElementById("course_description").value = `Dropshipping Course Level ${level} Enrollment`;
                
                // Reset modal state
                paymentForm.style.display = "block";
                paymentStatus.style.display = "none";
                
                // Show modal
                modal.style.display = "block";
                console.log("Modal should be visible now");
            });
        });
        
        // Close modal
        closeBtn.addEventListener("click", function() {
            modal.style.display = "none";
        });
        
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
        
        // Handle form submission
        const paymentFormElement = document.getElementById("zenoPaymentForm");
        if (paymentFormElement) {
            paymentFormElement.addEventListener("submit", function(e) {
                console.log("Form submission started");
                // Show processing status
                paymentForm.style.display = "none";
                paymentStatus.style.display = "block";
                
                // Let the form submit normally
                return true;
            });
        } else {
            console.error("Payment form element not found!");
        }
        
        // Check for payment status in URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const paymentStatusParam = urlParams.get('payment_status');
        const paymentId = urlParams.get('payment_id');
        
        if (paymentStatusParam === 'success' && paymentId) {
            alert('Payment successful! Your enrollment is complete.');
        } else if (paymentStatusParam === 'failed') {
            alert('Payment was not completed. Please try again.');
        }
    });
</script>
</body>
</html>