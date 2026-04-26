<?php include 'includes/header.php'; ?>
<?php
include 'config/db.php';

$msg = "";

if(isset($_POST['submit'])){
  $email = $_POST['email'];

  // check duplicate
  $check = mysqli_query($conn,"SELECT id FROM app_subscribers WHERE email='$email'");

  if(mysqli_num_rows($check) > 0){
    $msg = "⚠️ Email already registered!";
  } else {
    mysqli_query($conn,"INSERT INTO app_subscribers(email) VALUES('$email')");
    $msg = "✅ Thanks! We will notify you when app is launched.";
  }
}
?>

<style>
.app-page{
  padding:70px 40px;
  background:#020617;
  color:white;
}

.app-title{
  text-align:center;
  font-size:34px;
  margin-bottom:10px;
}

.app-subtitle{
  text-align:center;
  color:#cbd5e1;
  margin-bottom:50px;
}

/* GRID */
.app-grid{
  display:grid;
  grid-template-columns:repeat(2,1fr);
  gap:40px;
  align-items:center;
}

/* LEFT */
.app-info{
  background:#0f172a;
  padding:30px;
  border-radius:18px;
  box-shadow:0 10px 30px rgba(0,0,0,.4);
}

.app-info h2{
  color:#f97316;
  margin-bottom:15px;
}

.app-info ul{
  margin-top:15px;
}

.app-info li{
  margin:10px 0;
  color:#cbd5e1;
}

/* BUTTONS */
.app-buttons{
  margin-top:25px;
  display:flex;
  gap:15px;
  flex-wrap:wrap;
}

.app-btn{
  padding:12px 22px;
  border-radius:30px;
  text-decoration:none;
  font-weight:bold;
  color:white;
  transition:.3s;
}

.android{background:#22c55e; color:#020617;}
.ios{background:#2563eb;}

.app-btn:hover{
  transform:scale(1.05);
  opacity:.9;
}

/* RIGHT */
.app-preview{
  text-align:center;
}

.app-preview img{
  width:280px;
  border-radius:20px;
  box-shadow:0 15px 40px rgba(0,0,0,.6);
}

/* FEATURES */
.features{
  margin-top:60px;
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:25px;
}

.feature-card{
  background:#0f172a;
  padding:20px;
  border-radius:16px;
  text-align:center;
  box-shadow:0 10px 25px rgba(0,0,0,.4);
}

.feature-card h3{
  color:#22c55e;
  margin-bottom:10px;
}

/* NOTIFY */
.notify-box{
  margin-top:60px;
  background:#0f172a;
  padding:30px;
  border-radius:18px;
  text-align:center;
}

.notify-box input{
  padding:12px;
  width:250px;
  border-radius:8px;
  border:none;
  outline:none;
}

.notify-box button{
  padding:12px 25px;
  border:none;
  border-radius:30px;
  background:#f97316;
  color:#020617;
  margin-left:10px;
  cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:900px){
  .app-grid{grid-template-columns:1fr;}
  .features{grid-template-columns:1fr;}
  .app-preview img{width:220px;}
}
</style>

<div class="app-page">

<h1 class="app-title">📱 MenHub Prime Mobile App</h1>
<p class="app-subtitle">Smart shopping in your pocket – coming soon</p>

<div class="app-grid">

<!-- LEFT -->
<div class="app-info">
<h2>Why Download Our App?</h2>
<p>
MenHub Prime App will help you discover viral products, best deals and exclusive discounts faster than ever.
</p>

<ul>
<li>✅ One-tap access to viral product videos</li>
<li>✅ Exclusive app-only deals</li>
<li>✅ Faster checkout via trusted platforms</li>
<li>✅ Personalized recommendations</li>
<li>✅ Push notifications for hot deals</li>
</ul>

<div class="app-buttons">
<a href="#notifyBox" class="app-btn android">🤖 Android (Coming Soon)</a>
<a href="#notifyBox" class="app-btn ios">🍎 iOS (Coming Soon)</a>
</div>
</div>

<!-- RIGHT -->
<div class="app-preview">
<img src="assets/images/app-preview.png" alt="App Preview">
</div>

</div>

<!-- FEATURES -->
<div class="features">

<div class="feature-card">
<h3>⚡ Fast & Secure</h3>
<p>Browse deals with lightning speed and secure redirection.</p>
</div>

<div class="feature-card">
<h3>🎯 Smart Suggestions</h3>
<p>AI-powered product recommendations just for you.</p>
</div>

<div class="feature-card">
<h3>💸 Best Prices</h3>
<p>Never miss a deal with real-time alerts.</p>
</div>

</div>

<!-- NOTIFY -->
<div class="notify-box" id="notifyBox">
<h2>🔔 Get Notified When App Launches</h2>
<p>Enter your email to receive early access</p>

<form method="post">
  <input type="email" name="email" placeholder="Enter your email" required>
  <button type="submit" name="submit">Notify Me</button>
</form>

<?php if(isset($msg)) echo "<p style='color:lime;'>$msg</p>"; ?>
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

<hr>

<?php include 'includes/footer.php'; ?>
