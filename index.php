<?php
session_start();

// Capture errors and old form values from session
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QuickPOS - The Last POS System You'll Ever Need</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- AOS Animation Library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

<style>
/* Root Colors */
:root {
    --primary: #FF6B6B;      /* Coral */
    --primary-dark: #FF4757; /* Darker Coral */
    --secondary: #4ECDC4;    /* Teal */
    --dark: #1A1A1D;
    --gray: #888;
    --light-gray: #F1F2F6;
    --white: #FFFFFF;
}

/* Reset */
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Inter', sans-serif; line-height:1.6; color:var(--dark); overflow-x:hidden; }
html { scroll-behavior: smooth; }

/* Navigation */
nav { position:fixed; top:0; width:100%; background:rgba(255,255,255,0.95); backdrop-filter:blur(10px); z-index:1000; padding:1rem 0; box-shadow:0 1px 3px rgba(0,0,0,0.1);}
.nav-container { max-width:1200px; margin:0 auto; padding:0 2rem; display:flex; justify-content:space-between; align-items:center; }
.logo { font-size:1.75rem; font-weight:800; color:var(--primary); display:flex; align-items:center; gap:0.5rem; }
.logo i { font-size:2rem; }
.nav-links { display:flex; gap:2rem; list-style:none; align-items:center; }
.nav-links a { text-decoration:none; color:var(--dark); font-weight:500; transition:color 0.3s; }
.nav-links a:hover { color:var(--primary); }
.btn { padding:0.75rem 1.5rem; border-radius:8px; font-weight:600; cursor:pointer; transition:all 0.3s; border:none; text-decoration:none; display:inline-block; }
.btn-primary { background:var(--primary); color:var(--white); }
.btn-primary:hover { background:var(--primary-dark); transform:translateY(-3px) scale(1.05); box-shadow:0 10px 20px rgba(255,107,107,0.3); }
.btn-secondary { background:transparent; color:var(--primary); border:2px solid var(--primary); }
.btn-secondary:hover { background:var(--primary); color:var(--white); }
.mobile-menu-btn { display:none; font-size:1.5rem; background:none; border:none; color:var(--dark); cursor:pointer; }

