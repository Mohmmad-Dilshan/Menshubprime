<?php
session_start();
$page_title = "Admin Profile";
include 'admin_header.php';

/* FETCH ADMIN */
$admin = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT * FROM admin LIMIT 1")
);

/* UPDATE USERNAME */
if(isset($_POST['update_username'])){
  $newuser = mysqli_real_escape_string($conn, $_POST['username']);
  mysqli_query($conn,"UPDATE admin SET username='$newuser' WHERE id='".$admin['id']."'");
  echo "<script>alert('Username Updated'); window.location='profile.php';</script>";
}

/* UPDATE PASSWORD */
if(isset($_POST['update_password'])){
  $old = $_POST['old'];
  $new = $_POST['new'];
  if($old == $admin['password']){
    mysqli_query($conn,"UPDATE admin SET password='$new' WHERE id='".$admin['id']."'");
    echo "<script>alert('Password Updated'); window.location='profile.php';</script>";
  } else {
    echo "<script>alert('Old password wrong');</script>";
  }
}
?>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap:30px;">
  
  <div class="admin-card">
    <h3 style="margin-bottom:20px; color:var(--primary);"><i class="fas fa-user-circle"></i> Identity Settings</h3>
    <form action="" method="POST" class="admin-form">
      <label>Admin Username</label>
      <input type="text" name="username" value="<?= htmlspecialchars($admin['username']); ?>" autocomplete="username" required>
      <div style="margin-top:20px;">
        <button type="submit" name="update_username" class="admin-btn btn-primary" style="width:100%;">
          Update Username
        </button>
      </div>
    </form>
  </div>

  <div class="admin-card">
    <h3 style="margin-bottom:20px; color:#ef4444;"><i class="fas fa-key"></i> Security Settings</h3>
    <form action="" method="POST" class="admin-form">
      <label>Current Password</label>
      <input type="password" name="old" placeholder="Enter current password" autocomplete="current-password" required>
      
      <label>New Secure Password</label>
      <input type="password" name="new" placeholder="Enter new password" autocomplete="new-password" required>
      
      <div style="margin-top:20px;">
        <button type="submit" name="update_password" class="admin-btn btn-danger" style="width:100%;">
          Change Password
        </button>
      </div>
    </form>
  </div>

</div>

<div class="admin-card" style="margin-top:30px; background:rgba(255,255,255,0.02); border:1px dashed var(--glass-border);">
  <div style="display:flex; align-items:center; gap:20px; color:var(--text-muted); font-size:14px;">
    <i class="fas fa-shield-alt" style="font-size:30px; color:var(--primary);"></i>
    <div>
      <strong>Security Tip:</strong> Use a combination of uppercase, lowercase, numbers, and special characters for a strong password. Never share your admin credentials with anyone.
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>