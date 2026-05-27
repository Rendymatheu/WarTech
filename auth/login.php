<?php

session_save_path('/tmp');
session_start();

if (isset($_SESSION["ssLoginPOS"])) {
    header("location: ../dashboard.php");
    exit();
}

require "../config/config.php";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $queryLogin = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE username = '$username'");

    if (mysqli_num_rows($queryLogin) === 1) {
        $row = mysqli_fetch_assoc($queryLogin);

        if (password_verify($password, $row['password'])) {

            $_SESSION["ssLoginPOS"] = true;
            $_SESSION["ssUserPOS"] = $username;

            header("location: ../index.php");
            exit();

        } else {
            echo "<script>alert('Password salah..');</script>";
        }
    } else {
        echo "<script>alert('Username tidak terdaftar..');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — WarTech</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= $main_url ?>asset/AdminLTE-3.2.0/dist/css/adminlte.min.css">
    <link rel="shortcut icon" href="<?= $main_url ?>asset/image/cart.png" type="image/x-icon">

    <style>
        /* ===== BEACH + WARTEG THEME - LOGIN ===== */

        * { box-sizing: border-box; }

        body.login-page {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex !important;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top left,  rgba(0, 188, 212, .22), transparent 40%),
                radial-gradient(circle at bottom right, rgba(0, 168, 132, .18), transparent 40%),
                linear-gradient(135deg, #e0f7fa 0%, #fdf6e3 100%) !important;
            overflow: hidden;
            position: relative;
        }

        /* ── Pola anyaman halus di background ── */
        body.login-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                repeating-linear-gradient(45deg,  rgba(0,150,180,.04) 0px, rgba(0,150,180,.04) 1px, transparent 1px, transparent 14px),
                repeating-linear-gradient(-45deg, rgba(0,150,180,.04) 0px, rgba(0,150,180,.04) 1px, transparent 1px, transparent 14px);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Floating gelembung / uap pantai ── */
        .steam {
            position: fixed;
            bottom: -60px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,188,212,.15), transparent 70%);
            animation: steamRise linear infinite;
            z-index: 0;
            filter: blur(8px);
        }
        .steam:nth-child(1) { left: 10%;  width: 45px; height: 130px; animation-duration: 7s;  animation-delay: 0s;   opacity: .7; }
        .steam:nth-child(2) { left: 27%;  width: 28px; height: 95px;  animation-duration: 9s;  animation-delay: 1.5s; opacity: .5; }
        .steam:nth-child(3) { left: 53%;  width: 55px; height: 150px; animation-duration: 8s;  animation-delay: 0.8s; opacity: .6; }
        .steam:nth-child(4) { left: 74%;  width: 32px; height: 110px; animation-duration: 11s; animation-delay: 2s;   opacity: .4; }
        .steam:nth-child(5) { left: 90%;  width: 22px; height: 85px;  animation-duration: 6s;  animation-delay: 3s;   opacity: .5; }

        @keyframes steamRise {
            0%   { transform: translateY(0)    scaleX(1);  opacity: 0; }
            15%  { opacity: 1; }
            80%  { opacity: .3; }
            100% { transform: translateY(-110vh) scaleX(2); opacity: 0; }
        }

        /* ── Wrapper utama ── */
        .warteg-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px 16px;
            animation: slideDown .5s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-36px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Spanduk / Banner atas — warna beach ── */
        .warteg-banner {
            background: linear-gradient(135deg, #0077b6, #00a884, #00bcd4);
            border-radius: 20px 20px 0 0;
            padding: 28px 24px 22px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .warteg-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                90deg,
                transparent, transparent 18px,
                rgba(255,255,255,.07) 18px, rgba(255,255,255,.07) 19px
            );
        }

        /* Lampu-lampu dekoratif di banner */
        .banner-lights {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 14px;
            position: relative;
            z-index: 1;
        }

        .banner-lights span {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            animation: blinkLight 1.8s ease-in-out infinite alternate;
        }

        .banner-lights span:nth-child(odd)  { background: #ffe066; }
        .banner-lights span:nth-child(even) { background: #fff; }
        .banner-lights span:nth-child(1) { animation-delay: 0s; }
        .banner-lights span:nth-child(2) { animation-delay: .2s; }
        .banner-lights span:nth-child(3) { animation-delay: .4s; }
        .banner-lights span:nth-child(4) { animation-delay: .6s; }
        .banner-lights span:nth-child(5) { animation-delay: .8s; }
        .banner-lights span:nth-child(6) { animation-delay: 1s; }
        .banner-lights span:nth-child(7) { animation-delay: 1.2s; }

        @keyframes blinkLight {
            from { opacity: .4; box-shadow: none; }
            to   { opacity: 1;  box-shadow: 0 0 8px 3px currentColor; }
        }

        .warteg-logo-ring {
            width: 78px;
            height: 78px;
            border-radius: 50%;
            background: rgba(255,255,255,.18);
            border: 3px solid rgba(255,255,255,.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            color: #fff;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
            box-shadow: 0 0 0 6px rgba(255,255,255,.08);
        }

        .warteg-banner h1 {
            color: #fff;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: 1px;
            margin: 0 0 4px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 8px rgba(0,0,0,.2);
        }

        .warteg-banner .tagline {
            color: rgba(255,255,255,.88);
            font-size: 12.5px;
            margin: 0;
            position: relative;
            z-index: 1;
            letter-spacing: .5px;
        }

        /* ── Body form ── */
        .warteg-body {
            background: rgba(255,255,255,.92);
            border-radius: 0 0 20px 20px;
            padding: 28px 28px 24px;
            box-shadow: 0 20px 50px rgba(0,100,150,.15);
        }

        /* Label section */
        .menu-label {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #0077b6;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-label::after {
            content: '';
            flex: 1;
            height: 2px;
            background: repeating-linear-gradient(90deg, #00bcd4 0px, #00bcd4 4px, transparent 4px, transparent 8px);
            border-radius: 2px;
        }

        /* Input */
        .warteg-input-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .warteg-input-wrap .form-control {
            background: #f7feff !important;
            border: 2px solid #e0f7fa !important;
            border-radius: 12px !important;
            padding: 13px 16px 13px 48px !important;
            font-size: 15px !important;
            color: #1f2d3d !important;
            transition: border-color .2s, box-shadow .2s;
            box-shadow: inset 0 2px 4px rgba(0,0,0,.03) !important;
        }

        .warteg-input-wrap .form-control::placeholder {
            color: #90cad4;
        }

        .warteg-input-wrap .form-control:focus {
            border-color: #00bcd4 !important;
            box-shadow: 0 0 0 4px rgba(0,188,212,.12) !important;
            outline: none !important;
            background: #fff !important;
        }

        .warteg-input-wrap .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #00a884;
            font-size: 16px;
            pointer-events: none;
        }

        /* Tombol masuk */
        .btn-warteg {
            width: 100%;
            background: linear-gradient(90deg, #00a884, #00bcd4) !important;
            border: none !important;
            border-radius: 14px !important;
            padding: 14px !important;
            font-size: 16px !important;
            font-weight: 800 !important;
            color: #fff !important;
            letter-spacing: .5px;
            box-shadow: 0 8px 24px rgba(0,168,132,.35), inset 0 1px 0 rgba(255,255,255,.2);
            transition: transform .15s, box-shadow .15s, opacity .15s;
            margin-top: 6px;
            cursor: pointer;
            display: block;
            text-align: center;
        }

        .btn-warteg:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0,168,132,.45);
            opacity: .93;
            color: #fff !important;
        }

        .btn-warteg:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(0,168,132,.3);
        }

        /* ── Strip tikar bawah — warna beach ── */
        .tikar-strip {
            height: 8px;
            background: repeating-linear-gradient(
                90deg,
                #0077b6 0px,  #0077b6 12px,
                #00a884 12px, #00a884 24px,
                #00bcd4 24px, #00bcd4 36px,
                #00a884 36px, #00a884 48px
            );
            border-radius: 0 0 20px 20px;
        }

        /* ── Footer ── */
        .warteg-footer {
            text-align: center;
            margin-top: 22px;
            color: #6c757d;
            font-size: 12px;
        }

        .warteg-footer strong {
            color: #00a884;
            font-weight: 700;
        }
    </style>
</head>

<body class="hold-transition login-page">

    <!-- Gelembung / uap pantai -->
    <div class="steam"></div>
    <div class="steam"></div>
    <div class="steam"></div>
    <div class="steam"></div>
    <div class="steam"></div>

    <div class="warteg-wrap">

        <div class="card" style="border:none; border-radius:20px; overflow:hidden; background:transparent; box-shadow:none;">

            <!-- Spanduk biru-teal -->
            <div class="warteg-banner">
                <div class="banner-lights">
                    <span></span><span></span><span></span><span></span>
                    <span></span><span></span><span></span>
                </div>
                <div class="warteg-logo-ring">
                    <i class="fas fa-store"></i>
                </div>
                <h1>WarTech</h1>
            </div>

            <!-- Body form -->
            <div class="warteg-body">

                <div class="menu-label">
                    <i class="fas fa-water"></i> Silakan Masuk
                </div>

                <form action="" method="post">

                    <div class="warteg-input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="username" class="form-control"
                            placeholder="Nama pengguna" required autocomplete="username">
                    </div>

                    <div class="warteg-input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control"
                            placeholder="Kata sandi" required autocomplete="current-password">
                    </div>

                    <button type="submit" name="login" class="btn-warteg">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk Sekarang
                    </button>

                </form>

            </div>

            <!-- Strip tikar biru -->
            <div class="tikar-strip"></div>

        </div>

        <div class="warteg-footer">
            Copyright &copy; 2026 &nbsp;|&nbsp; <strong>Kelompok 6</strong> &nbsp;|&nbsp; All rights reserved.
        </div>

    </div>

    <script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
    <script src="<?= $main_url ?>asset/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $main_url ?>asset/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

</body>
</html>