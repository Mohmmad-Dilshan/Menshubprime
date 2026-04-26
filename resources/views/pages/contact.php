<?php
include ROOT_PATH . '/includes/header.php';
include 'config/db.php';

$msg = "";

if(isset($_POST['send'])){
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  mysqli_query($conn,"INSERT INTO messages(name,email,message,date)
  VALUES('$name','$email','$message',NOW())");

  $msg = "✅ Message received! We'll reach out soon.";
}
?>

<style>
/* PREMIUM CONTACT STYLES */
.contact-hero {
    padding: 140px 0 60px;
    background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 40%),
                radial-gradient(circle at bottom right, rgba(249, 115, 22, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.c-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(37, 99, 235, 0.1);
    border: 1px solid rgba(37, 99, 235, 0.2);
    border-radius: 100px;
    color: #3b82f6;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.contact-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.contact-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.contact-container {
    padding: 40px 20px 100px;
    max-width: 1100px;
    margin: 0 auto;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    align-items: start;
}

/* LEFT: INFO */
.contact-info-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-item {
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 24px;
    border-radius: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: 0.3s;
}

.info-item:hover {
    background: rgba(15, 23, 42, 0.6);
    border-color: rgba(37, 99, 235, 0.2);
    transform: translateX(10px);
}

.info-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #3b82f6;
}

.info-content h4 {
    color: #fff;
    margin-bottom: 5px;
    font-size: 15px;
}

.info-content p {
    margin: 0;
    color: #94a3b8;
    font-size: 14px;
}

.c-social-icons {
    margin-top: 40px;
}

.c-social-icons h4 {
    color: #fff;
    margin-bottom: 20px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.social-strip {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.s-circle {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    transition: 0.3s;
}

.s-circle:hover {
    background: #3b82f6;
    transform: translateY(-5px) rotate(10deg);
}

/* RIGHT: FORM */
.c-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 32px;
    padding: 45px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    opacity: 0.8;
}

.c-input {
    width: 100%;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 16px 18px;
    color: #fff;
    font-size: 15px;
    font-family: inherit;
    transition: 0.3s;
    outline: none;
}

.c-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #3b82f6;
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.1);
}

.c-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    border: none;
    border-radius: 16px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.c-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
}

.c-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #4ade80;
    padding: 16px;
    border-radius: 14px;
    margin-bottom: 25px;
    text-align: center;
    font-weight: 600;
}

@media (max-width: 900px) {
    .contact-grid { grid-template-columns: 1fr; }
    .contact-hero { padding-top: 120px; }
    .contact-hero h1 { font-size: 44px; }
    .c-glass-card { padding: 30px; }
    .c-input { padding: 16px 3px; }
}
</style>

<div class="contact-hero">
    <div class="c-badge"><i class="fas fa-paper-plane"></i> Get in Touch</div>
    <h1>Contact <span style="color:#3b82f6">Support</span></h1>
    <p>Available 24/7 for your queries, sponsorship requests, or just a quick "Hi". We value every connection.</p>
</div>

<div class="contact-container">
    <div class="contact-grid">
        
        <!-- LEFT COLLUMN -->
        <div class="contact-info">
            <div class="contact-info-list">
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <h4>Direct Email</h4>
                        <p>thezayanway@gmail.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fab fa-telegram-plane"></i></div>
                    <div class="info-content">
                        <h4>Telegram Support</h4>
                        <p>@Thezayanway Official</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <div class="info-content">
                        <h4>Typical Response</h4>
                        <p>Under 2 - 4 business hours</p>
                    </div>
                </div>
            </div>

            <div class="c-social-icons">
                <h4>Digital Footprint</h4>
                <div class="social-strip">
                    <a href="https://instagram.com/thezayanway" target="_blank" class="s-circle"><i class="fab fa-instagram"></i></a>
                    <a href="https://t.me/thezayanway" target="_blank" class="s-circle"><i class="fab fa-telegram-plane"></i></a>
                    <a href="https://pinterest.com/thezayanway" target="_blank" class="s-circle"><i class="fab fa-pinterest-p"></i></a>
                    <a href="https://x.com/thezayanway" target="_blank" class="s-circle"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- RIGHT COLLUMN -->
        <div class="c-glass-card">
            <?php if($msg!=""){ ?>
                <div class="c-success"><?php echo $msg; ?></div>
            <?php } ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input class="c-input" type="text" name="name" placeholder="John Doe" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input class="c-input" type="email" name="email" placeholder="john@example.com" required>
                </div>

                <div class="form-group">
                    <label>Your Message</label>
                    <textarea class="c-input" name="message" placeholder="Ask us anything..." rows="5" required></textarea>
                </div>

                <button class="c-btn" name="send" type="submit">
                    Send Message <i class="fas fa-long-arrow-alt-right"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<section class="brand-wrap">
  <div class="brand-box">
    <h3>Built for <span>Smart Men</span></h3>
    <p>
      MenHub Prime curates the best deals for you —  
      so you don’t waste time searching.
    </p>
  </div>
</section>

<hr style="border:0; border-top: 1px solid rgba(255,255,255,0.05);">

<?php include ROOT_PATH . '/includes/footer.php'; ?>






