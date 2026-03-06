<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_id = $_POST['hotel_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $user_name = $_POST['user_name'];

    // 1. Fetch Hotel Price
    $stmt = $pdo->prepare("SELECT price FROM hotels WHERE id = ?");
    $stmt->execute([$hotel_id]);
    $hotel = $stmt->fetch();

    if (!$hotel) {
        die("Hotel not found");
    }

    // 2. Calculate Nights
    $d1 = new DateTime($check_in);
    $d2 = new DateTime($check_out);
    $interval = $d1->diff($d2);
    $nights = $interval->days;

    if ($nights < 1) {
        die("Invalid dates. Check-out must be after check-in.");
    }

    $total_price = $nights * $hotel['price'];

    // 3. Insert Booking
    $stmt = $pdo->prepare("INSERT INTO bookings (hotel_id, user_name, check_in, check_out, total_price) VALUES (?, ?, ?, ?, ?)");
    
    try {
        $stmt->execute([$hotel_id, $user_name, $check_in, $check_out, $total_price]);
        $booking_id = $pdo->lastInsertId();
        header("Location: confirmation.php?id=$booking_id");
        exit;
    } catch (PDOException $e) {
        die("Booking failed: " . $e->getMessage());
    }
} else {
    header("Location: index.php"); // Redirect if accessed directly
}
