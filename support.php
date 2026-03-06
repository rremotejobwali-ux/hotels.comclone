<?php require_once 'includes/header.php'; ?>

<div class="container" style="max-width: 800px;">
    <h1 class="section-title" style="text-align: center; margin-top: 60px;">Customer Support</h1>
    <p style="text-align: center; color: var(--text-light); margin-bottom: 40px;">How can we help you today? Our team is available 24/7.</p>

    <div class="booking-card" style="padding: 40px;">
        <form action="#" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div class="form-group" style="padding: 0; border: none;">
                    <label style="font-weight: 700;">First Name</label>
                    <input type="text" placeholder="John" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none;">
                </div>
                <div class="form-group" style="padding: 0; border: none;">
                    <label style="font-weight: 700;">Last Name</label>
                    <input type="text" placeholder="Doe" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none;">
                </div>
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 20px;">
                <label style="font-weight: 700;">Email Address</label>
                <input type="email" placeholder="john@example.com" style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none;">
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 20px;">
                <label style="font-weight: 700;">Subject</label>
                <select style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none;">
                    <option>Booking Issues</option>
                    <option>Refund Request</option>
                    <option>Payment Problems</option>
                    <option>Account Support</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group" style="padding: 0; border: none; margin-bottom: 30px;">
                <label style="font-weight: 700;">Message</label>
                <textarea rows="5" placeholder="Describe your issue in detail..." style="width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 12px; outline: none; transition: border-color 0.3s;"></textarea>
            </div>

            <button type="submit" class="search-btn" style="width: 100%; justify-content: center; font-size: 1.1rem; padding: 16px;">Send Message</button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 60px; text-align: center;">
        <div style="background: var(--bg-light); padding: 30px; border-radius: 12px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📞</div>
            <h4 style="margin-bottom: 10px;">Call Us</h4>
            <p style="font-size: 0.9rem; color: var(--text-light);">+1 800 123 4567</p>
        </div>
        <div style="background: var(--bg-light); padding: 30px; border-radius: 12px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">✉️</div>
            <h4 style="margin-bottom: 10px;">Email Us</h4>
            <p style="font-size: 0.9rem; color: var(--text-light);">support@hotelsclone.com</p>
        </div>
        <div style="background: var(--bg-light); padding: 30px; border-radius: 12px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📍</div>
            <h4 style="margin-bottom: 10px;">Visit Us</h4>
            <p style="font-size: 0.9rem; color: var(--text-light);">123 Luxury Ave, CA</p>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
