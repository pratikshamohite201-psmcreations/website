<?php
/**
 * Main Configuration and Setup
 * This section handles session management and basic configurations
 */

// Start session for contact form and other features
session_start();

// Set error reporting for development (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get current page from URL parameter, default to 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Define site configuration
$site_config = [
    'site_name' => 'DevCraft Solutions',
    'tagline' => 'Crafting Digital Excellence',
    'email' => 'hello@devcraft.com',
    'phone' => '+1 (555) 123-4567'
];

/**
 * Contact Form Handler
 * Processes form submission when POST request is received
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Basic validation
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // In production, you would send email here using mail() or PHPMailer
        // For now, we'll store in session as success message
        $_SESSION['contact_success'] = "Thank you, $name! We'll get back to you soon.";
        
        // Optional: Save to database or send email
        // Example: mail($site_config['email'], "Contact Form: $name", $message, "From: $email");
        
        // Redirect to prevent form resubmission
        header("Location: index.php?page=contact&success=1");
        exit();
    } else {
        $_SESSION['contact_error'] = "Please fill all fields correctly.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_config['site_name']; ?> - <?php echo ucfirst($page); ?></title>
    
    <!-- Google Fonts for modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        /**
         * CSS RESET AND BASE STYLES
         * Modern reset for consistent cross-browser rendering
         */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            /* Color palette - Modern gradient theme */
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --accent: #14b8a6;
            --dark: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
            
            /* Spacing system */
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 2rem;
            --spacing-lg: 4rem;
            --spacing-xl: 6rem;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background: var(--light);
        }
        
        /**
         * NAVIGATION STYLES
         * Sticky header with smooth background transition
         */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        /* Animated underline effect on hover */
        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }
        
        .nav-menu a:hover::after,
        .nav-menu a.active::after {
            width: 100%;
        }
        
        .nav-menu a.active {
            color: var(--primary);
        }
        
        /**
         * HERO SECTION
         * Eye-catching animated gradient background
         */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
            padding: var(--spacing-md);
        }
        
        /* Animated background shapes */
        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -150px;
            left: -150px;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }
        
        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease;
        }
        
        .hero p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s backwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .cta-button {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: white;
            color: var(--primary-dark);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.4s backwards;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        /**
         * SECTION CONTAINER
         * Standard layout for all content sections
         */
        .section {
            max-width: 1200px;
            margin: 0 auto;
            padding: var(--spacing-xl) var(--spacing-md);
        }
        
        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: var(--spacing-lg);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /**
         * DELIVERABLES GRID
         * Card-based layout with hover effects
         */
        .deliverables-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: var(--spacing-lg);
        }
        
        .deliverable-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .deliverable-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.2);
            border-color: var(--primary);
        }
        
        .deliverable-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .deliverable-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }
        
        /**
         * ABOUT PAGE STYLES
         * Team and company information layout
         */
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .about-text h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .about-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
        }
        
        /**
         * CONTACT FORM STYLES
         * Modern form with validation feedback
         */
        .contact-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
        }
        
        /* Success/Error messages */
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 2px solid #10b981;
        }
        
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 2px solid #ef4444;
        }
        
        /**
         * FOOTER STYLES
         */
        .footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: var(--spacing-xl);
        }
        
        /* Responsive design for mobile devices */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
            .about-content { grid-template-columns: 1fr; }
            .nav-menu { flex-direction: column; gap: 1rem; }
        }
    </style>
