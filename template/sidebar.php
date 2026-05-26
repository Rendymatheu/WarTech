<?php
// sidebar.php — WarTech POS | Beach Dark Theme
// Compatible with AdminLTE 3.x
?>

<style>
/* ============================================================
   SIDEBAR — WARTECH BEACH DARK THEME
   ============================================================ */

/* Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap');

/* ── Root tokens ── */
:root {
    --sb-bg:          #0d1b2a;
    --sb-bg2:         #112233;
    --sb-accent:      #00bcd4;
    --sb-accent2:     #00a884;
    --sb-text:        #cce7f0;
    --sb-muted:       #6b8fa3;
    --sb-active-bg:   rgba(0, 188, 212, .13);
    --sb-active-text: #48CAE4;
    --sb-hover-bg:    rgba(0, 188, 212, .07);
    --sb-brand-h:     72px;
    --sb-radius:      14px;
    --sb-transition:  .22s cubic-bezier(.4,0,.2,1);
}

/* ── Sidebar shell ── */
.main-sidebar {
    background: var(--sb-bg) !important;
    border-right: 1px solid rgba(0, 188, 212, .08) !important;
    font-family: 'Nunito', sans-serif !important;
    width: 260px !important;
    box-shadow: 6px 0 32px rgba(0,0,0,.35) !important;
}

/* ── Brand bar ── */
.brand-link {
    background: linear-gradient(135deg, #0a2a3a 0%, #0d1b2a 100%) !important;
    border-bottom: 1px solid rgba(0,188,212,.15) !important;
    padding: 14px 20px !important;
    height: var(--sb-brand-h);
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    text-decoration: none !important;
    transition: background var(--sb-transition) !important;
}

.brand-link:hover {
    background: linear-gradient(135deg, #0e3347 0%, #112233 100%) !important;
}

.brand-image {
    width: 44px !important;
    height: 44px !important;
    object-fit: cover !important;
    border-radius: 14px !important;
    border: 2px solid var(--sb-accent) !important;
    box-shadow: 0 0 16px rgba(0,188,212,.3) !important;
    margin-right: 0 !important;
    margin-top: 0 !important;
    margin-left: 0 !important;
    flex-shrink: 0;
}

.brand-text {
    font-size: 1.25rem !important;
    font-weight: 800 !important;
    letter-spacing: .5px !important;
    background: linear-gradient(90deg, #48CAE4, #00a884);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* ── Sidebar inner ── */
.sidebar {
    background: transparent !important;
    padding: 10px 12px 20px !important;
    overflow-y: auto !important;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,188,212,.3) transparent;
}

.sidebar::-webkit-scrollbar { width: 4px; }
.sidebar::-webkit-scrollbar-thumb { background: rgba(0,188,212,.3); border-radius: 4px; }

/* ── User panel inside sidebar ── */
.sb-user-panel {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(0,188,212,.06);
    border: 1px solid rgba(0,188,212,.12);
    border-radius: var(--sb-radius);
    padding: 12px 14px;
    margin-bottom: 14px;
}

.sb-user-panel .sb-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--sb-accent);
    flex-shrink: 0;
}

.sb-user-panel .sb-avatar-placeholder {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--sb-accent2), var(--sb-accent));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    flex-shrink: 0;
    border: 2px solid var(--sb-accent);
}

.sb-user-info .sb-username {
    display: block;
    font-weight: 800;
    font-size: .88rem;
    color: #e0f7fa;
    line-height: 1.2;
}

.sb-user-info .sb-role {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 4px;
    font-size: .72rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
}

.sb-role.pemilik {
    background: rgba(245,127,23,.15);
    color: #ffcc80;
    border: 1px solid rgba(245,127,23,.3);
}

.sb-role.kasir {
    background: rgba(0,168,132,.15);
    color: #80cbc4;
    border: 1px solid rgba(0,168,132,.3);
}

/* ── Nav section header ── */
.nav-header {
    font-size: .65rem !important;
    font-weight: 800 !important;
    letter-spacing: 1.5px !important;
    text-transform: uppercase !important;
    color: var(--sb-muted) !important;
    padding: 18px 8px 6px !important;
}

/* ── Nav items ── */
.nav-sidebar .nav-item {
    margin-bottom: 2px;
}

