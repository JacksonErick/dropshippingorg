<?php
session_start();
require_once 'payment/init.php';
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Master Dropshipping, Forex Trading, and Cryptocurrency with our comprehensive courses">
    <title>BinaryJack Academy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            /* Light theme */
            --bg-primary: #000000;
            --bg-secondary: #111111;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --accent-primary: linear-gradient(135deg, #4f46e5, #7c3aed);
            --accent-secondary: #6366f1;
            --card-bg: rgba(17, 17, 17, 0.9);
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --border-color: #e2e8f0;
        }

        [data-theme="dark"] {
            --bg-primary: #000000;
            --bg-secondary: #111111;
            --text-primary: #f7fafc;
            --text-secondary: #e2e8f0;
            --accent-primary: linear-gradient(135deg, #4f46e5, #7c3aed);
            --accent-secondary: #6366f1;
            --card-bg: rgba(17, 17, 17, 0.9);
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            --border-color: #4a5568;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Images */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                url('https://images.pexels.com/photos/6771985/pexels-photo-6771985.jpeg'),
                url('https://images.pexels.com/photos/844124/pexels-photo-844124.jpeg'),
                url('https://images.pexels.com/photos/4482900/pexels-photo-4482900.jpeg');
            background-position: 
                right top,
                left center,
                right bottom;
            background-size: 
                30% auto,
                30% auto,
                30% auto;
            background-repeat: no-repeat;
            opacity: 0.1;
            animation: fadeIn 2s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 0.1; }
        }

        /* Floating Tea Cup */
        .tea-cup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: var(--accent-primary);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: float 3s ease-in-out infinite;
            z-index: 1000;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .tea-cup i {
            color: white;
            font-size: 24px;
        }

        /* Tea Cup Modal */
        .tea-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            z-index: 1001;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .tea-modal h3 {
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .tea-modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .tea-modal-buttons button {
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-weight: 500;
            transition: transform 0.2s;
        }

        .tea-modal-buttons button:hover {
            transform: scale(1.05);
        }

        .tea-yes {
            background: var(--accent-primary);
            color: white;
        }

        .tea-no {
            background: var(--bg-secondary);
            color: var(--text-secondary);
        }

        .course-card {
            background: var(--card-bg);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-block;
            background: var(--accent-primary);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-align: center;
            margin: 0.5rem 0;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        }

        /* Social Media Floating Icons */
        .social-float {
            position: fixed;
            bottom: 100px;
            right: 20px;
            display: none;
            flex-direction: column;
            gap: 1rem;
            z-index: 1000;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--accent-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: transform 0.3s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .social-icon:hover {
            transform: scale(1.1);
        }

        .social-icon.whatsapp { background: #25D366; }
        .social-icon.youtube { background: #FF0000; }
        .social-icon.telegram { background: #0088cc; }
        .social-icon.instagram { background: #E4405F; }

    </style>
</head>
<body>
    <!-- Social Media Floating Icons -->
    <div class="social-float" id="socialFloat">
        <a href="https://wa.me/255675979428" target="_blank" class="social-icon whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="https://www.youtube.com/@binaryjackk" target="_blank" class="social-icon youtube">
            <i class="fab fa-youtube"></i>
        </a>
        <a href="https://t.me/+9lwPyC0gKmUzMTQ8" target="_blank" class="social-icon telegram">
            <i class="fab fa-telegram"></i>
        </a>
        <a href="https://www.instagram.com/binary.jackk?igsh=azBxaXlyOWtpMWo3" target="_blank" class="social-icon instagram">
            <i class="fab fa-instagram"></i>
        </a>
    </div>

                <h2 class="course-title">Dropshipping Mastery</h2>
                <p class="course-description">Learn how to build and scale a successful dropshipping business from scratch.</p>
                <div class="course-levels">
                    <a href="payment/payment-form.php?course=dropshipping&level=1" class="btn">Level 1 - 35,000 TZS</a>
                    <a href="payment/payment-form.php?course=dropshipping&level=2" class="btn" style="margin-top: 0.5rem;">Level 2 - 45,000 TZS</a>
                    <a href="payment/payment-form.php?course=dropshipping&level=3" class="btn" style="margin-top: 0.5rem;">Level 3 - 55,000 TZS</a>
                </div>
            </div>
        </div>

                <h2 class="course-title">Forex Trading Pro</h2>
                <p class="course-description">Master forex trading strategies and technical analysis.</p>
                <div class="course-price">150,000 TZS</div>
                <a href="payment/payment-form.php?course=forex" class="btn">Pre-Order Now</a>
            </div>
        </div>

                <h2 class="course-title">Cryptocurrency & Blockchain</h2>
                <p class="course-description">Understand blockchain technology and crypto trading fundamentals.</p>
                <div class="course-price">150,000 TZS</div>
                <a href="payment/payment-form.php?course=crypto" class="btn">Pre-Order Now</a>
            </div>
        </div>

    <script>
        // Tea Cup and Social Icons Toggle
        const teaCup = document.querySelector('.tea-cup');
        const socialFloat = document.getElementById('socialFloat');
        
        teaCup.addEventListener('click', () => {
            socialFloat.style.display = socialFloat.style.display === 'flex' ? 'none' : 'flex';
        });

        // Theme Toggle
        const themeToggle = document.querySelector('.theme-toggle');
    </script>
</body>
</html>