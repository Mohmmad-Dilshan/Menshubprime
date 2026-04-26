<?php 
include ROOT_PATH . '/includes/header.php'; 
include 'config/db.php';

$msg = "";

if(isset($_POST['submit'])){
  $brand = mysqli_real_escape_string($conn, $_POST['brand_name']);
  $name = mysqli_real_escape_string($conn, $_POST['person_name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $website = mysqli_real_escape_string($conn, $_POST['website']);
  $message = mysqli_real_escape_string($conn, $_POST['message']);

  mysqli_query($conn,"INSERT INTO collaborations 
  (brand_name,your_name,email,product_link,message)
  VALUES
  ('$brand','$name','$email','$website','$message')");

  $msg = "✅ Proposal received! We'll review and get back to you.";
}
?>

<style>
/* PREMIUM COLLABORATION STYLES */
.collab-hero {
    padding: 140px 0 60px;
    background: radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 40%),
                radial-gradient(circle at bottom left, rgba(34, 197, 94, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.co-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(249, 115, 22, 0.1);
    border: 1px solid rgba(249, 115, 22, 0.2);
    border-radius: 100px;
    color: #f97316;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.collab-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.collab-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
}

.collab-container {
    padding: 40px 20px 100px;
    max-width: 1100px;
    margin: 0 auto;
}

.collab-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    align-items: start;
}

/* LEFT: INFO & BENEFITS */
.benefit-card {
    background: rgba(15, 23, 42, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 24px;
    border-radius: 24px;
    margin-bottom: 20px;
    transition: 0.3s;
}

.benefit-card:hover {
    background: rgba(15, 23, 42, 0.6);
    border-color: rgba(249, 115, 22, 0.2);
    transform: translateX(10px);
}

.benefit-card h4 {
    color: #fff;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 17px;
}

.benefit-card h4 i {
    color: #f97316;
}

.benefit-card p {
    margin: 0;
    color: #94a3b8;
    font-size: 14px;
    line-height: 1.6;
}

/* RIGHT: FORM */
.co-glass-card {
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

.co-input {
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

.co-input:focus {
    background: rgba(255, 255, 255, 0.08);
    border-color: #f97316;
    box-shadow: 0 0 20px rgba(249, 115, 22, 0.1);
}

.co-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #f97316, #c2410c);
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

.co-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(249, 115, 22, 0.4);
}

.co-success {
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
    .collab-grid { grid-template-columns: 1fr; }
    .collab-hero { padding-top: 120px; }
    .collab-hero h1 { font-size: 40px; }
    .co-glass-card { padding: 30px; }
    .co-input { padding: 16px 3px; }
}
</style>

<div class="collab-hero">
    <div class="co-badge"><i class="fas fa-handshake"></i> Future Partnership</div>
    <h1>Work With <span style="color:#f97316">MenHub</span></h1>
    <p>Grow your brand with our premium deal community. We help viral products reach their target audience.</p>
</div>

<div class="collab-container">
    <div class="collab-grid">
        
        <!-- LEFT COLLUMN -->
        <div class="collab-info">
            <div class="benefit-card">
                <h4><i class="fas fa-rocket"></i> Product Promotion</h4>
                <p>Get featured on our high-traffic deals sections and homepage spotlights.</p>
            </div>

            <div class="benefit-card">
                <h4><i class="fas fa-video"></i> Viral Video Feature</h4>
                <p>We create engaging video reviews and features for our social channels.</p>
            </div>

            <div class="benefit-card">
                <h4><i class="fas fa-newspaper"></i> Blog Sponsorship</h4>
                <p>Dedicated articles and guides featuring your brand's unique value.</p>
            </div>

            <div class="benefit-card" style="border-color: rgba(34, 197, 94, 0.2);">
                <h4 style="color:#4ade80;"><i class="fas fa-check-double"></i> Long-Term Growth</h4>
                <p>Join our affiliate network for consistent traffic and scale-able sales volume.</p>
            </div>
        </div>

        <!-- RIGHT COLLUMN -->
        <div class="co-glass-card">
            <?php if($msg!=""){ ?>
                <div class="co-success"><?php echo $msg; ?></div>
            <?php } ?>
            
            <form method="post">
                <div class="form-group">
                    <label>Brand / Company Name</label>
                    <input class="co-input" type="text" name="brand_name" placeholder="Acme Corp" required>
                </div>

                <div class="form-group">
                    <label>Contact Person</label>
                    <input class="co-input" type="text" name="person_name" placeholder="Jane Smith" required>
                </div>

                <div class="form-group">
                    <label>Business Email</label>
                    <input class="co-input" type="email" name="email" placeholder="partnerships@acme.com" required>
                </div>

                <div class="form-group">
                    <label>Product / Website Link</label>
                    <input class="co-input" type="text" name="website" placeholder="https://yourbrand.com">
                </div>

                <div class="form-group">
                    <label>Your Proposal</label>
                    <textarea class="co-input" name="message" placeholder="Briefly describe your brand and what you hope to achieve together..." rows="4" required></textarea>
                </div>

                <button class="co-btn" name="submit" type="submit">
                    Send Proposal <i class="fas fa-paper-plane"></i>
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


