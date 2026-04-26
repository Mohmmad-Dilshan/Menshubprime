<?php
session_start();
$page_title = "Service Hire Requests";
include 'admin_header.php';

// Delete request
if(isset($_GET['delete'])){
  $id = mysqli_real_escape_string($conn, $_GET['delete']);
  mysqli_query($conn,"DELETE FROM hire_requests WHERE id='$id'");
  echo "<script>window.location='manage-hire.php';</script>";
}

$q = mysqli_query($conn,"SELECT * FROM hire_requests ORDER BY id DESC");
$total = mysqli_num_rows($q);
?>

<div class="admin-card">
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h2>💼 Professional "Hire Me" Requests</h2>
    <span class="badge" style="background:rgba(245, 158, 11, 0.1); color:#f59e0b; font-size:14px;">
      Total: <?= $total; ?> Leads
    </span>
  </div>

  <div class="admin-table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Lead Name</th>
          <th>Contact Email</th>
          <th>Project Brief</th>
          <th>Received On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row=mysqli_fetch_assoc($q)){ ?>
        <tr>
          <td>#<?= $row['id']; ?></td>
          <td style="font-weight:700; color:var(--primary);"><?= htmlspecialchars($row['name']); ?></td>
          <td>
            <div style="font-size:13px;"><i class="fas fa-envelope"></i> <?= htmlspecialchars($row['email']); ?></div>
          </td>
          <td>
            <div style="max-width:350px; font-size:12px; line-height:1.5; background:rgba(255,255,255,0.03); padding:10px; border-radius:8px; border:1px solid var(--glass-border);">
              <?= nl2br(htmlspecialchars($row['message'])); ?>
            </div>
          </td>
          <td style="white-space:nowrap; font-size:12px; color:var(--text-muted);">
            <?= date('M d, Y', strtotime($row['created_at'])); ?><br>
            <small><?= date('h:i A', strtotime($row['created_at'])); ?></small>
          </td>
          <td style="display:flex; gap:8px; flex-wrap:wrap;">
            <button onclick="openReplyModal(<?= $row['id']; ?>, '<?= addslashes(htmlspecialchars($row['email'])); ?>', '<?= addslashes(htmlspecialchars($row['name'])); ?>', '<?= addslashes(str_replace(["\r", "\n"], ' ', htmlspecialchars($row['message']))); ?>')" class="admin-btn btn-primary" style="padding:8px 12px; font-size:12px; background:#3b82f6; border:none; cursor:pointer;" title="Reply with AI">
              <i class="fas fa-paper-plane"></i> Quick Reply
            </button>
            <a href="manage-hire.php?delete=<?= $row['id']; ?>" class="admin-btn btn-danger" style="padding:8px 12px; font-size:12px;" onclick="return confirm('Archive this hire request?')">
              <i class="fas fa-trash"></i>
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
        <h3 style="color:#fff; margin:0 0 20px;"><i class="fas fa-id-badge" style="color:#3b82f6;"></i> Talent <span style="color:#3b82f6;">Bridge</span></h3>
        <p id="replyToText" style="font-size:12px; color:#94a3b8; margin-bottom:20px;"></p>
        
        <input type="hidden" id="replyEmail">
        
        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:11px; color:#3b82f6; font-weight:900; margin-bottom:10px;">COMPOSE RECRUITER MESSAGE</label>
            <textarea id="replyMsg" style="width:100%; height:150px; background:#000; border:1px solid #334155; color:#fff; padding:15px; border-radius:15px; font-size:13px; line-height:1.6; resize:none; outline:none;"></textarea>
            <button onclick="aiDraftHireReply()" style="background:rgba(59,130,246,0.1); border:1px solid #3b82f6; color:#3b82f6; font-size:10px; padding:8px 15px; border-radius:10px; margin-top:10px; cursor:pointer;"><i class="fas fa-magic"></i> Zayan: Draft Interview Invite</button>
        </div>

        <div style="display:flex; gap:15px;">
            <button onclick="sendHireReply()" id="sendBtn" style="flex:1.5; background:#3b82f6; border:none; color:#fff; font-weight:900; padding:12px; border-radius:15px; cursor:pointer;">FLY RESPONSE</button>
            <button onclick="closeReplyModal()" style="flex:1; background:rgba(255,255,255,0.05); color:#fff; border:1px solid #334155; padding:12px; border-radius:15px; cursor:pointer;">CANCEL</button>
        </div>
    </div>
</div>

<script>
let currentName = '';
let currentMsg = '';

function openReplyModal(id, email, name, msg) {
    document.getElementById('replyEmail').value = email;
    document.getElementById('replyToText').innerText = `Replying to: ${name} (${email})`;
    document.getElementById('replyModal').style.display = 'flex';
    currentName = name;
    currentMsg = msg;
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
    document.getElementById('replyMsg').value = '';
}

function aiDraftHireReply() {
    const box = document.getElementById('replyMsg');
    box.value = "Analyzing talent context...";
    setTimeout(() => {
        box.value = `Dear ${currentName},\n\nThank you for reaching out to MensHub Prime with your service request regarding: "${currentMsg.substring(0, 40)}...".\n\nWe have reviewed your profile/project and would like to move forward. Can you provide a detailed portfolio or schedule a quick 10-minute discovery call this week?\n\nLooking forward to working with you,\nMensHub Operations Hub`;
    }, 1000);
}

function sendHireReply() {
    const btn = document.getElementById('sendBtn');
    const msg = document.getElementById('replyMsg').value;
    const email = document.getElementById('replyEmail').value;
    
    if(!msg) { alert('Draft a message first!'); return; }
    
    btn.innerHTML = '<i class="fas fa-sync fa-spin"></i> FLYING...';
    btn.disabled = true;

    const formData = new FormData();
    formData.append('email', email);
    formData.append('message', msg);
    formData.append('name', currentName);

    fetch('send-auto-reply.php', {
        method: 'POST',
        body: formData
    })
    .then(r => r.text())
    .then(data => {
        alert('Talent Response Sent!');
        closeReplyModal();
        btn.innerHTML = 'FLY RESPONSE';
        btn.disabled = false;
    })
    .catch(e => {
        alert('Transmission Failed.');
        btn.innerHTML = 'FLY RESPONSE';
        btn.disabled = false;
    });
}
</script>

<?php include 'admin_footer.php'; ?>