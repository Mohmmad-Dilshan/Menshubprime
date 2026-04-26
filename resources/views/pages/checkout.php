<?php
if (!defined('ROOT_PATH')) { require_once dirname(__DIR__, 3) . '/src/bootstrap.php'; }

if (!isset($_GET['id'])) {
    header("Location: /Menshubprime/digital-products");
    exit();
}

$id = intval($_GET['id']);
$q = mysqli_query($conn, "SELECT * FROM digital_products WHERE id=$id AND status='active'");
$product = mysqli_fetch_assoc($q);

if(!$product){
    die("<h2 style='color:white;text-align:center;padding:50px;'>Product not found or unavailable.</h2>");
}

$razorpay_link = $product['razorpay_link'] ?? '';

$page_title = "Secure Checkout - " . $product['title'];
include ROOT_PATH . '/includes/header.php';
?>

<style>
/* ===== CHECKOUT PAGE - PERMANENT FOOTER FIX ===== */
html, body {
  min-height: 100vh !important;
  height: auto !important;
}
body {
  display: flex !important;
  flex-direction: column !important;
  overflow-x: hidden !important;
}
#main-content {
  flex: 1 1 auto !important;
  display: block !important;
}
footer.footer,
footer {
  display: block !important;
  visibility: visible !important;
  opacity: 1 !important;
  flex-shrink: 0 !important;
  position: relative !important;
  z-index: 1 !important;
  overflow: visible !important;
  height: auto !important;
  max-height: none !important;
  clip: auto !important;
}

.checkout-wrapper {
  max-width: 1100px;
  margin: 50px auto;
  padding: 0 20px 60px;
  color: #f8fafc;
  min-height: 500px; /* ensures content has enough height */
}

.checkout-header {
  text-align: center;
  margin-bottom: 40px;
}
.checkout-header h1 {
  font-size: 32px;
  font-weight: 800;
  background: linear-gradient(135deg, #f97316, #22c55e);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 10px;
}
.checkout-header p {
  color: #94a3b8;
  font-size: 16px;
}

.checkout-grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: 40px;
}

.checkout-panel {
  background: rgba(15, 23, 42, 0.8);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.05);
  border-radius: 20px;
  padding: 35px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.checkout-panel h2 {
  font-size: 20px;
  margin-bottom: 25px;
  border-bottom: 1px solid rgba(255,255,255,0.05);
  padding-bottom: 15px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.form-group { margin-bottom: 20px; }
.form-group label {
  display: block;
  font-size: 14px;
  color: #cbd5e1;
  margin-bottom: 8px;
  font-weight: 500;
}
.form-group input {
  width: 100%;
  padding: 14px 16px;
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px;
  color: white;
  font-size: 15px;
  box-sizing: border-box;
  transition: all 0.3s;
}
.form-group input:focus {
  outline: none;
  border-color: #38bdf8;
  background: rgba(255,255,255,0.05);
  box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
}

.summary-panel {
  background: linear-gradient(145deg, #0f172a, #020617);
  border: 1px solid rgba(255,255,255,0.05);
  border-radius: 20px;
  padding: 35px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.4);
  height: fit-content;
}

.summary-item {
  display: flex;
  gap: 20px;
  margin-bottom: 25px;
}
.summary-img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 12px;
}
.summary-details h3 {
  font-size: 18px;
  margin-bottom: 8px;
  line-height: 1.4;
}
.summary-details .summary-price {
  font-size: 22px;
  color: #22c55e;
  font-weight: 700;
}

.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-top: 1px solid rgba(255,255,255,0.05);
  padding-top: 20px;
  margin-top: 20px;
  font-size: 20px;
  font-weight: 800;
}

