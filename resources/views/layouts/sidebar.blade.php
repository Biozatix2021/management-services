<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Alexander Pierce</p>
            <a href="#" class="blink"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="">
            <a href="/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li
            class="treeview {{ in_array(request()->path(), ['alat', 'teknisi', 'rumah-sakit', 'sop-alat', 'template-uji-fungsi', 'data-perusahaan', 'data-garansi']) ? 'active' : '' }}">
            <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Master Data</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu ">
                <li class="{{ request()->is('data-perusahaan') ? 'active' : '' }}"><a href="/data-perusahaan"><i class="fa fa-circle-o"></i> Data Perusahaan</a></li>
                <li class="{{ request()->is('alat') ? 'active' : '' }}"><a href="/alat"><i class="fa fa-circle-o"></i> Data Alat</a></li>
                <li class="{{ request()->is('teknisi') ? 'active' : '' }}"><a href="/teknisi"><i class="fa fa-circle-o"></i> Data Teknisi</a></li>
                <li class="{{ request()->is('rumah-sakit') ? 'active' : '' }}"><a href="/rumah-sakit"><i class="fa fa-circle-o"></i>Data Rumah Sakit</a></li>
                <li class="{{ request()->is('template-uji-fungsi') ? 'active' : '' }}"><a href="/template-uji-fungsi"><i class="fa fa-circle-o"></i> Template Uji
                        Fungsi</a>
                </li>
                <li class="{{ request()->is('data-garansi') ? 'active' : '' }}"><a href="/data-garansi"><i class="fa fa-circle-o"></i> Data Garansi</a>
                </li>
                <li class="{{ request()->is('sop-alat') ? 'active' : '' }}"><a href="/sop-alat"><i class="fa fa-circle-o"></i>
                        SOP Pemeriksaan Alat</a></li>
            </ul>
        </li>
        <li class="treeview {{ in_array(request()->path(), ['instalasi-alat', 'data-uji-fungsi']) ? 'active' : '' }}">
            <a href="#">
                <i class="fa fa-microchip" aria-hidden="true"></i>
                <span>Alat</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ request()->is('instalasi-alat') ? 'active' : '' }}">><a href="/instalasi-alat"><i class="fa fa-circle-o"></i>Instalasi Alat</a></li>
                <li class="{{ request()->is('data-uji-fungsi') ? 'active' : '' }}"><a href="/data-uji-fungsi"><i class="fa fa-circle-o"></i>Uji Fungsi (QC Internal)</a>
                </li>
                <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
            </ul>
        </li>
        <li class="treeview {{ in_array(request()->path(), ['penjadwalan', 'kalender-teknisi']) ? 'active' : '' }}">
            <a href="#">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                <span>Services</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ request()->is('penjadwalan') ? 'active' : '' }}"><a href="/penjadwalan"><i class="fa fa-circle-o"></i>Penjadwalan</a></li>
                <li class="{{ request()->is('kalender-teknisi') ? 'active' : '' }}"><a href="/kalender-teknisi"><i class="fa fa-circle-o"></i>Lihat Kalender</a></li>
                <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Kontrak Servis</a></li>
                <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
            </ul>
        </li>
        {{-- <li class="treeview">
            <a href="#">
                <i class="fa fa-edit"></i> <span>Forms</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-table"></i> <span>Tables</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="../tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                <li><a href="../tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
            </ul>
        </li> --}}
        <li>
            <a href="../calendar.html">
                <i class="fa fa-envelope"></i> <span>Permintaan Perbaikan</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-red">3</small>
                </span>
            </a>
        </li>
        <li>
            <a href="../mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">12</small>
                    <small class="label pull-right bg-green">16</small>
                    <small class="label pull-right bg-red">5</small>
                </span>
            </a>
        </li>

        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">Settings</li>
        <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>User</span></a></li>
    </ul>
</section>
