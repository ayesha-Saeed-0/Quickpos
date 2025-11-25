<?php include __DIR__ . "/inc/header.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickPOS</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<!-- HERO SECTION -->
<section id="hero" class="hero-section">
    <div class="hero-content">
        <h1>QuickPOS – Simple & Fast POS for Small Businesses</h1>
        <p>Manage sales, inventory, and customers effortlessly with our modern POS system.</p>
        <a href="#contact" class="btn-primary">Get Started</a>
    </div>

    <div class="hero-image">
        <img src="assets/mockup.png" alt="POS Mockup">
    </div>
</section>

<!-- FEATURES -->
<section id="features" class="features">
    <h2>Features</h2>
    <div class="features-grid">
        <div class="feature-box">
            <h3>💳 Easy Sales</h3>
            <p>Quick and smooth sales process for busy shops.</p>
        </div>

        <div class="feature-box">
            <h3>📦 Inventory Tracking</h3>
            <p>Automatic low-stock alerts and product management.</p>
        </div>

        <div class="feature-box">
            <h3>📈 Reports</h3>
            <p>Daily, weekly, and monthly detailed reports.</p>
        </div>
    </div>
</section>

<!-- PRICING -->
<section id="pricing" class="pricing">
    <h2>Pricing Plans</h2>
    <div class="pricing-grid">

        <div class="pricing-box">
            <h3>Starter</h3>
            <p class="price">Free</p>
            <p>Basic features included</p>
        </div>

        <div class="pricing-box popular">
            <h3>Pro</h3>
            <p class="price">PKR 2,999/month</p>
            <p>Best for small shops</p>
        </div>

        <div class="pricing-box">
            <h3>Enterprise</h3>
            <p class="price">Contact Us</p>
            <p>Custom solutions</p>
        </div>

    </div>
</section>

<!-- CONTACT FORM -->
<section id="contact" class="contact">
    <h2>Contact Us</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">⚠️ <?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <form action="contact/form_handler.php" method="POST">
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Message</label>
        <textarea name="message" required></textarea>

        <button type="submit" class="btn-primary">Send Message</button>
    </form>
</section>

</body>

<?php include __DIR__ . "/inc/footer.php"; ?>
</html>
