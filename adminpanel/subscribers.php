<?php
session_start();
$page_title = "Manage Email Subscribers";
include 'admin_header.php';

/* DELETE */
if(isset($_GET['delete'])){
  $id = intval($_GET['delete']);
  mysqli_query($conn,"DELETE FROM subscribers WHERE id='$id'");
  echo "<script>window.location='subscribers.php';</script>";
}

/* FETCH */
$q = mysqli_query($conn,"SELECT * FROM subscribers ORDER BY id DESC");
$total = mysqli_num_rows($q);
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📩 Newsletter & Email Subscribers</h2>
    <span class="badge" style="background:rgba(37, 99, 235, 0.1); color:var(--primary); font-size:14px;">
      Total: <?= $total; ?> active subscribers
    </span>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Subscriber Email Address</th>
          <th>Subscription Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td style="font-weight:600; color:var(--primary); text-align:left;">
            <i class="fas fa-envelope-open-text" style="margin-right:8px; opacity:0.5;"></i>
            <?= htmlspecialchars($row['email']); ?>
          </td>
          <td style="font-size:13px; color:var(--text-muted);">
            <?= date('M d, Y', strtotime($row['created_at'])); ?>
            <div style="font-size:11px;"><?= date('h:i A', strtotime($row['created_at'])); ?></div>
          </td>
          <td>
            <span class="status-badge" style="background:#22c55e;">Active</span>
          </td>
          <td style="display:flex; gap:8px; flex-wrap:wrap;">
            <button onclick="openReplyModal(<?= $row['id']; ?>, '<?= addslashes(htmlspecialchars($row['email'])); ?>')" class="admin-btn btn-primary" style="padding:8px 12px; font-size:12px; background:#3b82f6; border:none; cursor:pointer;" title="Send Direct Deal">
              <i class="fas fa-paper-plane"></i> Quick Mail
            </button>
            <a href="?delete=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:8px 12px; font-size:12px;" onclick="return confirm('Remove this email from subscribers list?')">
              <i class="fas fa-user-minus"></i>
            </a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- QUICK MAIL MODAL ENGINE -->
<div id="replyModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:20000; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
    <div style="background:#0f172a; width:100%; max-width:500px; padding:30px; border-radius:30px; border:1px solid #334155; box-shadow:0 30px 100px rgba(0,0,0,0.8);">
        <h3 style="color:#fff; margin:0 0 20px;"><i class="fas fa-broadcast-tower" style="color:#3b82f6;"></i> Newsletter <span style="color:#3b82f6;">Broadcast</span></h3>
        <p id="replyToText" style="font-size:12px; color:#94a3b8; margin-bottom:20px;"></p>
        
        <input type="hidden" id="replyEmail">
        
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; color:#3b82f6; font-weight:900; margin-bottom:10px;">DEAL/NEWSLETTER CONTENT</label>
            <textarea id="replyMsg" style="width:100%; height:150px; background:#000; border:1px solid #334155; color:#fff; padding:15px; border-radius:15px; font-size:13px; line-height:1.6; resize:none; outline:none;"></textarea>
            <button onclick="aiDraftNewsletter()" style="background:rgba(59,130,246,0.1); border:1px solid #3b82f6; color:#3b82f6; font-size:10px; padding:8px 15px; border-radius:10px; margin-top:10px; cursor:pointer;"><i class="fas fa-magic"></i> Zayan: Draft High-CTR Deal</button>
        </div>

        <div style="display:flex; gap:15px;">
            <button onclick="sendSubscriberMail()" id="sendBtn" style="flex:1.5; background:#3b82f6; border:none; color:#fff; font-weight:900; padding:12px; border-radius:15px; cursor:pointer;">DISPATCH NOW</button>
            <button onclick="closeReplyModal()" style="flex:1; background:rgba(255,255,255,0.05); color:#fff; border:1px solid #334155; padding:12px; border-radius:15px; cursor:pointer;">CANCEL</button>
        </div>
    </div>
</div>

<script>
function openReplyModal(id, email) {
    document.getElementById('replyEmail').value = email;
    document.getElementById('replyToText').innerText = `Broadcasting to: ${email}`;
    document.getElementById('replyModal').style.display = 'flex';
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
    document.getElementById('replyMsg').value = '';
}

function aiDraftNewsletter() {
    const box = document.getElementById('replyMsg');
    box.value = "Generating viral deal structure...";
    setTimeout(() => {
        box.value = `Hey there!\n\nWe haven't seen you for a while. As a valued subscriber of MensHub Prime, we've unlocked a secret deal for you today!\n\n🔥 Upto 70% OFF on Premium Luxury Watches.\n\nCheck out the deals before they vanish: http://localhost/Menshubprime/deals.php\n\nStay Classy,\nTeam MensHub Prime`;
    }, 1000);
}

function sendSubscriberMail() {
    const btn = document.getElementById('sendBtn');
    const msg = document.getElementById('replyMsg').value;
    const email = document.getElementById('replyEmail').value;
    
    if(!msg) { alert('Draft a deal first!'); return; }
    
    btn.innerHTML = '<i class="fas fa-sync fa-spin"></i> DISPATCHING...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('email', email);
    formData.append('message', msg);
    formData.append('name', 'Valued Subscriber');

    fetch('send-auto-reply.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.text())
    .then(data => {
        alert('Newsletter Dispatched Successfully!');
        closeReplyModal();
        btn.innerHTML = 'DISPATCH NOW';
        btn.disabled = false;
    })
    .catch(e => {
        alert('Transmission Failed.');
        btn.innerHTML = 'DISPATCH NOW';
        btn.disabled = false;
    });
}
</script>

<?php include 'admin_footer.php'; ?>