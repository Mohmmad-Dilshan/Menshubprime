<?php
$dir = __DIR__ . '/admin8472panel';
$files = glob($dir . '/*.php');
$unauth = [];
foreach($files as $f) {
  $content = file_get_contents($f);
  $base = basename($f);
  if ($base === 'login.php' || $base === 'logout.php' || $base === 'check-login.php' || $base === 'admin_footer.php' || $base === 'admin_header.php') continue;
  
  if (strpos($content, 'admin_header.php') === false && 
      strpos($content, 'admin_id') === false && 
      strpos($content, 'check-login.php') === false) {
    $unauth[] = $base;
  }
}
echo json_encode($unauth);
