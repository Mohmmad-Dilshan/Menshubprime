<?php
include 'config/db.php';

$msg = "";

if(isset($_POST['send'])){
  $name = mysqli_real_escape_string($conn,$_POST['name']);
  $email = mysqli_real_escape_string($conn,$_POST['email']);
  $message = mysqli_real_escape_string($conn,$_POST['message']);

  mysqli_query($conn,"INSERT INTO hire_requests(name,email,message)
  VALUES('$name','$email','$message')");

  $msg = "✅ Success! I will get back to you shortly.";
}
?>

<?php include ROOT_PATH . '/includes/header.php'; ?>

<style>
/* PREMIUM HIRE ME STYLES */
.hire-hero {
    padding: 140px 0 80px;
    background: radial-gradient(circle at top right, rgba(34, 197, 94, 0.1), transparent 40%),
                radial-gradient(circle at bottom left, rgba(37, 99, 235, 0.05), transparent 40%);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.h-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: 100px;
    color: #22c55e;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 25px;
    animation: fadeInDown 0.8s ease;
}

.hire-hero h1 {
    font-size: clamp(36px, 6vw, 64px);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    letter-spacing: -2px;
}

.hire-hero p {
    color: #94a3b8;
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

.hire-content {
    padding: 60px 20px 100px;
    max-width: 1200px;
    margin: 0 auto;
}

.h-grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 40px;
}

.h-glass-card {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 40px;
    padding: 50px;
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
}

.h-profile section {
    margin-bottom: 40px;
}

.h-profile h2 {
    font-size: 24px;
    color: #fff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.h-profile h2 i { color: #22c55e; }

.h-profile p {
    color: #94a3b8;
    line-height: 1.8;
    font-size: 15px;
}

.service-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.service-pill {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    padding: 12px 20px;
    border-radius: 15px;
    color: #cbd5e1;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.service-pill i { color: #22c55e; }

/* FORM STYLES */
.h-form h2 {
    color: #fff;
    margin-bottom: 30px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #94a3b8;
    margin-bottom: 10px;
    font-size: 14px;
}

.h-input {
    width: 100%;
    background: rgba(15, 23, 42, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 15px 18px;
    border-radius: 15px;
    color: #fff;
    font-family: inherit;
    transition: 0.3s;
}

.h-input:focus {
    outline: none;
    border-color: #22c55e;
    box-shadow: 0 0 20px rgba(34, 197, 94, 0.1);
}

.h-btn {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: #fff;
    border: none;
    border-radius: 15px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 15px 30px rgba(34, 197, 94, 0.2);
}

.h-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 40px rgba(34, 197, 94, 0.3);
}

.success-msg {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid #22c55e;
    color: #22c55e;
    padding: 15px;
    border-radius: 15px;
    text-align: center;
    margin-bottom: 25px;
}

@media (max-width: 900px) {
    .h-grid { grid-template-columns: 1fr; }
    .h-glass-card { padding: 35px 25px; border-radius: 30px; }
    .service-grid { grid-template-columns: 1fr; }
    .h-input { padding: 15px 3px; }
}
</style>

<div class="hire-hero">
    <div class="h-badge"><i class="fas fa-code"></i> Professional Developer</div>
    <h1>Hire a <span style="color:#22c55e">Creator</span></h1>
    <p>I build high-performance websites, automated platforms, and professional digital ecosystems that scale.</p>
</div>

<div class="hire-content">
    <div class="h-grid">
        
        <!-- LEFT: PROFILE -->
        <div class="h-glass-card h-profile">
            <section>
                <h2><i class="fas fa-user-circle"></i> About Me</h2>
                <p>
                    I am the architect behind MenHub Prime and several other high-traffic digital platforms. With a focus on speed, secondary-level security, and premium aesthetics, I help brands bridge the gap between "just a site" and a "professional system."
                </p>
            </section>

            <section>
                <h2><i class="fas fa-layer-group"></i> My Expertise</h2>
                <div class="service-grid">
                    <div class="service-pill"><i class="fas fa-laptop-code"></i> Full MVC Web Apps</div>
                    <div class="service-pill"><i class="fas fa-shield-alt"></i> Secure Admin Panels</div>
                    <div class="service-pill"><i class="fas fa-shopping-cart"></i> Advanced Stores</div>
                    <div class="service-pill"><i class="fas fa-robot"></i> Custom Automation</div>
                    <div class="service-pill"><i class="fas fa-paint-brush"></i> Glassmorphism UI</div>
                    <div class="service-pill"><i class="fas fa-search-dollar"></i> SEO & Speed Opt.</div>
                </div>
            </section>

            <section>
                <h2><i class="fas fa-check-circle"></i> Why Choose Me?</h2>
                <p>
                    I don't just write code; I build solutions. Every project comes with a guarantee of **clean architecture**, **fast delivery**, and **unlimited premium styling**.
                </p>
            </section>
        </div>

        <!-- RIGHT: CONTACT -->
        <div class="h-glass-card h-form">
            <h2>Project Inquiry</h2>
            
            <?php if($msg!=""){ ?>
                <div class="success-msg"><?php echo $msg; ?></div>
            <?php } ?>

            <form method="post">
                <div class="form-group">
                    <input type="text" name="name" class="h-input" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="h-input" placeholder="Your Email address" required>
                </div>
                <div class="form-group">
                    <textarea name="message" class="h-input" style="height:150px;" placeholder="Briefly describe your project or idea..." required></textarea>
                </div>
                <button type="submit" name="send" class="h-btn">Send Proposal <i class="fas fa-paper-plane"></i></button>
            </form>

            <div style="margin-top: 30px; text-align: center;">
                <p style="color:#64748b; font-size: 13px;">Typical response time: < 24 Hours</p>
            </div>
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