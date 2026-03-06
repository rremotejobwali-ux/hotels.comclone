<?php require_once 'includes/header.php'; ?>

<div class="container">
    <h1 class="section-title" style="margin-top: 60px;">Today's Top Deals</h1>
    <p style="color: var(--text-light); margin-bottom: 40px;">Exclusive discounts for members. Save up to 40% on luxury stays.</p>

    <div class="hotel-grid">
        <?php
        try {
            // Fetch hotels and apply a "fake" discount or show high-rated ones
            $stmt = $pdo->query("SELECT * FROM hotels ORDER BY price ASC LIMIT 6");
            while ($hotel = $stmt->fetch()):
        ?>
        <div class="hotel-card" onclick="window.location.href='hotel.php?id=<?php echo $hotel['id']; ?>'">
            <div class="hotel-img-wrapper">
                <div style="position: absolute; top: 15px; left: 15px; background: var(--primary-color); color: white; padding: 6px 12px; border-radius: 6px; font-weight: 700; z-index: 10;">
                    30% OFF
                </div>
                <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>" class="hotel-img">
            </div>
            <div class="hotel-info">
                <div class="hotel-header">
                    <h3 class="hotel-name"><?php echo htmlspecialchars($hotel['name']); ?></h3>
                    <div class="hotel-rating"><?php echo $hotel['rating']; ?></div>
                </div>
                <div class="hotel-location"><?php echo htmlspecialchars($hotel['location']); ?></div>
                <div class="hotel-price">
                    <span style="text-decoration: line-through; color: #999; margin-right: 10px; font-size: 0.9rem;">$<?php echo number_format($hotel['price'] / 0.7, 0); ?></span>
                    $<?php echo number_format($hotel['price'], 0); ?> <span>night</span>
                </div>
            </div>
        </div>
        <?php endwhile; } catch(PDOException $e) {} ?>
    </div>
</div>

<div style="background: linear-gradient(to right, #ff385c, #d70466); color: white; padding: 80px 20px; text-align: center; margin-top: 100px; border-radius: 24px; max-width: 1200px; margin-left: auto; margin-right: auto;">
    <h2 style="font-size: 3rem; font-weight: 800; margin-bottom: 20px;">Unlock Secret Prices</h2>
    <p style="font-size: 1.25rem; margin-bottom: 40px; opacity: 0.9;">Sign up to see prices only members can access.</p>
    <a href="signup.php" class="search-btn" style="background: white; color: var(--primary-color); display: inline-flex; width: auto; padding: 16px 40px;">Join Now</a>
</div>

<?php require_once 'includes/footer.php'; ?>