.pay-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  width: 100%;
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  color: white;
  border: none;
  padding: 16px;
  border-radius: 14px;
  font-size: 18px;
  font-weight: 700;
  cursor: pointer;
  margin-top: 25px;
  box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
  transition: all 0.3s;
  text-decoration: none;
}
.pay-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 30px rgba(37, 99, 235, 0.6);
}
.pay-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}
.pay-btn-orange {
  background: linear-gradient(135deg, #f97316, #ea580c) !important;
  box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4) !important;
}

.secure-badges {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 15px;
  margin-top: 15px;
  color: #64748b;
  font-size: 12px;
}

@keyframes spin { 100% { transform: rotate(360deg); } }
.spinner {
  display: none;
  width: 22px;
  height: 22px;
  border: 3px solid rgba(255,255,255,0.3);
  border-top-color: white;
  border-radius: 50%;
  animation: spin 0.8s infinite linear;
}

/* ---- Toast notification (no alert popups) ---- */
#co-toast {
  display: none;
  position: fixed;
  top: 80px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(239,68,68,0.9);
  color: white;
  padding: 14px 24px;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 600;
  z-index: 999999;
  backdrop-filter: blur(10px);
  max-width: 420px;
  text-align: center;
  box-shadow: 0 8px 30px rgba(0,0,0,0.4);
  animation: slideDown 0.4s ease;
}
@keyframes slideDown {
  from { top: 40px; opacity: 0; }
  to   { top: 80px; opacity: 1; }
}

/* ---- Fallback box ---- */
#manualFallback {
  display: none;
  margin-top: 20px;
  padding: 20px;
  background: rgba(249,115,22,0.08);
  border: 1px solid rgba(249,115,22,0.4);
  border-radius: 14px;
  text-align: center;
  animation: fadeIn 0.5s ease;
}
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
#manualFallback p { color: #f97316; font-size: 13px; margin-bottom: 14px; }

@media(max-width: 800px) {
  .checkout-grid { grid-template-columns: 1fr; }
}
</style>

<!-- Toast (replaces alert popups) -->
<div id="co-toast"></div>

<div class="checkout-wrapper">
  
  <div class="checkout-header">
    <h1>Secure Checkout</h1>
    <p>Complete your details to get instant access to your digital product.</p>
  </div>

  <div class="checkout-grid">
    
    <!-- LEFT: Customer Details -->
    <div class="checkout-panel">
      <h2><i class="fas fa-user-circle" style="color:#38bdf8;"></i> Your Details</h2>
      
      <form id="checkoutForm">
        <input type="hidden" id="product_id" value="<?= $product['id']; ?>">
        <input type="hidden" id="amount" value="<?= $product['price']; ?>">
        <input type="hidden" id="rzp_link" value="<?= htmlspecialchars($razorpay_link); ?>">
        
        <div class="form-group">
          <label for="c_name">Full Name *</label>
          <input type="text" id="c_name" name="name" autocomplete="name" placeholder="Enter your full name" required>
        </div>
        
        <div class="form-group">
          <label for="c_email">Email Address * (For Receipt &amp; Download Link)</label>
          <input type="email" id="c_email" name="email" autocomplete="email" placeholder="you@example.com" required>
        </div>
        
        <div class="form-group">
          <label for="c_phone">WhatsApp Number * (For Delivery Updates)</label>
          <input type="tel" id="c_phone" name="phone" autocomplete="tel" placeholder="+91 XXXXXXXXXX" required>
        </div>

        <?php if(!empty($product['custom_label'])){ ?>
        <div class="form-group">
          <label><?= htmlspecialchars($product['custom_label']); ?> *</label>
          <input type="text" id="custom_info" name="custom_info" placeholder="Enter <?= htmlspecialchars($product['custom_label']); ?>" required>
        </div>
        <?php } ?>
        
      </form>
    </div>

    <!-- RIGHT: Summary -->
    <div class="summary-panel">
      <h2><i class="fas fa-shopping-bag" style="color:#22c55e;"></i> Order Summary</h2>
      
      <div class="summary-item">
        <img src="/Menshubprime/uploads/digital_products/<?= $product['image']; ?>" class="summary-img" alt="Product">
        <div class="summary-details">
          <h3><?= htmlspecialchars($product['title']); ?></h3>
          <div class="summary-price">₹<?= $product['price']; ?></div>
        </div>
      </div>
      
      <div style="color:#94a3b8; font-size:14px; display:flex; justify-content:space-between; margin-bottom:10px;">
        <span>Subtotal</span>
        <span>₹<?= $product['price']; ?></span>
      </div>
      <div style="color:#94a3b8; font-size:14px; display:flex; justify-content:space-between;">
        <span>Platform Fee</span>
        <span style="color:#22c55e;">Free</span>
      </div>

      <div class="total-row">
        <span>Total to Pay</span>
        <span style="color:#38bdf8;">₹<?= $product['price']; ?></span>
      </div>

      <button type="button" class="pay-btn" id="payBtn" onclick="processPayment()">
        <span id="btnText"><i class="fas fa-lock"></i> Pay Securely</span>
        <div class="spinner" id="btnSpinner"></div>
      </button>

      <div class="secure-badges">
        <span><i class="fas fa-shield-alt"></i> 256-bit Encryption</span>
        <span><i class="fas fa-check-circle"></i> Instant Delivery</span>
      </div>

      <!-- Fallback Payment (shown silently when API fails) -->
      <div id="manualFallback">
        <p>⚠️ Gateway busy. Pay directly via Razorpay:</p>
        <?php if(!empty($razorpay_link)){ ?>
        <a href="<?= htmlspecialchars($razorpay_link); ?>" target="_blank" class="pay-btn pay-btn-orange" style="margin-top:0; text-decoration:none; display:flex;">
          <i class="fas fa-external-link-alt"></i> Pay Now via Razorpay
        </a>
        <?php } else { ?>
        <p style="color:#94a3b8;">Contact us on <a href="https://t.me/thezayanway" target="_blank" style="color:#38bdf8;">Telegram</a> to complete payment.</p>
        <?php } ?>
      </div>

    </div>

  </div><!-- end checkout-grid -->

