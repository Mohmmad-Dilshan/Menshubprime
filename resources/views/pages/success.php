<?php
include 'config/db.php';

$order_id = '';

// Check if returning from Razorpay Checkout API
if(isset($_GET['razorpay_payment_id']) && isset($_GET['razorpay_order_id']) && isset($_GET['razorpay_signature'])) {
    
    $rzp_payment_id = $_GET['razorpay_payment_id'];
    $rzp_order_id   = $_GET['razorpay_order_id'];
    $rzp_signature  = $_GET['razorpay_signature'];

    $generated_signature = hash_hmac('sha256', $rzp_order_id . "|" . $rzp_payment_id, RAZORPAY_KEY_SECRET);

    if (hash_equals($generated_signature, $rzp_signature)) {
        // Payment is successful and signature is verified
        $order_id = mysqli_real_escape_string($conn, $rzp_order_id);
        mysqli_query($conn, "UPDATE digital_orders SET payment_status='Completed' WHERE order_id='$order_id'");
    } else {
        die("<h2 style='color:white;text-align:center;padding:50px;'>Payment Verification Failed. Invalid Signature.</h2>");
    }
} else {
    // If accessing directly or from legacy link
    $order_id = isset($_GET['order']) ? $_GET['order'] : '';
    // Check session if order is missing in URL
    if(empty($order_id) && isset($_SESSION['last_order_id'])) {
        $order_id = $_SESSION['last_order_id'];
    }
}

$order_id = mysqli_real_escape_string($conn, $order_id);

if(empty($order_id)) {
    header("Location: /Menshubprime/digital-products");
    exit();
}

// Fetch Order and Product Link
$q = mysqli_query($conn, "
    SELECT o.*, p.title, p.product_link, p.image, p.custom_label 
    FROM digital_orders o 
    JOIN digital_products p ON o.product_id = p.id 
    WHERE o.order_id = '$order_id'
");

$order = mysqli_fetch_assoc($q);

if(!$order) {
    die("<h2 style='color:white;text-align:center;padding:50px;'>Order not found.</h2>");
}

if($order['payment_status'] !== 'Completed') {
    die("<h2 style='color:white;text-align:center;padding:50px;'>Payment is unverified or pending.<br><span style='font-size:16px;color:#94a3b8;'>If you just paid, please wait a moment or contact support.</span></h2>");
}

$page_title = "Payment Successful - Thank You!";
include ROOT_PATH . '/includes/header.php';
?>

<style>
.success-wrapper {
  max-width: 800px;
  margin: 80px auto;
  padding: 0 20px;
  text-align: center;
  color: #f8fafc;
  position: relative;
}

/* Background Glowing Orbs */
.success-wrapper::before {
  content: '';
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(34,197,94,0.15) 0%, rgba(0,0,0,0) 70%);
  z-index: -1;
  pointer-events: none;
}

.success-card {
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 30px;
  padding: 50px;
  box-shadow: 0 30px 60px rgba(0,0,0,0.6), inset 0 1px 0 rgba(255,255,255,0.1);
  position: relative;
  overflow: hidden;
}

/* Shine effect across the card */
.success-card::after {
  content: "";
  position: absolute;
  top: 0; left: -100%;
  width: 50%; height: 100%;
  background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.03) 50%, rgba(255,255,255,0) 100%);
  animation: shine 4s infinite;
}
@keyframes shine {
  0% { left: -100%; }
  20% { left: 200%; }
  100% { left: 200%; }
}

.success-icon {
  font-size: 85px;
  color: #22c55e;
  margin-bottom: 25px;
  animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55), float 3s ease-in-out infinite alternate;
  text-shadow: 0 0 30px rgba(34, 197, 94, 0.4);
}

@keyframes float {
  from { transform: translateY(0px); }
  to { transform: translateY(-10px); }
}

@keyframes bounceIn {
  from { opacity: 0; transform: scale(0.3); }
  to { opacity: 1; transform: scale(1); }
}