</head>
<body>
    
    <!-- NAVIGATION BAR -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo"><?php echo $site_config['site_name']; ?></div>
            <ul class="nav-menu">
                <li><a href="?page=home" class="<?php echo $page === 'home' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="?page=about" class="<?php echo $page === 'about' ? 'active' : ''; ?>">About</a></li>
                <li><a href="?page=deliverables" class="<?php echo $page === 'deliverables' ? 'active' : ''; ?>">Deliverables</a></li>
                <li><a href="?page=contact" class="<?php echo $page === 'contact' ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- MAIN CONTENT AREA - Dynamic content based on page parameter -->
    <?php
    /**
     * PAGE ROUTING LOGIC
     * Uses switch statement to load different page content
     */
    switch($page) {
        case 'home':
            ?>
            <!-- HOME PAGE - Hero Section -->
            <section class="hero">
                <div class="hero-content">
                    <h1>Welcome to <?php echo $site_config['site_name']; ?></h1>
                    <p><?php echo $site_config['tagline']; ?></p>
                    <p>We transform ideas into stunning digital experiences. Your vision, our expertise.</p>
                    <a href="?page=contact" class="cta-button">Start Your Project</a>
                </div>
            </section>
            
            <section class="section">
                <h2 class="section-title">Why Choose Us?</h2>
                <div class="deliverables-grid">
                    <div class="deliverable-card">
                        <div class="deliverable-icon">⚡</div>
                        <h3>Lightning Fast</h3>
                        <p>Optimized code and modern technologies ensure blazing-fast websites.</p>
                    </div>
                    <div class="deliverable-card">
                        <div class="deliverable-icon">🎨</div>
                        <h3>Creative Design</h3>
                        <p>Beautiful, user-friendly interfaces that captivate your audience.</p>
                    </div>
                    <div class="deliverable-card">
                        <div class="deliverable-icon">🔒</div>
                        <h3>Secure & Reliable</h3>
                        <p>Enterprise-grade security and 99.9% uptime guarantee.</p>
                    </div>
                </div>
            </section>
            <?php
            break;
            
        case 'about':
            ?>
            <!-- ABOUT PAGE -->
            <div style="margin-top: 80px;"></div>
            <section class="section">
                <h2 class="section-title">About Us</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h2>We Build Digital Dreams</h2>
                        <p style="margin-bottom: 1rem;">
                            Founded in 2024, <?php echo $site_config['site_name']; ?> is a passionate team 
                            of developers, designers, and digital strategists committed to creating 
                            exceptional web experiences.
                        </p>
                        <p style="margin-bottom: 1rem;">
                            Our mission is to empower businesses with cutting-edge technology and 
                            innovative solutions that drive growth and success in the digital age.
                        </p>
                        <p>
                            <strong>Our Values:</strong><br>
                            • Innovation First<br>
                            • Client Success<br>
                            • Quality Craftsmanship<br>
                            • Transparent Communication
                        </p>
                    </div>
                    <div class="about-image">
                        🚀
                    </div>
                </div>
            </section>
            <?php
            break;
            
        case 'deliverables':
            ?>
            <!-- DELIVERABLES PAGE -->
            <div style="margin-top: 80px;"></div>
            <section class="section">
                <h2 class="section-title">Our Deliverables</h2>
                <p style="text-align: center; max-width: 600px; margin: 0 auto 3rem;">
                    We offer comprehensive web development solutions tailored to your business needs.
                </p>
                
                <div class="deliverables-grid">
                    <?php
                    /**
                     * DELIVERABLES DATA ARRAY
                     * Storing deliverables in an array for easy management
                     */
                    $deliverables = [
                        ['icon' => '🌐', 'title' => 'Custom Websites', 'desc' => 'Fully responsive, custom-built websites tailored to your brand identity.'],
                        ['icon' => '🛒', 'title' => 'E-Commerce Solutions', 'desc' => 'Powerful online stores with secure payment integration and inventory management.'],
                        ['icon' => '📱', 'title' => 'Web Applications', 'desc' => 'Scalable web apps with advanced functionality and seamless user experience.'],
                        ['icon' => '🎯', 'title' => 'SEO Optimization', 'desc' => 'Search engine optimization to boost your visibility and organic traffic.'],
                        ['icon' => '🔧', 'title' => 'Maintenance & Support', 'desc' => '24/7 technical support and regular updates to keep your site running smoothly.'],
                        ['icon' => '📊', 'title' => 'Analytics Integration', 'desc' => 'Data-driven insights with comprehensive analytics and reporting tools.'],
                    ];
                    
                    // Loop through deliverables array and display cards
                    foreach ($deliverables as $item) {
                        echo "<div class='deliverable-card'>";
                        echo "<div class='deliverable-icon'>{$item['icon']}</div>";
                        echo "<h3>{$item['title']}</h3>";
                        echo "<p>{$item['desc']}</p>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </section>
            <?php
            break;
            
        case 'contact':
            ?>
            <!-- CONTACT PAGE -->
            <div style="margin-top: 80px;"></div>
            <section class="section">
                <h2 class="section-title">Get In Touch</h2>
                <div class="contact-container">
                    <?php
                    // Display success message if form was submitted successfully
                    if (isset($_SESSION['contact_success'])) {
                        echo "<div class='alert alert-success'>{$_SESSION['contact_success']}</div>";
                        unset($_SESSION['contact_success']);
                    }
                    
                    // Display error message if validation failed
                    if (isset($_SESSION['contact_error'])) {
                        echo "<div class='alert alert-error'>{$_SESSION['contact_error']}</div>";
                        unset($_SESSION['contact_error']);
                    }
                    ?>
                    
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required placeholder="John Doe">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required placeholder="john@example.com">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required placeholder="Tell us about your project..."></textarea>
                        </div>
                        
                        <button type="submit" name="contact_submit" class="submit-btn">Send Message</button>
                    </form>
                    
                    <div style="margin-top: 2rem; text-align: center;">
                        <p><strong>Email:</strong> <?php echo $site_config['email']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $site_config['phone']; ?></p>
                    </div>
                </div>
            </section>
            <?php
            break;
            
        default:
            // 404 Page - Shown when invalid page parameter is provided
            echo "<div style='margin-top: 80px; text-align: center; padding: 4rem;'>";
            echo "<h1 style='font-size: 4rem;'>404</h1>";
            echo "<p>Page not found. <a href='?page=home'>Go to homepage</a></p>";
            echo "</div>";
    }
    ?>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> <?php echo $site_config['site_name']; ?>. All rights reserved.</p>
        <p>Built with passion using PHP</p>
    </footer>

</body>
</html>