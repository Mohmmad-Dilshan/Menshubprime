<?php
session_start();
$page_title = "User Inquiries & Messages";
include 'admin_header.php';

/* DELETE MESSAGE */
if(isset($_GET['delete'])){
  $id = mysqli_real_escape_string($conn, $_GET['delete']);
  mysqli_query($conn,"DELETE FROM messages WHERE id='$id'");
  echo "<script>window.location='messages.php';</script>";
}

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

/* TOTAL ROWS */
$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(id) as total FROM messages"))['total'];
$pages = ceil($total / $limit);

/* FETCH DATA */
$data = mysqli_query($conn,"SELECT * FROM messages ORDER BY id DESC LIMIT $start, $limit");
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>📩 Customer Inquiries & Feedback</h2>
    <span class="badge" style="background:rgba(37, 99, 235, 0.1); color:var(--primary); font-size:14px;">
      Total: <?= $total; ?> Messages
    </span>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Sender Info</th>
          <th>Message Content</th>
          <th>Date Received</th>
          <th>Actions</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($data)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td>
            <div style="font-weight:600; color:var(--primary);"><?= htmlspecialchars($row['name']); ?></div>
            <div style="font-size:12px; color:var(--text-muted);"><?= htmlspecialchars($row['email']); ?></div>
          </td>
          <td>
            <div style="max-width:400px; font-size:13px; line-height:1.5; background:rgba(255,255,255,0.03); padding:10px; border-radius:8px; border:1px solid var(--glass-border);">
              <?= nl2br(htmlspecialchars($row['message'])); ?>
            </div>
          </td>
          <td style="white-space:nowrap; font-size:12px; color:var(--text-muted);">
            <i class="far fa-clock"></i> <?= $row['date']; ?>
          </td>
          <td style="display:flex; gap:8px; flex-wrap:wrap;">
            <button onclick="openReplyModal(<?= $row['id']; ?>, '<?= addslashes(htmlspecialchars($row['email'])); ?>', '<?= addslashes(htmlspecialchars($row['name'])); ?>', '<?= addslashes(str_replace(["\r", "\n"], ' ', htmlspecialchars($row['message']))); ?>')" class="admin-btn btn-primary" style="padding:8px 12px; font-size:12px; background:#3b82f6; border:none; cursor:pointer;" title="Reply via AI Dashboard">
              <i class="fas fa-paper-plane"></i> Quick Reply
            </button>
            <a href="messages.php?delete=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:8px 12px; font-size:12px;" onclick="return confirm('Archive/Delete this message?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
          <td>
            <?php if(($row['reply_status'] ?? 'pending') == 'replied'): ?>
              <span style="background:rgba(34, 197, 94, 0.1); color:#22c55e; padding:5px 10px; border-radius:30px; font-size:10px; font-weight:900; border:1px solid #22c55e;"><i class="fas fa-check-double"></i> REPLIED</span>
            <?php else: ?>
              <span style="background:rgba(255, 255, 255, 0.05); color:#94a3b8; padding:5px 10px; border-radius:30px; font-size:10px; font-weight:900; border:1px solid #334155;">PENDING</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php if($pages > 1): ?>
  <div style="display:flex; justify-content:center; gap:10px; margin-top:30px;">
    <?php for($i=1;$i<=$pages;$i++){ ?>
    <a href="messages.php?page=<?= $i; ?>" class="admin-btn <?= ($i==$page)?'btn-primary':''; ?>" style="padding:8px 14px; min-width:40px; justify-content:center;">
      <?= $i; ?>
    </a>
    <?php } ?>
  </div>
  <?php endif; ?>
</div>

<!-- REPLY MODAL ENGINE -->
<div id="replyModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:20000; align-items:center; justify-content:center; backdrop-filter:blur(10px);">
    <div style="background:#0f172a; width:100%; max-width:500px; padding:30px; border-radius:30px; border:1px solid #334155; box-shadow:0 30px 100px rgba(0,0,0,0.8);">
        <h3 style="color:#fff; margin:0 0 20px;"><i class="fas fa-robot" style="color:#3b82f6;"></i> Reach Out <span style="color:#3b82f6;">Hub</span></h3>
        <p id="replyToText" style="font-size:12px; color:#94a3b8; margin-bottom:20px;"></p>
        
        <input type="hidden" id="replyId">
        <input type="hidden" id="replyEmail">
        
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; color:#3b82f6; font-weight:900; margin-bottom:10px;">COMPOSE MESSAGE</label>
            <textarea id="replyMsg" style="width:100%; height:150px; background:#000; border:1px solid #334155; color:#fff; padding:15px; border-radius:15px; font-size:13px; line-height:1.6; resize:none; outline:none;"></textarea>
            <button onclick="aiDraftReply()" style="background:rgba(59,130,246,0.1); border:1px solid #3b82f6; color:#3b82f6; font-size:10px; padding:8px 15px; border-radius:10px; margin-top:10px; cursor:pointer;"><i class="fas fa-magic"></i> Zayan: Draft Professional Reply</button>
        </div>

        <div style="display:flex; gap:15px;">
            <button onclick="sendReply()" id="sendBtn" style="flex:1.5; background:#3b82f6; border:none; color:#fff; font-weight:900; padding:12px; border-radius:15px; cursor:pointer;">FLY MESSAGE</button>
            <button onclick="closeReplyModal()" style="flex:1; background:rgba(255,255,255,0.05); color:#fff; border:1px solid #334155; padding:12px; border-radius:15px; cursor:pointer;">CANCEL</button>
        </div>
    </div>
</div>

<script>
let currentName = '';
let currentInquiry = '';

function openReplyModal(id, email, name, inquiry) {
    document.getElementById('replyId').value = id;
    document.getElementById('replyEmail').value = email;
    document.getElementById('replyToText').innerText = `Replying to ${name} (${email})`;
    document.getElementById('replyModal').style.display = 'flex';
    currentName = name;
    currentInquiry = inquiry;
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
    document.getElementById('replyMsg').value = '';
}

function aiDraftReply() {
    const box = document.getElementById('replyMsg');
    box.value = "Scanning inquiry context...";
    setTimeout(() => {
        box.value = `Hi ${currentName},\n\nThank you for reaching out to MensHub Prime regarding your inquiry: "${currentInquiry.substring(0, 30)}...".\n\nWe have reviewed your message and we appreciate your feedback/interest. Our team is looking into this as we speak. We will provide a detailed update within 24 hours.\n\nBest Regards,\nThe MensHub Intelligence Team`;
    }, 1000);
}

function sendReply() {
    const btn = document.getElementById('sendBtn');
    const msg = document.getElementById('replyMsg').value;
    const email = document.getElementById('replyEmail').value;
    const id = document.getElementById('replyId').value;
    
    if(!msg) { alert('Draft a message first!'); return; }
    
    btn.innerHTML = '<i class="fas fa-sync fa-spin"></i> TRANSMITTING...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('email', email);
    formData.append('message', msg);
    formData.append('name', currentName);
    formData.append('id', id);
    formData.append('table', 'messages');

    fetch('send-auto-reply.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.text())
    .then(data => {
        alert('Transmission Successful! Auto-reply sent to client.');
        location.reload(); // Refresh to show the new status badge
    })
    .catch(e => {
        alert('Server Error Node. Manual email suggested.');
        btn.innerHTML = 'FLY MESSAGE';
        btn.disabled = false;
    });
}
</script>

<?php include 'admin_footer.php'; ?>