</div><!-- end checkout-wrapper -->

<script>
// Load Razorpay SDK — try CDN, mark as loaded
window.rzpSdkLoaded = false;
</script>
<script src="https://checkout.razorpay.com/v1/checkout.js" onload="window.rzpSdkLoaded=true;" onerror="window.rzpSdkLoaded=false;"></script>
<script>
// ---- Toast helper (no alert() popups ever) ----
function showToast(msg, color) {
  var t = document.getElementById('co-toast');
  t.style.background = color || 'rgba(239,68,68,0.9)';
  t.textContent = msg;
  t.style.display = 'block';
  setTimeout(function(){ t.style.display = 'none'; }, 4000);
}

function showFallback() {
  var fb = document.getElementById('manualFallback');
  if (fb) {
    fb.style.display = 'block';
    fb.scrollIntoView({ behavior: 'smooth', block: 'center' });
  }
}

function resetBtn() {
  var btn  = document.getElementById('payBtn');
  var text = document.getElementById('btnText');
  var spin = document.getElementById('btnSpinner');
  btn.disabled = false;
  text.style.display = 'block';
  text.innerHTML = '<i class="fas fa-lock"></i> Pay Securely';
  spin.style.display = 'none';
}

function processPayment() {
  var name  = document.getElementById('c_name').value.trim();
  var email = document.getElementById('c_email').value.trim();
  var phone = document.getElementById('c_phone').value.trim();
  var prodId = document.getElementById('product_id').value;
  var amount = document.getElementById('amount').value;
  var rzpLink = document.getElementById('rzp_link').value;

  var customInfoEl = document.getElementById('custom_info');
  var customInfo = customInfoEl ? customInfoEl.value.trim() : '';

  // Validation (toast instead of alert)
  if (!name || !email || !phone || (customInfoEl && !customInfo)) {
    showToast('Please fill all required fields before proceeding.');
    return;
  }

  var btn  = document.getElementById('payBtn');
  var text = document.getElementById('btnText');
  var spin = document.getElementById('btnSpinner');

  btn.disabled = true;
  text.style.display = 'none';
  spin.style.display = 'block';

  var fd = new FormData();
  fd.append('action', 'process_mock_payment');
  fd.append('product_id', prodId);
  fd.append('name', name);
  fd.append('email', email);
  fd.append('phone', phone);
  fd.append('amount', amount);
  fd.append('custom_info', customInfo);

  // Set a 20-second hard timeout — if no response, show fallback silently
  var hardTimeout = setTimeout(function() {
    resetBtn();
    showToast('Connection slow. Showing direct payment option.', 'rgba(249,115,22,0.9)');
    showFallback();
  }, 20000);

  fetch('/Menshubprime/process-order.php', {
    method: 'POST',
    body: fd
  })
  .then(function(res) { return res.json(); })
  .then(function(data) {
    clearTimeout(hardTimeout);

    if (data.success) {
      text.style.display = 'block';
      spin.style.display = 'none';
      text.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening Gateway...';

      if (typeof Razorpay === 'undefined') {
        resetBtn();
        showFallback();
        return;
      }

      var options = {
        key: data.key_id,
        amount: data.amount_paisa,
        currency: 'INR',
        name: 'MensHubPrime',
        description: data.title,
        order_id: data.order_id,
        handler: function(response) {
          window.location.href = '/Menshubprime/success?razorpay_payment_id=' + response.razorpay_payment_id
                               + '&razorpay_order_id=' + response.razorpay_order_id
                               + '&razorpay_signature=' + response.razorpay_signature;
        },
        prefill: { name: data.name, email: data.email, contact: data.contact },
        theme: { color: '#1d4ed8' },
        modal: { ondismiss: function() { resetBtn(); } }
      };

      var rzp = new Razorpay(options);
      rzp.on('payment.failed', function(response) {
        resetBtn();
        showToast('Payment failed: ' + response.error.description);
      });
      rzp.open();

    } else if (data.gateway_down) {
      // API down — still open Razorpay popup WITHOUT order_id (SDK supports this)
      clearTimeout(hardTimeout);
      resetBtn();

      if (typeof Razorpay === 'undefined') {
        // SDK not loaded — last resort: open direct link
        if (data.razorpay_link && data.razorpay_link.length > 5) {
          window.open(data.razorpay_link, '_blank');
        } else {
          showFallback();
        }
        return;
      }

      text.style.display = 'block';
      spin.style.display = 'none';
      text.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Opening Gateway...';

      var optionsNoOrder = {
        key: data.key_id,
        amount: data.amount_paisa,
        currency: 'INR',
        name: 'MensHubPrime',
        description: data.title || 'Digital Product',
        // No order_id — Razorpay still accepts this
        handler: function(response) {
          window.location.href = '/Menshubprime/success?razorpay_payment_id=' + response.razorpay_payment_id
                               + '&razorpay_order_id=' + (response.razorpay_order_id || '')
                               + '&razorpay_signature=' + (response.razorpay_signature || '');
        },
        prefill: { name: data.name || name, email: data.email || email, contact: data.contact || phone },
        theme: { color: '#1d4ed8' },
        modal: { ondismiss: function() { resetBtn(); } }
      };

      var rzpFallback = new Razorpay(optionsNoOrder);
      rzpFallback.on('payment.failed', function(response) {
        resetBtn();
        showToast('Payment failed: ' + response.error.description);
      });
      rzpFallback.open();

    } else {
      clearTimeout(hardTimeout);
      resetBtn();
      console.warn('Payment error:', data.message);
      showFallback();
    }
  })
  .catch(function(err) {
    clearTimeout(hardTimeout);
    resetBtn();
    console.error('Checkout error:', err);
    showFallback();
  });
}
</script>

<?php include ROOT_PATH . '/includes/footer.php'; ?>
