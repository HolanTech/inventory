<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('produk.index') }}">
                    <i class="fa fa-cubes"></i> <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('member.index') }}">
                    <i class="fa fa-id-card"></i> <span>Member</span>
                </a>
            </li>

            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-upload"></i> <span>Penjualan</span>
                </a>
            </li>

            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li>


            <li>
                <a href="{{ route('setting.index') }}">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