/* Hero */
.hero {
    padding:120px 2rem 80px;
    background: linear-gradient(270deg, #FF6B6B, #4ECDC4, #FFD93D);
    background-size: 600% 600%;
    animation: gradientBG 15s ease infinite;
    color:var(--white);
    text-align:center;
    margin-top:70px;
}
@keyframes gradientBG {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.hero-container { max-width:1200px; margin:0 auto; }
.hero h1 { font-size:3.5rem; font-weight:800; margin-bottom:1.5rem; line-height:1.2; text-shadow:2px 2px 4px rgba(0,0,0,0.2); opacity:0; animation:fadeUp 1.5s forwards; }
.hero p { font-size:1.25rem; margin-bottom:2rem; opacity:0.9; max-width:600px; margin-left:auto; margin-right:auto; }
.hero-cta { margin-top:2rem; display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; }
.hero-image { margin-top:3rem; position:relative; }
.hero-image img { max-width:800px; width:100%; border-radius:15px; box-shadow:0 30px 60px rgba(0,0,0,0.3); opacity:0; animation:fadeUp 2s forwards; animation-delay:0.5s; }

/* Fade-up Animation */
@keyframes fadeUp {
    from { transform:translateY(20px); opacity:0; }
    to { transform:translateY(0); opacity:1; }
}

/* Features */
.features { padding:80px 2rem; background:var(--white); }
.section-title { text-align:center; margin-bottom:3rem; }
.section-title h2 { font-size:2.5rem; font-weight:800; margin-bottom:1rem; color:var(--dark); }
.section-title p { font-size:1.1rem; color:var(--gray); max-width:600px; margin:0 auto; }
.features-grid { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:2rem; }
.feature-card { padding:2rem; background:var(--light-gray); border-radius:12px; transition:all 0.4s; text-align:center; opacity:0; }
.feature-card:hover { transform:translateY(-10px) scale(1.03); box-shadow:0 20px 40px rgba(0,0,0,0.1); }
.feature-icon { width:70px; height:70px; background:linear-gradient(135deg,var(--primary),var(--secondary)); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1.5rem; font-size:2rem; color:var(--white); }
.feature-card h3 { font-size:1.5rem; margin-bottom:1rem; color:var(--dark); }
.feature-card p { color:var(--gray); line-height:1.7; }

/* Pricing */
.pricing { padding:80px 2rem; background:var(--light-gray); }
.pricing-grid { max-width:1200px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:2rem; margin-top:3rem; }
.pricing-card { background:var(--white); border-radius:15px; padding:2.5rem; text-align:center; box-shadow:0 5px 15px rgba(0,0,0,0.08); transition:all 0.3s; position:relative; opacity:0; }
.pricing-card:hover { transform:translateY(-10px) scale(1.02); box-shadow:0 20px 40px rgba(0,0,0,0.15); }
.pricing-card.featured { border:3px solid var(--primary); animation:glow 2s ease-in-out infinite alternate; }
@keyframes glow {
    from { box-shadow:0 0 15px rgba(255,107,107,0.3); }
    to { box-shadow:0 0 30px rgba(255,107,107,0.6); }
}
.pricing-badge { position:absolute; top:-15px; left:50%; transform:translateX(-50%); background:var(--primary); color:var(--white); padding:0.5rem 1.5rem; border-radius:20px; font-size:0.875rem; font-weight:600; }
.pricing-card h3 { font-size:1.75rem; margin-bottom:1rem; color:var(--dark); }
.price { font-size:3rem; font-weight:800; color:var(--primary); margin:1rem 0; }
.price span { font-size:1.25rem; color:var(--gray); }
.pricing-features { list-style:none; margin:2rem 0; text-align:left; }
.pricing-features li { padding:0.75rem 0; border-bottom:1px solid var(--light-gray); display:flex; align-items:center; gap:0.5rem; }
.pricing-features i { color:var(--secondary); }

/* Contact */
.contact { padding:80px 2rem; background:var(--white); }
.contact-container { max-width:600px; margin:0 auto; }
.form-group { margin-bottom:1.5rem; }
.form-group label { display:block; margin-bottom:0.5rem; font-weight:600; color:var(--dark); }
.form-group input, .form-group textarea { width:100%; padding:1rem; border:2px solid var(--light-gray); border-radius:8px; font-size:1rem; font-family:inherit; transition:all 0.3s; }
.form-group input:focus, .form-group textarea:focus { outline:none; border-color:var(--primary); box-shadow:0 0 10px rgba(255,107,107,0.3); }
.form-group textarea { resize:vertical; min-height:150px; }
.error-messages { color:red; margin-bottom:1rem; }

/* Footer */
footer { background:var(--dark); color:var(--white); padding:3rem 2rem 2rem; }
.footer-container { max-width:1200px; margin:0 auto; }
.footer-content { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:2rem; margin-bottom:2rem; }
.footer-section h3 { margin-bottom:1rem; color:var(--white); }
.social-links { display:flex; gap:1rem; margin-top:1rem; }
.social-links a { width:40px; height:40px; background:rgba(255,255,255,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--white); text-decoration:none; transition:all 0.3s; }
.social-links a:hover { background:var(--primary); transform:translateY(-3px) scale(1.2); }
.footer-bottom { text-align:center; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.1); color:var(--gray); }

/* Responsive */
@media (max-width:768px) {
    .mobile-menu-btn { display:block; }
    .nav-links { display:none; flex-direction:column; gap:1rem; background:#fff; padding:1rem; position:absolute; top:60px; right:20px; border-radius:8px; }
}
</style>
</head>
<body>

<!-- Navigation -->
<nav>
<div class="nav-container">
    <div class="logo"><i class="fas fa-cash-register"></i> QuickPOS</div>
    <ul class="nav-links">
        <li><a href="#features">Features</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="#contact">Contact</a></li>
        <li><a href="#" class="btn btn-primary">Sign Up</a></li>
    </ul>
    <button class="mobile-menu-btn"><i class="fas fa-bars"></i></button>
</div>
</nav>

<!-- Hero Section -->
<section class="hero">
<div class="hero-container">
    <h1>The Last POS System You'll Ever Need</h1>
    <p>Streamline your business operations with our powerful, easy-to-use point of sale system. Built for modern businesses.</p>
    <div class="hero-cta">
        <a href="#contact" class="btn btn-primary">Get Started for Free</a>
        <a href="#features" class="btn btn-secondary">Learn More</a>
    </div>
    <div class="hero-image">
        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=500&fit=crop" alt="QuickPOS Dashboard">
    </div>
</div>
</section>

<!-- Features Section -->
<section id="features" class="features">
<div class="section-title" data-aos="fade-up">
    <h2>Powerful Features for Your Business</h2>
    <p>Everything you need to manage your business efficiently in one place</p>
</div>
<div class="features-grid">
    <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-icon"><i class="fas fa-boxes"></i></div>
        <h3>Inventory Management</h3>
        <p>Track stock levels in real-time, set automatic reorder points, and never run out of your best-selling products.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
        <h3>Sales Analytics</h3>
        <p>Get detailed insights into your sales performance with beautiful dashboards and comprehensive reports.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-icon"><i class="fas fa-plug"></i></div>
        <h3>Easy Integration</h3>
        <p>Connect seamlessly with your existing tools including accounting software, e-commerce platforms, and more.</p>
    </div>
    <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
        <h3>Mobile Ready</h3>
        <p>Accept payments anywhere with our mobile app. Perfect for pop-up shops, events, and delivery services.</p>
    </div>
</div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="pricing">
<div class="section-title" data-aos="fade-up">
    <h2>Simple, Transparent Pricing</h2>
    <p>Choose the plan that's right for your business</p>
</div>
<div class="pricing-grid">
    <!-- Basic -->
    <div class="pricing-card" data-aos="fade-up" data-aos-delay="100">
        <h3>Basic</h3>
        <div class="price">$29<span>/mo</span></div>
        <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Up to 1,000 transactions</li>
            <li><i class="fas fa-check"></i> Basic inventory management</li>
            <li><i class="fas fa-check"></i> Sales reports</li>
            <li><i class="fas fa-check"></i> Email support</li>
            <li><i class="fas fa-check"></i> 1 location</li>
        </ul>
        <a href="#contact" class="btn btn-secondary">Get Started</a>
    </div>
    <!-- Pro -->
    <div class="pricing-card featured" data-aos="fade-up" data-aos-delay="200">
        <div class="pricing-badge">Most Popular</div>
        <h3>Pro</h3>
        <div class="price">$79<span>/mo</span></div>
        <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Unlimited transactions</li>
            <li><i class="fas fa-check"></i> Advanced inventory</li>
            <li><i class="fas fa-check"></i> Advanced analytics</li>
            <li><i class="fas fa-check"></i> Priority support</li>
            <li><i class="fas fa-check"></i> Up to 5 locations</li>
            <li><i class="fas fa-check"></i> API access</li>
        </ul>
        <a href="#contact" class="btn btn-primary">Get Started</a>
    </div>
    <!-- Enterprise -->
    <div class="pricing-card" data-aos="fade-up" data-aos-delay="300">
        <h3>Enterprise</h3>
        <div class="price">$199<span>/mo</span></div>
        <ul class="pricing-features">
            <li><i class="fas fa-check"></i> Everything in Pro</li>
            <li><i class="fas fa-check"></i> Unlimited locations</li>
            <li><i class="fas fa-check"></i> Custom integrations</li>
            <li><i class="fas fa-check"></i> Dedicated account manager</li>
            <li><i class="fas fa-check"></i> 24/7 phone support</li>
            <li><i class="fas fa-check"></i> Custom training</li>
        </ul>
        <a href="#contact" class="btn btn-secondary">Contact Sales</a>
    </div>
</div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact">
<div class="contact-container" data-aos="fade-up">
    <h2>Get In Touch</h2>
    <?php if(!empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="process-contact.php">
        <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="<?php echo $old['name'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?php echo $old['email'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required><?php echo $old['message'] ?? ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Send Message</button>
    </form>
</div>
</section>

<!-- Footer -->
<footer>
<div class="footer-container">
    <div class="footer-content">
        <div class="footer-section">
            <h3>QuickPOS</h3>
            <p>The modern point of sale system built for businesses that want to grow.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h3>Product</h3>
            <p><a href="#features" style="color:var(--gray); text-decoration:none;">Features</a></p>
            <p><a href="#pricing" style="color:var(--gray); text-decoration:none;">Pricing</a></p>
        </div>
        <div class="footer-section">
            <h3>Company</h3>
            <p><a href="#" style="color:var(--gray); text-decoration:none;">About Us</a></p>
            <p><a href="#contact" style="color:var(--gray); text-decoration:none;">Contact</a></p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 QuickPOS. All rights reserved.</p>
    </div>
</div>
</footer>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration:1200, once:true });

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if(target) target.scrollIntoView({ behavior:'smooth', block:'start' });
    });
});

const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
const navLinks = document.querySelector('.nav-links');
mobileMenuBtn.addEventListener('click', () => {
    navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
});
</script>
</body>
</html>