.success-card h1 {
  font-size: 38px;
  font-weight: 800;
  margin-bottom: 10px;
  background: linear-gradient(135deg, #10b981, #38bdf8);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  letter-spacing: -0.5px;
}

.order-receipt {
  background: rgba(2, 6, 23, 0.5);
  border-radius: 20px;
  padding: 25px;
  margin: 35px 0;
  border: 1px solid rgba(255,255,255,0.08);
  display: flex;
  align-items: center;
  gap: 25px;
  text-align: left;
  box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  transition: transform 0.3s;
}
.order-receipt:hover {
  transform: translateY(-2px);
  border-color: rgba(56, 189, 248, 0.3);
}

.receipt-img {
  width: 110px;
  height: 110px;
  object-fit: cover;
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

.receipt-info h3 { font-size: 20px; margin-bottom: 8px; color: #f8fafc; line-height: 1.3;}
.receipt-info p { color: #94a3b8; font-size: 14px; margin: 4px 0 0 0; }

.download-section {
  margin-top: 40px;
}

.download-btn {
  display: inline-flex;
  align-items: center;
  gap: 12px;
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  padding: 20px 50px;
  border-radius: 50px;
  font-size: 20px;
  font-weight: 800;
  text-decoration: none;
  box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3), inset 0 2px 0 rgba(255,255,255,0.2);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.download-btn:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 15px 35px rgba(16, 185, 129, 0.5), inset 0 2px 0 rgba(255,255,255,0.3);
  filter: brightness(1.1);
}
.download-btn:active {
  transform: translateY(-1px) scale(0.98);
}

.confetti-canvas {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 100;
}

/* ==================================== */
/* HEAVY MOBILE RESPONSIVENESS FIX      */
/* ==================================== */
@media screen and (max-width: 768px) {
  .success-wrapper { 
    margin: 30px auto; 
    padding: 0 15px; 
    width: 100%;
    box-sizing: border-box;
  }
  .success-card { 
    padding: 30px 20px; 
    border-radius: 20px; 
    box-sizing: border-box;
  }
  .success-icon { 
    font-size: 60px; 
    margin-bottom: 15px; 
  }
  .success-card h1 { 
    font-size: 26px; 
  }
  .success-card > p {
    font-size: 15px;
    line-height: 1.5;
  }
  .order-receipt {
    flex-direction: column;
    text-align: center;
    padding: 20px;
    gap: 15px;
    margin: 25px 0;
  }
  .receipt-img {
    width: 90px;
    height: 90px;
  }
  .receipt-info h3 {
    font-size: 18px;
  }
  .receipt-info p {
    font-size: 13px;
  }
  .download-section {
    margin-top: 30px;
  }
  .download-section > p {
    font-size: 14px;
    margin-bottom: 15px;
  }
  .download-btn {
    width: 100%;
    padding: 16px 15px;
    font-size: 16px;
    display: flex;
    justify-content: center;
    box-sizing: border-box;
  }
}
@media screen and (max-width: 400px) {
  .success-card { padding: 25px 15px; }
  .success-card h1 { font-size: 22px; }
}
</style>

<!-- Load SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="success-wrapper">
  
  <div class="success-card">
    <div class="success-icon">
      <i class="fas fa-check-circle"></i>
    </div>
    
    <h1>Payment Successful!</h1>
    <p>Thank you for your purchase, <strong><?= htmlspecialchars($order['customer_name']); ?></strong>. Your digital product is ready for delivery.</p>

    <div class="order-receipt">
      <img src="uploads/digital_products/<?= $order['image']; ?>" class="receipt-img">
      <div class="receipt-info">
        <h3><?= htmlspecialchars($order['title']); ?></h3>
        <p>Order ID: #<?= $order['order_id']; ?></p>
        <?php if(!empty($order['custom_info'])){ ?>
          <p><?= htmlspecialchars($order['custom_label']); ?>: <strong><?= htmlspecialchars($order['custom_info']); ?></strong></p>
        <?php } ?>
        <p>Payment Status: <span style="color:#22c55e; font-weight:700;">Verified</span></p>
      </div>
    </div>

    <div class="download-section">
      <p style="color:#cbd5e1; margin-bottom:20px; font-size:16px;">Click the button below to instantly access your product.</p>
      <a href="javascript:void(0)" onclick="handleDownload('<?= $order['order_id']; ?>')" class="download-btn" id="mainDownloadBtn">
        <i class="fas fa-cloud-download-alt"></i> Access Product Now
      </a>
    </div>

    <div style="margin-top:40px; border-top:1px solid rgba(255,255,255,0.05); padding-top:20px;">
       <a href="/Menshubprime/" style="color:#38bdf8; text-decoration:none; font-size:14px; font-weight:600;">
         <i class="fas fa-home"></i> Back to Homepage
       </a>
    </div>

  </div>

</div>

<!-- Simple Confetti Effect if needed -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
  window.onload = function() {
    confetti({
      particleCount: 150,
      spread: 70,
      origin: { y: 0.6 },
      colors: ['#f97316', '#22c55e', '#3b82f6']
    });
  };
</script>

<script>
function handleDownload(orderId) {
  const btn = document.getElementById('mainDownloadBtn');
  
  // Show Loading Popup with SweetAlert2
  Swal.fire({
    title: 'Preparing Secure Link...',
    html: 'Please wait while we fetch your file securely.',
    allowOutsideClick: false,
    showConfirmButton: false,
    background: '#1e293b',
    color: '#f8fafc',
    didOpen: () => {
      Swal.showLoading();
    }
  });

  // Simulate network/security delay
  setTimeout(() => {
    // 1. Trigger the download programmatically
    const downloadForm = document.createElement('form');
    downloadForm.method = 'GET';
    downloadForm.action = '/Menshubprime/download';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'order';
    input.value = orderId;
    
    downloadForm.appendChild(input);
    document.body.appendChild(downloadForm);
    downloadForm.submit();
    document.body.removeChild(downloadForm);

    // 2. Change Popup to Success Notification
    Swal.fire({
      title: 'Download Started!',
      text: 'Your product is downloading. Please check your browser downloads.',
      icon: 'success',
      confirmButtonText: 'Great!',
      confirmButtonColor: '#10b981',
      background: '#1e293b',
      color: '#f8fafc',
      timer: 4000,
      timerProgressBar: true
    });

    // 3. Update the button to show success state
    btn.innerHTML = '<i class="fas fa-check-double"></i> Downloaded Successfully';
    btn.style.background = 'linear-gradient(135deg, #064e3b, #065f46)';
    btn.style.boxShadow = '0 10px 25px rgba(6, 78, 59, 0.4)';
    btn.style.pointerEvents = 'none';

  }, 1500); // 1.5 seconds mock loading time
}
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
