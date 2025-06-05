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
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --accent-primary: linear-gradient(135deg, #2563eb, #7c3aed);
            --accent-secondary: #3b82f6;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --border-color: #e2e8f0;
        }

        [data-theme="dark"] {
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --text-primary: #f7fafc;
            --text-secondary: #e2e8f0;
            --accent-primary: linear-gradient(135deg, #3b82f6, #8b5cf6);
            --accent-secondary: #60a5fa;
            --card-bg: #2d3748;
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
        }

        /* Header Styles */
        header {
            background: var(--accent-primary);
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .theme-toggle {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0.5rem;
        }

        .mobile-menu {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 2rem 4rem;
            text-align: center;
            background: var(--bg-secondary);
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: var(--accent-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 3rem;
        }

        /* Course Grid */
        .courses {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .course-card {
            background: var(--card-bg);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .course-content {
            padding: 1.5rem;
        }

        .course-title {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .course-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .course-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--accent-secondary);
            margin-bottom: 1rem;
        }

        .btn {
            display: inline-block;
            background: var(--accent-primary);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.3s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow-y: auto;
        }

        .modal-content {
            background: var(--card-bg);
            margin: 5% auto;
            padding: 2rem;
            max-width: 700px;
            border-radius: 1rem;
            position: relative;
            animation: modalOpen 0.3s;
        }

        @keyframes modalOpen {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .close-modal {
            position: absolute;
            right: 1.5rem;
            top: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
        }

        .curriculum-list {
            margin: 2rem 0;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .curriculum-item {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .curriculum-item:last-child {
            border-bottom: none;
        }

        .curriculum-item i {
            color: var(--accent-secondary);
        }

        /* Cookie Consent */
        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--card-bg);
            padding: 1rem;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            display: none;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
        }

        /* Newsletter */
        .newsletter {
            background: var(--bg-secondary);
            padding: 4rem 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        .newsletter-form {
            max-width: 500px;
            margin: 2rem auto;
            display: flex;
            gap: 1rem;
        }

        .newsletter-form input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        /* FAQ Section */
        .faq {
            max-width: 800px;
            margin: 4rem auto;
            padding: 0 2rem;
        }

        .faq-item {
            border-bottom: 1px solid var(--border-color);
        }

        .faq-question {
            padding: 1rem 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 500;
        }

        .faq-answer {
            padding: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s;
            color: var(--text-secondary);
        }

        .faq-item.active .faq-answer {
            padding: 1rem 0;
            max-height: 1000px;
        }

        /* Footer */
        footer {
            background: var(--bg-secondary);
            padding: 4rem 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: var(--accent-secondary);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: var(--text-secondary);
            font-size: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--accent-primary);
                padding: 1rem;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .modal-content {
                margin: 10% 1rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="#" class="logo">BinaryJack</a>
            <nav class="nav-links">
                <a href="#courses">Courses</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <button class="theme-toggle" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>
            </nav>
            <div class="mobile-menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <section class="hero">
        <h1>Master the Digital Economy</h1>
        <p>Learn Dropshipping, Forex Trading, and Cryptocurrency from industry experts. Start your journey to financial freedom today.</p>
    </section>

    <div class="courses" id="courses">
        <!-- Dropshipping Course -->
        <div class="course-card">
            <img src="https://images.pexels.com/photos/4482900/pexels-photo-4482900.jpeg" alt="Dropshipping Course" class="course-image" loading="lazy">
            <div class="course-content">
                <h2 class="course-title">Dropshipping Mastery</h2>
                <p class="course-description">Learn how to build and scale a successful dropshipping business from scratch.</p>
                <button class="btn" onclick="openDropshippingModal()">Choose Level</button>
            </div>
        </div>

        <!-- Forex Course -->
        <div class="course-card">
            <img src="https://images.pexels.com/photos/6771985/pexels-photo-6771985.jpeg" alt="Forex Trading Course" class="course-image" loading="lazy">
            <div class="course-content">
                <h2 class="course-title">Forex Trading Pro</h2>
                <p class="course-description">Master forex trading strategies and technical analysis.</p>
                <div class="course-price">150,000 TZS</div>
                <button class="btn" onclick="openForexModal()">Pre-Order Now</button>
            </div>
        </div>

        <!-- Crypto Course -->
        <div class="course-card">
            <img src="https://images.pexels.com/photos/844124/pexels-photo-844124.jpeg" alt="Cryptocurrency Course" class="course-image" loading="lazy">
            <div class="course-content">
                <h2 class="course-title">Cryptocurrency & Blockchain</h2>
                <p class="course-description">Understand blockchain technology and crypto trading fundamentals.</p>
                <div class="course-price">150,000 TZS</div>
                <button class="btn" onclick="openCryptoModal()">Pre-Order Now</button>
            </div>
        </div>
    </div>

    <!-- Forex Modal -->
    <div id="forexModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeForexModal()">&times;</span>
            <h2>Forex Trading Pro Course</h2>
            <div class="curriculum-list">
                <div class="curriculum-item">
                    <i class="fas fa-book"></i>
                    <span>Introduction to Forex Trading</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Forex Trading Basics</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Fundamental Analysis</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-chart-pie"></i>
                    <span>Technical Analysis</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-brain"></i>
                    <span>Trading Strategies</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Risk & Psychology</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-laptop-code"></i>
                    <span>Trading Platforms & Tools</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-tasks"></i>
                    <span>Building a Trading Plan</span>
                </div>
            </div>
            <button class="btn enroll-btn" data-level="forex" data-price="150000">Pre-Order Now - 150,000 TZS</button>
        </div>
    </div>

    <!-- Crypto Modal -->
    <div id="cryptoModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeCryptoModal()">&times;</span>
            <h2>Cryptocurrency & Blockchain Course</h2>
            <div class="curriculum-list">
                <div class="curriculum-item">
                    <i class="fas fa-bitcoin"></i>
                    <span>Introduction to Cryptocurrency & Blockchain</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-coins"></i>
                    <span>Crypto Market Basics</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Fundamental Analysis (FA) in Crypto</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-chart-bar"></i>
                    <span>Technical Analysis (TA) for Crypto</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-brain"></i>
                    <span>Trading Strategies for Crypto</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Risk Management & Security</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-laptop-code"></i>
                    <span>Crypto Trading Platforms & Tools</span>
                </div>
                <div class="curriculum-item">
                    <i class="fas fa-rocket"></i>
                    <span>NFTs, DeFi, and Emerging Trends</span>
                </div>
            </div>
            <button class="btn enroll-btn" data-level="crypto" data-price="150000">Pre-Order Now - 150,000 TZS</button>
        </div>
    </div>

    <!-- Dropshipping Modal -->
    <div id="dropshippingModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeDropshippingModal()">&times;</span>
            <h2>Choose Your Dropshipping Course Level</h2>
            <div class="curriculum-list">
                <div class="course-card" style="margin-bottom: 1rem;">
                    <div class="course-content">
                        <h3>Level 1: Beginner Fundamentals</h3>
                        <p>Perfect for beginners starting their dropshipping journey.</p>
                        <div class="course-price">35,000 TZS</div>
                        <button class="btn enroll-btn" data-level="1" data-price="35000">Enroll Now</button>
                    </div>
                </div>
                <div class="course-card" style="margin-bottom: 1rem;">
                    <div class="course-content">
                        <h3>Level 2: Intermediate Growth</h3>
                        <p>For those ready to scale their dropshipping business.</p>
                        <div class="course-price">45,000 TZS</div>
                        <button class="btn enroll-btn" data-level="2" data-price="45000">Enroll Now</button>
                    </div>
                </div>
                <div class="course-card">
                    <div class="course-content">
                        <h3>Level 3: Advanced Scaling</h3>
                        <p>Master advanced strategies and automation.</p>
                        <div class="course-price">55,000 TZS</div>
                        <button class="btn enroll-btn" data-level="3" data-price="55000">Enroll Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <h2>Stay Updated</h2>
        <p>Subscribe to our newsletter for the latest course updates and trading insights.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Enter your email" required>
            <button type="submit" class="btn">Subscribe</button>
        </form>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-item">
            <div class="faq-question">
                <span>How do I access the course after purchase?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                After successful payment, you'll receive login credentials via email to access our learning platform.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Are the courses self-paced?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Yes, all our courses are self-paced. You can learn at your own convenience and revisit the materials anytime.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Do you offer refunds?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                We offer a 7-day money-back guarantee if you're not satisfied with the course content.
            </div>
        </div>
    </section>

    <!-- Cookie Consent Banner -->
    <div class="cookie-banner" id="cookieBanner">
        <p>We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.</p>
        <button class="btn" onclick="acceptCookies()">Accept</button>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#courses">Courses</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#privacy">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>Email: kuzamarketonline@gmail.com</p>
                <p>Phone: +255 675 979 428</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Newsletter</h3>
                <p>Subscribe to get updates on new courses and trading tips.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email">
                    <button type="submit" class="btn">Subscribe</button>
                </form>
            </div>
        </div>
    </footer>

    <script>
        // Theme Toggle
        const themeToggle = document.querySelector('.theme-toggle');
        const html = document.documentElement;
        const themeIcon = themeToggle.querySelector('i');

        function toggleTheme() {
            if (html.getAttribute('data-theme') === 'light') {
                html.setAttribute('data-theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
            } else {
                html.setAttribute('data-theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
            }
        }

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        themeIcon.classList.replace('fa-moon', savedTheme === 'dark' ? 'fa-sun' : 'fa-moon');

        themeToggle.addEventListener('click', toggleTheme);

        // Mobile Menu
        const mobileMenu = document.querySelector('.mobile-menu');
        const navLinks = document.querySelector('.nav-links');

        mobileMenu.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Modal Functions
        function openForexModal() {
            document.getElementById('forexModal').style.display = 'block';
        }

        function closeForexModal() {
            document.getElementById('forexModal').style.display = 'none';
        }

        function openCryptoModal() {
            document.getElementById('cryptoModal').style.display = 'block';
        }

        function closeCryptoModal() {
            document.getElementById('cryptoModal').style.display = 'none';
        }
        
        function openDropshippingModal() {
            document.getElementById('dropshippingModal').style.display = 'block';
        }
        
        function closeDropshippingModal() {
            document.getElementById('dropshippingModal').style.display = 'none';
        }

        // FAQ Accordion
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                faqItem.classList.toggle('active');
            });
        });

        // Cookie Consent
        function showCookieBanner() {
            if (!localStorage.getItem('cookiesAccepted')) {
                document.getElementById('cookieBanner').style.display = 'flex';
            }
        }

        function acceptCookies() {
            localStorage.setItem('cookiesAccepted', 'true');
            document.getElementById('cookieBanner').style.display = 'none';
        }

        // Show cookie banner on load
        window.addEventListener('load', showCookieBanner);

        // Payment Modal and Form Handling
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById("paymentModal");
            const enrollBtns = document.querySelectorAll(".enroll-btn");
            const closeBtn = document.querySelector(".close");
            const paymentForm = document.getElementById("paymentForm");
            const paymentStatus = document.getElementById("paymentStatus");
            
            enrollBtns.forEach(btn => {
                btn.addEventListener("click", function(e) {
                    e.preventDefault();
                    
                    const level = this.getAttribute("data-level");
                    const price = this.getAttribute("data-price");
                    
                    // Close the dropshipping modal if it's open
                    closeDropshippingModal();
                    
                    // Update form fields
                    document.getElementById("courseLevelDisplay").textContent = `Level ${level}`;
                    document.getElementById("coursePriceDisplay").textContent = price;
                    document.getElementById("amount").value = price;
                    document.getElementById("course_level").value = level;
                    document.getElementById("course_description").value = `Course Level ${level} Enrollment`;
                    
                    // Reset modal state
                    paymentForm.style.display = "block";
                    paymentStatus.style.display = "none";
                    
                    // Show modal
                    modal.style.display = "block";
                });
            });
            
            // Close modal
            if (closeBtn) {
                closeBtn.addEventListener("click", function() {
                    modal.style.display = "none";
                });
            }
            
            window.addEventListener("click", function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
            
            // Handle form submission
            const paymentFormElement = document.getElementById("zenoPaymentForm");
            if (paymentFormElement) {
                paymentFormElement.addEventListener("submit", function(e) {
                    // Show processing status
                    paymentForm.style.display = "none";
                    paymentStatus.style.display = "block";
                    
                    // Let the form submit normally
                    return true;
                });
            }
            
            // Check for payment status
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