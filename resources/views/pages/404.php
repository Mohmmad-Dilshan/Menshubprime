<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Lost in Style | MenHub Prime</title>
    <meta name="description" content="Sorry, the page you are looking for does not exist on MenHub Prime. Return to our homepage for the best deals, blogs, and digital products for men.">
    
    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;400;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #f97316;
            --secondary: #3b82f6;
            --bg: #020617;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* CINEMATIC BACKGROUND */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(249, 115, 22, 0.1), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(59, 130, 246, 0.1), transparent 40%);
            z-index: -1;
        }

        .grid-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('assets/images/grid-dots.png') repeat;
            opacity: 0.1;
            z-index: -1;
            transform: scale(1.5) rotate(5deg);
        }

        .err-container {
            text-align: center;
            padding: 20px;
            z-index: 1;
            animation: fadeIn 1.2s ease;
        }

        .err-visual {
            position: relative;
            margin-bottom: 30px;
        }

        .err-code {
            font-size: clamp(120px, 20vw, 240px);
            font-weight: 900;
            line-height: 1;
            margin: 0;
            background: linear-gradient(135deg, #fff 30%, rgba(255,255,255,0.1));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            letter-spacing: -10px;
        }

        .err-code::after {
            content: '404';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: blur(40px);
            opacity: 0.4;
            z-index: -1;
        }

        .err-glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 40px;
            padding: 50px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
        }

        .err-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #fff;
        }

        .err-text {
            color: #94a3b8;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .home-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 40px;
            background: linear-gradient(135deg, var(--primary), #c2410c);
            color: #fff;
            text-decoration: none;
            border-radius: 100px;
            font-weight: 800;
            font-size: 16px;
            transition: 0.3s;
            box-shadow: 0 15px 30px rgba(249, 115, 22, 0.3);
        }

        .home-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(249, 115, 22, 0.4);
        }

        .err-icon {
            font-size: 50px;
            color: var(--primary);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .err-glass-card { padding: 35px 25px; border-radius: 30px; }
            .err-code { font-size: 140px; }
            .err-title { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="grid-bg"></div>

    <div class="err-container">
        
        <div class="err-visual">
            <h1 class="err-code">404</h1>
        </div>

        <div class="err-glass-card">
            <i class="fas fa-compass err-icon"></i>
            <h2 class="err-title">You've reached a dead end!</h2>
            <p class="err-text">
                Sorry bhai 😅, it looks like this page took a wrong turn or doesn't exist anymore. Let's get you back to the best deals.
            </p>
            <a href="/" class="home-btn">
                <i class="fas fa-home"></i> Back to Homepage
            </a>
        </div>

    </div>

</body>
</html>
