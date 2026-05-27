<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <div class="overlay">
        <i class="fas fa-2x fa-spinner fa-spin"></i>
      </div>
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-info navbar-light">

      <style>
        .navbar .nav-item.dropdown .nav-link.dropdown-toggle::after {
            display: none !important;
        }

        /* Dark mode - trigger button */
        body.dark-mode .nav-item.dropdown .nav-link.dropdown-toggle {
            background: rgba(0, 188, 212, .15) !important;
            border: 1.5px solid rgba(0, 188, 212, .3) !important;
        }

        /* Dark mode - dropdown menu */
        body.dark-mode .dropdown-menu.dropdown-menu-right {
            background: #1e2d3d !important;
            box-shadow: 0 15px 35px rgba(0,0,0,.4) !important;
        }

        body.dark-mode .dropdown-menu .dropdown-item {
            color: #cce7f0 !important;
        }

        body.dark-mode .dropdown-menu .dropdown-item:hover {
            background: #253545 !important;
            color: #90E0EF !important;
        }

        body.dark-mode .dropdown-divider {
            border-color: #2a3f52 !important;
        }

        body.dark-mode .dropdown-menu .dropdown-item[href*="logout"] {
            color: #ef9a9a !important;
        }

        body.dark-mode .dropdown-menu .dropdown-item[href*="logout"]:hover {
            color: #ffcdd2 !important;
        }
      </style>

      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
          </a>
        </li>
      </ul>

      <!-- Dark Mode Toggle -->
      <div class="ml-3 d-flex align-items-center" onclick="event.stopPropagation()">
        <div class="custom-control custom-switch custom-switch-on-success">
          <input type="checkbox" class="custom-control-input" id="cekDark">
          <label for="cekDark" class="custom-control-label text-white">Dark Mode</label>
        </div>
      </div>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="
                display: flex;
                align-items: center;
                gap: 8px;
                background: rgba(255,255,255,.15);
                border-radius: 20px;
                padding: 6px 14px;
            ">
                <img src="<?= $main_url ?>asset/image/<?= userLogin()['foto'] ?>" 
                    width="28" height="28" 
                    style="border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,.6);">
                <div style="display: flex; flex-direction: column; line-height: 1.2;">
                    <span style="font-weight: 700; font-size: 13px;"><?= userLogin()['username'] ?></span>
                    <span style="font-size: 10px; opacity: .75;">
                        <?= userLogin()['level'] == 1 ? '👑 Pemilik' : '💼 Kasir' ?>
                    </span>
                </div>
                <i class="fas fa-chevron-down" style="font-size: 11px; opacity: .8;"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" style="
                border: none;
                border-radius: 16px;
                box-shadow: 0 15px 35px rgba(0,0,0,.15);
                overflow: hidden;
                min-width: 220px;
                padding: 0;
            ">
                <!-- Header dropdown dengan foto -->
                <div style="background: linear-gradient(90deg, #00a884, #00bcd4); padding: 14px 18px; color: white; display: flex; align-items: center; gap: 12px;">
                    <img src="<?= $main_url ?>asset/image/<?= userLogin()['foto'] ?>" 
                         width="42" height="42" 
                         style="border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,.6); flex-shrink: 0;">
                    <div>
                        <div style="font-weight: 800; font-size: 15px;"><?= userLogin()['username'] ?></div>
                        <div style="font-size: 12px; opacity: .85;">
                            <?= userLogin()['level'] == 1 ? '👑 Pemilik' : '💼 Kasir' ?>
                        </div>
                    </div>
                </div>

                <!-- Edit Profile -->
                <a href="<?= $main_url ?>user/edit-user.php?id=<?= userLogin()['userid'] ?>" class="dropdown-item" style="padding: 12px 18px; font-weight: 600;">
                    <i class="fas fa-user-edit mr-2" style="color: #00bcd4;"></i> Edit Profile
                </a>
                <div class="dropdown-divider" style="margin: 0;"></div>

                <!-- Change Password -->
                <a href="<?= $main_url ?>auth/change-password.php" class="dropdown-item" style="padding: 12px 18px; font-weight: 600;">
                    <i class="fas fa-key mr-2" style="color: #ffa726;"></i> Change Password
                </a>
                <div class="dropdown-divider" style="margin: 0;"></div>

                <!-- Log Out -->
                <a href="<?= $main_url ?>auth/logout.php" class="dropdown-item" style="padding: 12px 18px; font-weight: 600; color: #e53935;">
                    <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                </a>
            </div>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->