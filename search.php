<?php 
require_once 'includes/header.php'; 

$location = $_GET['location'] ?? '';
$check_in = $_GET['check_in'] ?? '';
$check_out = $_GET['check_out'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 1000;
$type = $_GET['type'] ?? []; 
$sort = $_GET['sort'] ?? 'price_asc';

// Base Query
$sql = "SELECT * FROM hotels WHERE 1=1";
$params = [];

if ($location) {
    $sql .= " AND (location LIKE ? OR name LIKE ?)";
    $params[] = "%$location%";
    $params[] = "%$location%";
}

if ($min_price) {
    $sql .= " AND price >= ?";
    $params[] = $min_price;
}

if ($max_price) {
    $sql .= " AND price <= ?";
    $params[] = $max_price;
}

if (!empty($type)) {
    $placeholders = str_repeat('?,', count($type) - 1) . '?';
    $sql .= " AND type IN ($placeholders)";
    $params = array_merge($params, $type);
}

// Sorting
switch ($sort) {
    case 'price_desc':
        $sql .= " ORDER BY price DESC";
        break;
    case 'rating_desc':
        $sql .= " ORDER BY rating DESC";
        break;
    case 'rating_asc':
        $sql .= " ORDER BY rating ASC";
        break;
    default:
        $sql .= " ORDER BY price ASC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$hotels = $stmt->fetchAll();

$typesStmt = $pdo->query("SELECT DISTINCT type FROM hotels ORDER BY type");
$availableTypes = $typesStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="search-container">
    <aside class="filters">
        <form action="search.php" method="GET" id="filterForm">
            <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
            <input type="hidden" name="check_in" value="<?php echo htmlspecialchars($check_in); ?>">
            <input type="hidden" name="check_out" value="<?php echo htmlspecialchars($check_out); ?>">
            
            <div class="filter-group">
                <h4>Sort Results</h4>
                <select name="sort" class="sort-select" onchange="this.form.submit()" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd;">
                    <option value="price_asc" <?php if($sort == 'price_asc') echo 'selected'; ?>>Price: Lowest first</option>
                    <option value="price_desc" <?php if($sort == 'price_desc') echo 'selected'; ?>>Price: Highest first</option>
                    <option value="rating_desc" <?php if($sort == 'rating_desc') echo 'selected'; ?>>Top Rated</option>
                </select>
            </div>

            <div class="filter-group">
                <h4>Property Type</h4>
                <?php foreach($availableTypes as $t): ?>
                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <input type="checkbox" name="type[]" value="<?php echo htmlspecialchars($t); ?>" 
                        <?php if(in_array($t, $type)) echo 'checked'; ?> 
                        onchange="this.form.submit()" style="width: 20px; height: 20px; accent-color: var(--primary-color);">
                        <span style="font-size: 1rem; color: #444;"><?php echo htmlspecialchars($t); ?></span>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="filter-group">
                <h4>Price Range</h4>
                <div class="range-wrap">
                    <label style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Max per night</span>
                        <span style="font-weight: 700;">$<?php echo $max_price; ?></span>
                    </label>
                    <input type="range" name="max_price" min="0" max="1000" step="50" value="<?php echo $max_price; ?>" oninput="this.nextElementSibling.value = this.value" onchange="this.form.submit()">
                </div>
            </div>
            
            <button type="submit" class="search-btn" style="width: 100%; border-radius: 8px; justify-content: center;">Apply Filters</button>
        </form>
    </aside>

    <main>
        <h2 class="section-title" style="font-size: 1.5rem; margin-bottom: 24px;">
            <?php echo count($hotels); ?> properties found 
            <?php if($location) echo "in " . htmlspecialchars($location); ?>
        </h2>
        
        <?php if ($hotels): ?>
            <div class="hotel-grid">
                <?php foreach ($hotels as $hotel): ?>
                <div class="hotel-card" onclick="window.location.href='hotel.php?id=<?php echo $hotel['id']; ?>&check_in=<?php echo $check_in; ?>&check_out=<?php echo $check_out; ?>'">
                    <div class="hotel-img-wrapper">
                        <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>" class="hotel-img">
                    </div>
                    <div class="hotel-info">
                        <div class="hotel-header">
                            <h3 class="hotel-name"><?php echo htmlspecialchars($hotel['name']); ?></h3>
                            <div class="hotel-rating"><?php echo $hotel['rating']; ?></div>
                        </div>
                        <div class="hotel-location"><?php echo htmlspecialchars($hotel['location']); ?></div>
                        <p style="font-size: 0.9rem; color: #717171; margin-bottom: 12px; height: 40px; overflow: hidden;"><?php echo htmlspecialchars($hotel['description']); ?></p>
                        <div class="hotel-price">$<?php echo number_format($hotel['price'], 0); ?> <span>night</span></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px 20px; background: var(--bg-light); border-radius: 16px; margin-top: 40px;">
                <h2 style="margin-bottom: 10px;">No matches for "<?php echo htmlspecialchars($location); ?>"</h2>
                <p style="color: var(--text-light); margin-bottom: 30px;">But here are some other top destinations you might like!</p>
                
                <div class="hotel-grid">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM hotels ORDER BY rating DESC LIMIT 3");
                    while($f = $stmt->fetch()):
                    ?>
                    <div class="hotel-card" onclick="window.location.href='hotel.php?id=<?php echo $f['id']; ?>'">
                        <div class="hotel-img-wrapper">
                            <img src="<?php echo htmlspecialchars($f['image_url']); ?>" alt="<?php echo htmlspecialchars($f['name']); ?>" class="hotel-img">
                        </div>
                        <div class="hotel-info">
                            <div class="hotel-header">
                                <h3 class="hotel-name"><?php echo htmlspecialchars($f['name']); ?></h3>
                                <div class="hotel-rating"><?php echo $f['rating']; ?></div>
                            </div>
                            <div class="hotel-location"><?php echo htmlspecialchars($f['location']); ?></div>
                            <div class="hotel-price">$<?php echo number_format($f['price'], 0); ?> <span>night</span></div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<?php require_once 'includes/footer.php'; ?>
