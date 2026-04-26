<?php

/**
 * MENS HUB PRIME - Ultimate Admin Login
 * Professional, Glassmorphism UI with BCRYPT Security and CSRF Protection.
 */

// Use unified bootstrap for session and DB
require_once __DIR__ . '/../src/bootstrap.php';

// CSRF Protection: Generate token if doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$msg = "";
$error_type = "";

if (isset($_POST['login'])) {
    // CSRF Check
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed. Possible cross-site request.");
    }

    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Login Throttling (Basic)
    if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] > 5 && (time() - $_SESSION['last_attempt_time'] < 600)) {
        $msg = "Too many attempts. Please wait 10 minutes.";
        $error_type = "throttle";
    } else {
        $q = mysqli_query($conn, "SELECT * FROM admin WHERE username='$user' LIMIT 1");

        if (mysqli_num_rows($q) == 1) {
            $row = mysqli_fetch_assoc($q);

            // BCRYPT Security (password_verify)
            if (password_verify($pass, $row['password'])) {
                // Success: Reset attempts
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                unset($_SESSION['login_attempts']);

                header("Location: dashboard.php");
                exit();
            } else {
                // Fallback for PLAIN TEXT transition (remove after migration)
                if ($pass === $row['password']) {
                   // Plain text matched - Auto upgrade for the user!
                   $new_hash = password_hash($pass, PASSWORD_BCRYPT);
                   mysqli_query($conn, "UPDATE admin SET password='$new_hash' WHERE id=".$row['id']);
                   $_SESSION['admin_id'] = $row['id'];
                   $_SESSION['admin_username'] = $row['username'];
                   header("Location: dashboard.php");
                   exit();
                }

                $msg = "Invalid credentials. Access denied.";
                $error_type = "auth";
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt_time'] = time();
            }
        } else {
            $msg = "Account not found.";
            $error_type = "notfound";
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
            $_SESSION['last_attempt_time'] = time();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Admin Access | MenHub Prime</title>
    
    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Space+Grotesk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #f97316;
            --primary-glow: rgba(249, 115, 22, 0.4);
            --bg-dark: #020617;
            --glass-bg: rgba(15, 23, 42, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-dim: #94a3b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            height: 100vh;
            background: var(--bg-dark);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            animation: move 20s infinite alternate ease-in-out;
        }

        .orb-1 { width: 400px; height: 400px; background: rgba(249, 115, 22, 0.15); top: -100px; left: -100px; }
        .orb-2 { width: 300px; height: 300px; background: rgba(56, 189, 248, 0.15); bottom: -50px; right: 10%; }

        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(100px, 50px) scale(1.1); }
        }

        .login-container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
            perspective: 1000px;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: cardEntrance 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            position: relative;
        }

        /* 2-Column Layout */
        .login-left {
            width: 50%;
            background: url("../assets/images/anime.jpg") center/cover;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 40px;
            min-height: 500px;
        }

        .login-left::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(2, 6, 23, 0.8) 0%, transparent 100%);
        }

        .left-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .left-content h2 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        .left-content p {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .login-right {
            width: 50%;
            padding: 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .glass-card { flex-direction: column; }
            .login-left { width: 100%; min-height: 200px; padding: 20px; }
            .login-right { width: 100%; padding: 30px 20px; }
            .login-left h2 { font-size: 24px; }
        }

        @keyframes cardEntrance {
            from { transform: translateY(30px) rotateX(-10deg); opacity: 0; }
            to { transform: translateY(0) rotateX(0); opacity: 1; }
        }

        /* Header Decor */
        .glass-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            z-index: 10;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-section i {
            font-size: 40px;
            color: var(--primary);
            text-shadow: 0 0 20px var(--primary-glow);
            margin-bottom: 15px;
        }

        .logo-section h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .logo-section p {
            color: var(--text-dim);
            font-size: 14px;
            margin-top: 5px;
        }

        /* Form Logic */
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i:not(.pw-toggle) {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            transition: 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            background: rgba(2, 6, 23, 0.4);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            color: white;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
        }

        .input-group input:focus {
            border-color: var(--primary);
            background: rgba(2, 6, 23, 0.6);
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.1);
        }

        .input-group input:focus + i {
            color: var(--primary);
        }

        /* Password Toggle */
        .pw-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            cursor: pointer;
            transition: 0.3s;
            padding: 5px;
        }

        .pw-toggle:hover {
            color: var(--primary);
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 20px -5px var(--primary-glow);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 15px 25px -5px var(--primary-glow);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Feedback UI */
        .error-box {
            background: rgba(239, 68, 68, 0.1);
            border-left: 4px solid #ef4444;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 25px;
            color: #fca5a5;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .footer-links {
            text-align: center;
            margin-top: 30px;
        }

        .footer-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 13px;
            transition: 0.3s;
        }

        .footer-links a:hover {
            color: var(--text-main);
        }

        /* Cinematic Maskot (Subtle) */
        .mascot-hint {
            position: absolute;
            bottom: -80px;
            right: -80px;
            opacity: 0.05;
            transform: rotate(-15deg);
            pointer-events: none;
        }

    </style>
