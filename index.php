<?php require_once 'includes/header.php'; ?>

<section class="hero">
    <div class="hero-content">
        <h1>Find your next stay</h1>
        <form action="search.php" method="GET" class="search-box">
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" placeholder="Where are you going?" required>
            </div>
            
            <div class="form-group">
                <label for="check_in">Check-in</label>
                <input type="date" id="check_in" name="check_in" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="check_out">Check-out</label>
                <input type="date" id="check_out" name="check_out" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
            </div>
            
            <button type="submit" class="search-btn">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display:block;fill:none;height:16px;width:16px;stroke:currentColor;stroke-width:4;overflow:visible" aria-hidden="true" role="presentation" focusable="false"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11s-4.9248678-11-11-11-11 4.9248678-11 11 4.9248678 11 11 11zm8-3 9 9"></path></g></svg>
                Search
            </button>
        </form>
    </div>
</section>

<div class="container" style="margin-top: 80px;">
    <h2 class="section-title">Explore by Property Type</h2>
    <div style="display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scrollbar-width: none;">
        <?php
        $types = ['Hotel', 'Resort', 'Cabin', 'Apartment', 'Lodge', 'Chalet'];
        $typeImages = [
            'Hotel' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200&h=200&fit=crop',
            'Resort' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=200&h=200&fit=crop',
            'Cabin' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=200&h=200&fit=crop',
            'Apartment' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=200&h=200&fit=crop',
            'Lodge' => 'https://images.unsplash.com/photo-1516422213484-2143e80a092c?w=200&h=200&fit=crop',
            'Chalet' => 'https://images.unsplash.com/photo-1502784444187-359ac186c5bb?w=200&h=200&fit=crop'
        ];
        foreach($types as $t):
        ?>
        <a href="search.php?type[]=<?php echo $t; ?>" style="text-decoration: none; min-width: 150px; text-align: center;">
            <img src="<?php echo $typeImages[$t]; ?>" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 15px; border: 3px solid transparent; transition: border-color 0.3s;" onmouseover="this.style.borderColor='var(--primary-color)'" onmouseout="this.style.borderColor='transparent'">
            <h4 style="color: var(--text-main);"><?php echo $t; ?>s</h4>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="container" style="margin-bottom: 100px;">
    <h2 class="section-title">Inspiration for your next trip</h2>
    <div class="hotel-grid">
        <?php
        try {
            $stmt = $pdo->query("SELECT * FROM hotels ORDER BY rating DESC LIMIT 6");
            while ($hotel = $stmt->fetch()) {
                ?>
                <div class="hotel-card" onclick="window.location.href='hotel.php?id=<?php echo $hotel['id']; ?>'">
                    <div class="hotel-img-wrapper">
                        <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>" class="hotel-img">
                    </div>
                    <div class="hotel-info">
                        <div class="hotel-header">
                            <h3 class="hotel-name"><?php echo htmlspecialchars($hotel['name']); ?></h3>
                            <div class="hotel-rating"><?php echo $hotel['rating']; ?></div>
                        </div>
                        <div class="hotel-location"><?php echo htmlspecialchars($hotel['location']); ?></div>
                        <div class="hotel-price">$<?php echo number_format($hotel['price'], 0); ?> <span>night</span></div>
                    </div>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            echo "<p>Error loading featured hotels.</p>";
        }
        ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
