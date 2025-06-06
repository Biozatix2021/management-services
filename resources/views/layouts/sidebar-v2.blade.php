<!-- Sidebar user panel (optional) -->
<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <a href="#" class="blink"><i class="fa fa-circle text-success"></i></a>
    </div>
    <div class="info">
        <a href="#" class="d-block">{{ session('name') }}</a>
    </div>
</div>

<!-- SidebarSearch Form -->
<div class="form-inline">
    <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
        </div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li
            class="nav-item {{ in_array(request()->path(), ['teknisi', 'rumah-sakit', 'sop-alat', 'template-uji-fungsi', 'data-perusahaan', 'data-garansi']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Master Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="/data-perusahaan" class="nav-link {{ request()->is('data-perusahaan') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Perusahaan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/teknisi" class="nav-link {{ request()->is('teknisi') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Teknisi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/rumah-sakit" class="nav-link {{ request()->is('rumah-sakit') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Rumah Sakit</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/data-garansi" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Garansi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/template-uji-fungsi" class="nav-link {{ request()->is('template-uji-fungsi') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Template Uji Fungsi</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ in_array(request()->path(), ['alat', 'instalasi-alat', 'data-uji-fungsi']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Alat
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="/alat" class="nav-link {{ request()->is('alat') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Alat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/instalasi-alat" class="nav-link {{ request()->is('instalasi-alat') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Instalasi Alat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/data-uji-fungsi" class="nav-link {{ request()->is('data-uji-fungsi') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Uji Fungsi (QC Internal)</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ in_array(request()->path(), ['services', 'penjadwalan', 'kalender-teknisi', 'services/create']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Services
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/services" class="nav-link {{ request()->is(['services', 'services/create']) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Services</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/penjadwalan" class="nav-link  {{ request()->is('penjadwalan') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Penjadwalan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kalender-teknisi" class="nav-link {{ request()->is('kalender-teknisi') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Lihat Kalender</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ in_array(request()->path(), ['gudang', 'stock-alat', 'detail-stock', 'stock-transfer']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-warehouse"></i>
                <p>
                    Inventory
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/gudang" class="nav-link {{ request()->is(['gudang']) ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Gudang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/stock-alat" class="nav-link {{ request()->is('stock-alat') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Management Stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/detail-stock" class="nav-link {{ request()->is('detail-stock') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Detail Stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/stock-transfer" class="nav-link {{ request()->is('stock-transfer') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock Transfer</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
                <i class="nav-icon far fa-calendar-alt"></i>
                <p>
                    Permintaan Perbaikan
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
        </li>
        <hr>

        <li class="nav-item mb-5">
            <a href="/pengaturan" class="nav-link  {{ request()->is('pengaturan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                    Pengaturan
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->