.nav-sidebar > .nav-item > .nav-link,
.nav-treeview .nav-item .nav-link {
    border-radius: var(--sb-radius) !important;
    color: var(--sb-text) !important;
    padding: 10px 14px !important;
    font-weight: 600 !important;
    font-size: .875rem !important;
    transition: background var(--sb-transition), color var(--sb-transition), transform var(--sb-transition) !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    position: relative;
    overflow: hidden;
}

/* Shimmer on hover */
.nav-sidebar > .nav-item > .nav-link::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(0,188,212,.06), transparent);
    transform: translateX(-100%);
    transition: transform .5s;
    pointer-events: none;
}

.nav-sidebar > .nav-item > .nav-link:hover::before { transform: translateX(100%); }

.nav-sidebar > .nav-item > .nav-link:hover {
    background: var(--sb-hover-bg) !important;
    color: var(--sb-active-text) !important;
    transform: translateX(3px);
}

/* Active state */
.nav-sidebar > .nav-item > .nav-link.active,
.nav-sidebar > .nav-item > .nav-link.active:hover {
    background: var(--sb-active-bg) !important;
    color: var(--sb-active-text) !important;
    box-shadow: 0 4px 16px rgba(0,188,212,.15) !important;
    transform: none !important;
}

/* Left accent bar on active */
.nav-sidebar > .nav-item > .nav-link.active::after {
    content: '';
    position: absolute;
    left: 0; top: 20%; bottom: 20%;
    width: 3px;
    border-radius: 4px;
    background: var(--sb-accent);
    box-shadow: 0 0 10px var(--sb-accent);
}

/* ── Nav icons ── */
.nav-icon {
    width: 22px !important;
    text-align: center !important;
    font-size: .88rem !important;
    color: var(--sb-muted) !important;
    transition: color var(--sb-transition) !important;
    flex-shrink: 0 !important;
}

.nav-link:hover .nav-icon,
.nav-link.active .nav-icon {
    color: var(--sb-accent) !important;
}

/* ── Treeview arrow ── */
.nav-link .right {
    margin-left: auto !important;
    color: var(--sb-muted) !important;
    font-size: .75rem !important;
    transition: transform var(--sb-transition) !important;
}

.nav-item.menu-open > .nav-link .right {
    transform: rotate(-90deg) !important;
}

/* ── Treeview submenu ── */
.nav-treeview {
    padding-left: 10px !important;
    border-left: 2px solid rgba(0,188,212,.12) !important;
    margin-left: 24px !important;
    margin-top: 2px !important;
}

.nav-treeview .nav-item .nav-link {
    padding: 8px 12px !important;
    font-size: .82rem !important;
    color: var(--sb-muted) !important;
    border-radius: 10px !important;
}

.nav-treeview .nav-item .nav-link:hover {
    background: var(--sb-hover-bg) !important;
    color: var(--sb-active-text) !important;
}

.nav-treeview .nav-item .nav-link.active {
    background: var(--sb-active-bg) !important;
    color: var(--sb-active-text) !important;
}

.nav-treeview .nav-icon {
    font-size: .55rem !important;
    color: rgba(0,188,212,.35) !important;
}

.nav-treeview .nav-link:hover .nav-icon,
.nav-treeview .nav-link.active .nav-icon {
    color: var(--sb-accent) !important;
}

/* ── Bottom version badge ── */
.sb-version {
    margin-top: 20px;
    padding: 8px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .7rem;
    color: var(--sb-muted);
    border-top: 1px solid rgba(0,188,212,.08);
}

.sb-version span {
    font-weight: 700;
    color: rgba(0,188,212,.55);
}

/* ── Sidebar collapse fix ── */
body.sidebar-collapse .main-sidebar {
    width: 4.6rem !important;
    overflow: hidden !important;
}

body.sidebar-collapse .main-sidebar:hover {
    width: 260px !important;
    overflow: visible !important;
}

body.sidebar-collapse .brand-text,
body.sidebar-collapse .sb-user-info,
body.sidebar-collapse .sb-username,
body.sidebar-collapse .sb-role,
body.sidebar-collapse .nav-sidebar .p,
body.sidebar-collapse .nav-header {
    display: none !important;
}

body.sidebar-collapse .sb-user-panel {
    justify-content: center !important;
    padding: 10px !important;
}

body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link {
    justify-content: center !important;
    padding: 10px !important;
}

body.sidebar-collapse .nav-sidebar > .nav-item > .nav-link p {
    display: none !important;
}

