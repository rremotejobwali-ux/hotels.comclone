<?php
require_once 'includes/header.php';

$booking_id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("
    SELECT b.*, h.name as hotel_name, h.location, h.image_url 
    FROM bookings b 
    JOIN hotels h ON b.hotel_id = h.id 
    WHERE b.id = ?
");
$stmt->execute([$booking_id]);
$booking = $stmt->fetch();

if (!$booking) {
    echo "<div class='container'><h2>Booking found.</h2></div>";
    require_once 'includes/footer.php';
    exit;
}
?>

<div class="container" style="max-width: 800px; text-align: center;">
    <div style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="color: green; font-size: 3rem; margin-bottom: 20px;">✓</div>
        <h1 style="color: #333; margin-bottom: 10px;">Booking Confirmed!</h1>
        <p style="color: #666; margin-bottom: 30px;">Thank you for your booking, <?php echo htmlspecialchars($booking['user_name']); ?>. Your reservation is set.</p>

        <div style="text-align: left; background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <img src="<?php echo htmlspecialchars($booking['image_url']); ?>" alt="Hotel" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                <div>
                    <h3 style="margin-bottom: 5px;"><?php echo htmlspecialchars($booking['hotel_name']); ?></h3>
                    <p style="color: #666;">📍 <?php echo htmlspecialchars($booking['location']); ?></p>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border-top: 1px solid #ddd; padding-top: 20px;">
                <div>
                    <strong>Check-in</strong>
                    <div style="color: #555;"><?php echo $booking['check_in']; ?></div>
                </div>
                <div>
                    <strong>Check-out</strong>
                    <div style="color: #555;"><?php echo $booking['check_out']; ?></div>
                </div>
                <div>
                    <strong>Total Price</strong>
                    <div style="color: #d32f2f; font-weight: bold; font-size: 1.2rem;">$<?php echo number_format($booking['total_price'], 2); ?></div>
                </div>
                <div>
                    <strong>Booking ID</strong>
                    <div style="color: #555;">#<?php echo $booking['id']; ?></div>
                </div>
            </div>
        </div>

        <a href="index.php" class="search-btn" style="text-decoration: none; display: inline-block;">Return Home</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