</head>
<body>

    <!-- Background Decoration -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="login-container">
        <div class="glass-card">
            
            <div class="login-left">
                <div class="left-content">
                    <h2>Welcome Master</h2>
                    <p>Manage your empire with power and elegance.</p>
                </div>
            </div>

            <div class="login-right">
                <div class="logo-section">
                    <i class="fas fa-shield-halved"></i>
                    <h1>Admin Access</h1>
                </div>

                <?php if ($msg !== ""): ?>
                    <div class="error-box">
                        <i class="fas fa-circle-exclamation"></i>
                        <span><?= htmlspecialchars($msg); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="loginForm">
                    <!-- CSRF Token -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Username" required autocomplete="username">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                        <i class="fas fa-eye pw-toggle" onclick="togglePassword()"></i>
                    </div>

                    <button type="submit" name="login" class="login-btn" id="submitBtn">
                        <span>SECURE LOGIN</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="footer-links">
                    <a href="../"><i class="fas fa-arrow-left"></i> Back to Website</a>
                </div>
            </div>

            <!-- Subtle Mascot SVG -->
            <svg class="mascot-hint" width="200" height="200" viewBox="0 0 24 24" fill="white">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9h10v2H7z"/>
            </svg>
        </div>
    </div>

    <script>
        // --- FUNNY HINDI FEMALE AI VOICE ---
        function speakVibe(text) {
            const msg = new SpeechSynthesisUtterance();
            msg.text = text;
            msg.lang = 'hi-IN';
            msg.rate = 1.0;
            msg.pitch = 1.3;
            
            const voices = window.speechSynthesis.getVoices();
            const hindiVoice = voices.find(v => (v.lang === 'hi-IN' || v.lang === 'hi_IN') && v.name.toLowerCase().includes('google')) 
                             || voices.find(v => v.lang.includes('hi'))
                             || voices.find(v => v.name.toLowerCase().includes('female'));
            
            if (hindiVoice) msg.voice = hindiVoice;
            window.speechSynthesis.speak(msg);
        }

        function speakWelcome(isWaiting = false) {
            const introPhrases = [
                "नमस्ते मास्टर! कहाँ गायब थे आप? स्टोर तो मैं ही संभाल रही थी!",
                "अरे मास्टर आ गए! चलो सब लाइन लगाओ, असली बॉस आ गए हैं!",
                "सिस्टम अनलॉक हो गया है। स्वागत है मास्टर! आज कुछ तोड़ना मत, ठीक है?",
                "ओह हो! मास्टर, आज तो बड़े स्मार्ट लग रहे हो! जल्दी लॉगिन करो ना!",
                "अरे मास्टर, आपके बिना तो सर्वर भी दुखी था! स्वागत है मास्टर!"
            ];

            const waitingPhrases = [
                "क्या सोच रहे हो मास्टर? लॉगिन कर लो, कोई देख नहीं रहा!",
                "मास्टर, इतनी देर क्यों लग रही है? पासवर्ड भूल गए क्या?",
                "सिस्टम स्टेटस: बॉस का इंतज़ार। मास्टर, प्लीज जल्दी लॉगिन करो!",
                "मास्टर, मैं बोर हो रही हूँ! चलो जल्दी शुरू करो ना!"
            ];
            
            const selectedPhrases = isWaiting ? waitingPhrases : introPhrases;
            const text = selectedPhrases[Math.floor(Math.random() * selectedPhrases.length)];
            speakVibe(text);
        }

        function speakHackerMockery(attempts) {
            const hackerPhrases = [
                "अरे हैकर भाई! काली लिनक्स सीख कर आए हो क्या? चलो यहाँ से निकलो, यहाँ दाल नहीं गलेगी!",
                "पासवर्ड गलत है! क्या लगा, इतनी आसानी से मेन्स हब प्राइम हैक कर लोगे? थोड़ा और पढ़ के आओ!",
                "मास्टर, अगर ये आप हो तो बादाम खाया करो! और अगर कोई चोर है तो बेटा पुलिस को फोन मिलाऊं क्या?",
                "सिस्टम अलर्ट: हैकर डिटेक्टेड! भाई, कोडिंग सीख लो, पासवर्ड तुक्का मारने से काम नहीं चलेगा!",
                "इन्क्रिप्शन बहुत टाइट है दोस्त, आपके बाइनरी दिमाग से बाहर है ये सब! ट्राई करना बंद करो।",
                "ओह हो! हैकर बाबू के पसीने छूट रहे हैं? पासवर्ड तो सही डालो वरना सिस्टम लॉक कर दूंगी!",
                "लगता है आज हैकर बाबू ने च्यवनप्राश नहीं खाया! पासवर्ड भूल गए या चोरी करने आए हो?"
            ];
            
            const normalErrorPhrases = [
                "ओह! पासवर्ड गलत है। फिर से चेक करो मास्टर, गलती हो सकती है!",
                "गलत पासवर्ड! लगता है आज मास्टर की याददाश्त थोड़ी कमज़ोर लग रही है।"
            ];

            const selected = (attempts >= 2) ? hackerPhrases : normalErrorPhrases;
            const text = selected[Math.floor(Math.random() * selected.length)];
            
            // Hacker vibe: slightly higher pitch and faster rate for 'alert' mode
            const msg = new SpeechSynthesisUtterance();
            msg.text = text;
            msg.lang = 'hi-IN';
            msg.rate = (attempts >= 2) ? 1.1 : 1.0;
            msg.pitch = (attempts >= 2) ? 1.4 : 1.3;
            
            const voices = window.speechSynthesis.getVoices();
            const hindiVoice = voices.find(v => (v.lang === 'hi-IN' || v.lang === 'hi_IN') && v.name.toLowerCase().includes('google')) 
                             || voices.find(v => v.lang.includes('hi'));
            
            if (hindiVoice) msg.voice = hindiVoice;
            window.speechSynthesis.speak(msg);
        }

        let voiceInterval;

        window.addEventListener('load', () => {
            const runVoice = () => {
                <?php if($msg !== "" && ($error_type == 'auth' || $error_type == 'notfound')): ?>
                    // Handle Error Speech
                    speakHackerMockery(<?= $_SESSION['login_attempts'] ?? 0 ?>);
                <?php else: ?>
                    // Handle Welcome Speech
                    speakWelcome();
                <?php endif; ?>

                voiceInterval = setInterval(() => {
                    speakWelcome(true);
                }, 15000); // 15 seconds for variety
            };

            if (window.speechSynthesis.onvoiceschanged !== undefined) {
                window.speechSynthesis.onvoiceschanged = () => {
                    setTimeout(runVoice, 800);
                    window.speechSynthesis.onvoiceschanged = null;
                };
            } else {
                setTimeout(runVoice, 1000);
            }
        });

        function togglePassword() {
            const pwInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.pw-toggle');
// ... rest of scripts ...
            
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                pwInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add subtle 3D tilt effect on card
        const card = document.querySelector('.glass-card');
        document.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 45;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 45;
            card.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Reset on leave
        document.addEventListener('mouseleave', () => {
            card.style.transform = `rotateY(0deg) rotateX(0deg)`;
            card.style.transition = "all 0.5s ease";
        });

        document.addEventListener('mouseenter', () => {
            card.style.transition = "none";
        });
        
        // Handle loading state
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('submitBtn');
        form.addEventListener('submit', () => {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
            btn.style.opacity = "0.8";
            btn.style.pointerEvents = "none";
        });
    </script>
</body>
</html>