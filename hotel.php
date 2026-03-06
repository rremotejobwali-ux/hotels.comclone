<?php 
require_once 'includes/header.php'; 

$id = $_GET['id'] ?? 0;
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$id]);
$hotel = $stmt->fetch();

if (!$hotel) {
    echo "<div class='container' style='text-align:center; padding: 100px 0;'><h1>Page not found</h1><p>The hotel you are looking for does not exist.</p><a href='index.php' class='search-btn' style='display:inline-block; margin-top:20px;'>Go Home</a></div>";
    require_once 'includes/footer.php';
    exit;
}

$amenities = explode(',', $hotel['amenities']);
?>

<div class="container" style="margin-top: 40px;">
    <div class="hotel-header" style="align-items: flex-end; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 8px;"><?php echo htmlspecialchars($hotel['name']); ?></h1>
            <div style="display: flex; gap: 12px; align-items: center; color: var(--text-main); font-weight: 500;">
                <span class="hotel-rating">★ <?php echo $hotel['rating']; ?></span>
                <span>•</span>
                <span style="text-decoration: underline; cursor: pointer;"><?php echo htmlspecialchars($hotel['location']); ?></span>
            </div>
        </div>
        <div style="display: flex; gap: 16px;">
            <button class="nav-links a" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; text-decoration: underline;">
                Share
            </button>
            <button class="nav-links a" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px; font-weight: 600; text-decoration: underline;">
                Save
            </button>
        </div>
    </div>

    <!-- Premium Gallery Look -->
    <div class="details-gallery">
        <div class="main-img">
            <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" class="gallery-img" alt="Main View">
        </div>
        <div>
            <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="gallery-img" alt="Gallery 1" style="border-bottom: 12px solid var(--white);">
            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="gallery-img" alt="Gallery 2">
        </div>
    </div>

    <div class="hotel-details-grid">
        <div class="details-left">
            <div style="padding: 32px 0; border-bottom: 1px solid #ebebeb;">
                <h2 style="font-size: 1.5rem; font-weight: 700;">Entire rental unit hosted by Premium Stays</h2>
                <p style="color: var(--text-light); margin-top: 4px;">2 guests • 1 bedroom • 1 bed • 1 bath</p>
            </div>

            <div style="padding: 32px 0; border-bottom: 1px solid #ebebeb;">
                <h3 style="margin-bottom: 16px; font-size: 1.3rem;">What this place offers</h3>
                <div class="amenities-list">
                    <?php foreach($amenities as $amenity): ?>
                        <div style="display: flex; align-items: center; gap: 12px; width: 45%; margin-bottom: 16px;">
                            <span style="font-size: 1.2rem;">✨</span>
                            <span style="font-size: 1rem; color: var(--text-main);"><?php echo trim($amenity); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div style="padding: 32px 0;">
                <h3 style="margin-bottom: 16px; font-size: 1.3rem;">Description</h3>
                <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                    <?php echo nl2br(htmlspecialchars($hotel['description'])); ?>
                </p>
            </div>
        </div>

        <aside class="details-right">
            <div class="booking-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <div style="font-size: 1.5rem; font-weight: 800;">$<?php echo number_format($hotel['price'], 0); ?> <span style="font-weight: 400; font-size: 1rem; color: var(--text-light);">night</span></div>
                    <div class="hotel-rating">★ <?php echo $hotel['rating']; ?></div>
                </div>

                <form action="book.php" method="POST">
                    <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
                    <div style="border: 1px solid #b0b0b0; border-radius: 8px; margin-bottom: 16px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; border-bottom: 1px solid #b0b0b0;">
                            <div style="padding: 10px 12px; border-right: 1px solid #b0b0b0;">
                                <label style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Check-in</label>
                                <input type="date" name="check_in" value="<?php echo $check_in; ?>" required min="<?php echo date('Y-m-d'); ?>" style="border:none; width:100%; font-size:0.9rem; padding: 4px 0; outline:none;">
                            </div>
                            <div style="padding: 10px 12px;">
                                <label style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Check-out</label>
                                <input type="date" name="check_out" value="<?php echo $check_out; ?>" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" style="border:none; width:100%; font-size:0.9rem; padding: 4px 0; outline:none;">
                            </div>
                        </div>
                        <div style="padding: 10px 12px;">
                            <label style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Guest Name</label>
                            <input type="text" name="user_name" placeholder="Who's coming?" required style="border:none; width:100%; font-size:0.9rem; padding: 4px 0; outline:none;">
                        </div>
                    </div>

                    <button type="submit" class="search-btn" style="width: 100%; border-radius: 8px; font-size: 1rem; padding: 14px; justify-content: center;">
                        Reserve Now
                    </button>
                    <p style="text-align: center; margin-top: 12px; color: var(--text-light); font-size: 0.85rem;">You won't be charged yet</p>
                </form>

                <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; text-decoration: underline;">
                        <span>$<?php echo number_format($hotel['price'], 0); ?> x 5 nights</span>
                        <span>$<?php echo number_format($hotel['price'] * 5, 0); ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; text-decoration: underline;">
                        <span>Service fee</span>
                        <span>$0</span>
                    </div>
                    <hr style="border: 0.5px solid #ebebeb;">
                    <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 1.1rem; margin-top: 8px;">
                        <span>Total (USD)</span>
                        <span>$<?php echo number_format($hotel['price'] * 5, 0); ?></span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
