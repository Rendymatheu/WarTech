<?php
session_start();

if (!isset($_SESSION["ssLoginPOS"])) {
    header("location: auth/login.php");
    exit();
}

$username      = isset($_SESSION["ssUserPOS"]) ? $_SESSION["ssUserPOS"] : "Admin";
$avatarInitial = strtoupper(substr($username, 0, 2));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WarTech - Memuat Dashboard...</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            width: 100%; height: 100%;
            font-family: 'Nunito', sans-serif;
        }

        .splash-screen {
            position: relative;
            width: 100vw; height: 100vh;
            background: linear-gradient(145deg, #e0f7fa 0%, #e3f2fd 50%, #e8f5e9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            animation: floatBubble 5s ease-in-out infinite;
        }
        .bubble-1 { width: 320px; height: 320px; top: -80px; right: -60px; background: rgba(0,119,182,0.07); animation-delay: 0s; }
        .bubble-2 { width: 180px; height: 180px; top: 60px; left: -40px; background: rgba(0,150,199,0.09); animation-delay: 1.2s; }
        .bubble-3 { width: 90px; height: 90px; bottom: 120px; left: 80px; background: rgba(0,150,199,0.08); animation-delay: 2.5s; }
        .bubble-4 { width: 220px; height: 220px; bottom: -50px; right: 100px; background: rgba(72,202,228,0.10); animation-delay: 0.8s; }
        .bubble-5 { width: 60px; height: 60px; top: 40%; left: 15%; background: rgba(0,180,216,0.08); animation-delay: 3s; }

        @keyframes floatBubble {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-18px); }
        }

        .wave-container {
            position: absolute;
            bottom: 0; left: 0; right: 0; height: 160px;
            pointer-events: none;
        }
        .wave-container svg { width: 100%; height: 100%; }

        .splash-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .logo-ring {
            width: 100px; height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0077B6, #00B4D8);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
            animation: pulseRing 2.2s ease-in-out infinite;
        }

        @keyframes pulseRing {
            0%, 100% { box-shadow: 0 0 0 12px rgba(0,119,182,0.10), 0 0 0 24px rgba(0,119,182,0.05); }
            50%       { box-shadow: 0 0 0 16px rgba(0,119,182,0.13), 0 0 0 32px rgba(0,119,182,0.07); }
        }

        .app-title {
            font-size: 3rem; font-weight: 900;
            color: #0077B6; letter-spacing: 4px;
            margin-bottom: 6px;
            animation: fadeInUp 0.7s ease 0.2s both;
        }

        .app-subtitle {
            font-size: 0.85rem; font-weight: 600;
            color: #0096C7; letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeInUp 0.7s ease 0.3s both;
        }

        .welcome-badge {
            display: flex; align-items: center; gap: 10px;
            background: #fff;
            border-radius: 40px;
            padding: 10px 22px 10px 10px;
            box-shadow: 0 4px 20px rgba(0,119,182,0.12);
            margin-bottom: 36px;
            border: 1px solid rgba(0,150,199,0.15);
            animation: fadeInUp 0.7s ease 0.4s both;
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0096C7, #00B4D8);
            color: #fff; font-size: 13px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }

        .welcome-badge span { font-size: 14px; color: #0077B6; font-weight: 600; }
        .welcome-badge strong { font-weight: 800; }

        .loader-wrap {
            display: flex; flex-direction: column; align-items: center;
            gap: 8px; width: 260px;
            animation: fadeInUp 0.7s ease 0.5s both;
        }

        .loader-track {
            width: 100%; height: 5px;
            background: rgba(0,119,182,0.15);
            border-radius: 10px; overflow: hidden;
        }

        .loader-fill {
            height: 100%; width: 0%;
            background: linear-gradient(90deg, #0077B6, #00B4D8, #48CAE4);
            border-radius: 10px;
            transition: width 0.2s ease;
        }

        .loader-text {
            font-size: 12px; color: #0096C7;
            font-weight: 600; letter-spacing: 0.5px;
            transition: opacity 0.3s ease;
        }

        .percent-text {
            font-size: 13px; font-weight: 800;
            color: rgba(0,119,182,0.5);
            margin-top: 6px;
            animation: fadeInUp 0.7s ease 0.6s both;
        }

        .success-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #0077B6 0%, #00B4D8 60%, #48CAE4 100%);
            display: flex; align-items: center; justify-content: center;
            z-index: 20;
            opacity: 0; pointer-events: none;
            transition: opacity 0.4s ease;
        }
        .success-overlay.show { opacity: 1; pointer-events: all; }

        .success-box {
            display: flex; flex-direction: column;
            align-items: center; gap: 12px;
            transform: scale(0.8); opacity: 0;
            transition: transform 0.4s ease 0.15s, opacity 0.4s ease 0.15s;
        }
        .success-overlay.show .success-box { transform: scale(1); opacity: 1; }

        .check-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .success-text { font-size: 22px; font-weight: 800; color: #fff; }
        .success-sub  { font-size: 13px; color: rgba(255,255,255,0.75); font-weight: 600; }
    </style>
</head>
<body>

<div class="splash-screen">

    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    <div class="bubble bubble-4"></div>
    <div class="bubble bubble-5"></div>

    <div class="wave-container">
        <svg viewBox="0 0 1440 160" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,80 C240,140 480,20 720,80 C960,140 1200,40 1440,80 L1440,160 L0,160 Z" fill="rgba(0,119,182,0.08)"/>
            <path d="M0,110 C200,60 450,150 720,100 C990,55 1220,130 1440,100 L1440,160 L0,160 Z" fill="rgba(0,150,199,0.12)"/>
            <path d="M0,140 C300,100 600,160 900,130 C1100,110 1300,148 1440,138 L1440,160 L0,160 Z" fill="rgba(72,202,228,0.2)"/>
        </svg>
    </div>

    <div class="splash-content">

        <div class="logo-ring">
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                <ellipse cx="24" cy="30" rx="16" ry="6" fill="rgba(255,255,255,0.25)"/>
                <path d="M8 22 Q8 38 24 38 Q40 38 40 22 Z" fill="rgba(255,255,255,0.9)"/>
                <path d="M10 20 H38" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M16 20 C16 14 20 10 24 10 C28 10 32 14 32 20" stroke="white" stroke-width="2" stroke-linecap="round" fill="none"/>
                <path d="M20 8 C20 5 22 6 22 3" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                <path d="M24 7 C24 4 26 5 26 2" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                <path d="M28 8 C28 5 30 6 30 3" stroke="rgba(255,255,255,0.6)" stroke-width="1.5" stroke-linecap="round" fill="none"/>
            </svg>
        </div>

        <h1 class="app-title">WarTech</h1>
        <p class="app-subtitle">Sistem POS Warung Makan</p>

        <div class="welcome-badge">
            <div class="avatar"><?= $avatarInitial ?></div>
            <span>Selamat datang, <strong><?= htmlspecialchars($username) ?></strong>!</span>
        </div>

        <div class="loader-wrap">
            <div class="loader-track">
                <div class="loader-fill" id="loaderFill"></div>
            </div>
            <span class="loader-text" id="loaderText">Memuat dashboard...</span>
        </div>

        <div class="percent-text" id="percentText">0%</div>
    </div>

    <div class="success-overlay" id="successOverlay">
        <div class="success-box">
            <div class="check-icon">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="20" fill="rgba(255,255,255,0.15)"/>
                    <path d="M12 20 L18 26 L28 14" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <p class="success-text">Dashboard siap!</p>
            <p class="success-sub">Mengarahkan...</p>
        </div>
    </div>

</div>

<script>
(function () {
    var redirectUrl   = 'dashboard.php';
    var totalDuration = 3000;

    var loaderFill     = document.getElementById('loaderFill');
    var loaderText     = document.getElementById('loaderText');
    var percentText    = document.getElementById('percentText');
    var successOverlay = document.getElementById('successOverlay');

    var messages = [
        { pct: 0,   text: 'Memuat konfigurasi...' },
        { pct: 30,  text: 'Menghubungkan database...' },
        { pct: 55,  text: 'Menyiapkan data produk...' },
        { pct: 75,  text: 'Memuat komponen dashboard...' },
        { pct: 90,  text: 'Hampir selesai...' },
        { pct: 100, text: 'Siap!' },
    ];

    var startTime = null;
    var lastMsg   = '';

    function easeOutCubic(t) { return 1 - Math.pow(1 - t, 3); }

    function updateMessage(pct) {
        var current = messages[0].text;
        for (var i = 0; i < messages.length; i++) {
            if (pct >= messages[i].pct) current = messages[i].text;
        }
        if (lastMsg !== current) {
            lastMsg = current;
            loaderText.style.opacity = '0';
            setTimeout(function () {
                loaderText.textContent = current;
                loaderText.style.opacity = '1';
            }, 150);
        }
    }

    function animate(timestamp) {
        if (!startTime) startTime = timestamp;
        var progress = Math.min((timestamp - startTime) / totalDuration, 1);
        var pct      = Math.round(easeOutCubic(progress) * 100);

        loaderFill.style.width  = pct + '%';
        percentText.textContent = pct + '%';
        updateMessage(pct);

        if (progress < 1) {
            requestAnimationFrame(animate);
        } else {
            successOverlay.classList.add('show');
            setTimeout(function () { window.location.href = redirectUrl; }, 900);
        }
    }

    requestAnimationFrame(animate);
})();
</script>

</body>
</html>