body.sidebar-collapse .nav-icon {
    margin: 0 !important;
}

/* ── Navbar dark mode fix ── */
body.dark-mode .main-header.navbar {
    background: linear-gradient(90deg, #0a2a3a, #0d1b2a) !important;
    border-bottom: 1px solid rgba(0, 188, 212, .15) !important;
    box-shadow: 0 2px 16px rgba(0,0,0,.4) !important;
}

body.dark-mode .main-header .nav-link {
    color: #cce7f0 !important;
}

body.dark-mode .main-header .nav-link:hover {
    color: #48CAE4 !important;
}

body.dark-mode .custom-control-label {
    color: #cce7f0 !important;
}

body.dark-mode .dropdown-menu {
    background-color: #112233 !important;
    border: 1px solid rgba(0,188,212,.2) !important;
}

body.dark-mode .dropdown-menu .dropdown-item {
    color: #cce7f0 !important;
}

body.dark-mode .dropdown-menu .dropdown-item:hover {
    background-color: rgba(0,188,212,.1) !important;
    color: #48CAE4 !important;
}

body.dark-mode .dropdown-divider {
    border-color: rgba(0,188,212,.15) !important;
}
</style>

<!-- ======================================================
     MAIN SIDEBAR
     ====================================================== -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand -->
    <a href="<?= $main_url ?>dashboard.php" class="brand-link">
        <img src="<?= $main_url ?>asset/image/logo.png"
             alt="WarTech Logo"
             class="brand-image img-circle elevation-3">
        <span class="brand-text">WarTech</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- ── User panel ── -->
        <?php $me = userLogin(); ?>
        <div class="sb-user-panel mt-2 mb-1">
            <?php if (!empty($me['foto'])): ?>
                <img src="<?= $main_url ?>asset/image/<?= htmlspecialchars($me['foto']) ?>"
                     alt="avatar" class="sb-avatar">
            <?php else: ?>
                <div class="sb-avatar-placeholder">
                    <i class="fas fa-user"></i>
                </div>
            <?php endif; ?>
            <div class="sb-user-info">
                <span class="sb-username"><?= htmlspecialchars($me['fullname'] ?? $me['username']) ?></span>
                <?php if ($me['level'] == 1): ?>
                    <span class="sb-role pemilik"><i class="fas fa-crown"></i> Pemilik</span>
                <?php elseif ($me['level'] == 2): ?>
                    <span class="sb-role kasir"><i class="fas fa-cash-register"></i> Kasir</span>
                <?php else: ?>
                    <span class="sb-role kasir"><i class="fas fa-user"></i> Staff</span>
                <?php endif; ?>
            </div>
        </div>
        <!-- /user panel -->

        <!-- ── Menu ── -->
        <nav class="mt-1">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= $main_url ?>dashboard.php" class="nav-link <?= menuHome() ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master (hidden for level 3) -->
                <?php if ($me['level'] != 3): ?>
                <li class="nav-item <?= menuMaster() ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            Master
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $main_url ?>supplier/data-supplier.php"
                               class="nav-link <?= menuSupplier() ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $main_url ?>customer/data-customer.php"
                               class="nav-link <?= menuCustomer() ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $main_url ?>barang"
                               class="nav-link <?= menubarang() ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ── Transaksi ── -->
                <li class="nav-header">Transaksi</li>

                <li class="nav-item">
                    <a href="<?= $main_url ?>pembelian" class="nav-link <?= menuBeli() ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Pembelian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $main_url ?>penjualan" class="nav-link <?= menuJual() ?>">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>Penjualan</p>
                    </a>
                </li>

                <!-- ── Report ── -->
                <li class="nav-header">Report</li>

                <li class="nav-item">
                    <a href="<?= $main_url ?>laporan-pembelian" class="nav-link <?= laporanBeli() ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Laporan Pembelian</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $main_url ?>laporan-penjualan" class="nav-link <?= laporanJual() ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Laporan Penjualan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= $main_url ?>stock" class="nav-link <?= laporanStock() ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>Laporan Stock</p>
                    </a>
                </li>

                <!-- ── Pengaturan (level 1 only) ── -->
                <?php if ($me['level'] == 1): ?>
                <li class="nav-item <?= menuSetting() ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $main_url ?>user/data-user.php"
                               class="nav-link <?= menuuser() ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>
        </nav>
        <!-- /menu -->

    </div><!-- /.sidebar -->
</aside>