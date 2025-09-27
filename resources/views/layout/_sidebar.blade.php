<!-- Sidebar Menu -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center">
        <img src="{{ asset('images/logo.png') }}" 
             alt="Bank Sampah Logo" 
             class="brand-image img-circle elevation-3 me-2"
             style="opacity:.9; width:35px; height:35px; object-fit:cover;">
        <span class="brand-text font-weight-light">Bank Sampah</span>
    </a>
    <nav class="mt-2">
        @php
            $isActive = fn($patterns) => collect((array) $patterns)->contains(fn($p) => request()->is($p));
            $tabunganOpen = $isActive(['setoran*', 'tarik*', 'saldo*','transaksi*','laporan*']) ? 'menu-open' : '';
            $tabunganActive = $isActive(['setoran*', 'tarik*', 'saldo*','transaksi*']) ? 'active' : '';
            $nasabahOpen = $isActive(['nasabah*','user*','sampah*']) ? 'menu-open' : '';
            $nasabahActive = $isActive(['nasabah*','user*','sampah*']) ? 'active' : '';
            $laporanActive = $isActive(['laporan', 'laporan*']) ? 'active' : '';
            $role = Auth::user()->role ?? 'viewer';
        @endphp

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Untuk Role Nasabah -->
            @if ($role === 'nasabah')
                <li class="nav-item {{ $tabunganOpen }}">
                    <a href="#" class="nav-link {{ $isActive(['laporan*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transaksi.my-saldo') }}"
                                class="nav-link {{ request()->routeIs('transaksi.my-saldo') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-wallet"></i>
                                <p>Saldo Saya</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.transaksi') }}"
                                class="nav-link {{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Laporan Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- Untuk Role Admin -->
            @if ($role === 'admin')
                <li class="nav-item {{ $nasabahOpen }}">
                    <a href="#" class="nav-link {{ $nasabahActive }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Data Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index', [], false) ?? url('/user/index') }}"
                                class="nav-link {{ $isActive(['user']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nasabah.index', [], false) ?? url('/nasabah/index') }}"
                                class="nav-link {{ $isActive(['nasabah']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nasabah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sampah.index') }}"
                                class="nav-link {{ request()->routeIs('sampah.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Jenis Sampah</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $tabunganOpen }}">
                    <a href="#" class="nav-link {{ $tabunganActive }}">
                        <i class="nav-icon fas fa-piggy-bank"></i>
                        <p>
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('setoran.index', [], false) ?? url('/setoran/index') }}"
                                class="nav-link {{ $isActive(['setoran']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Setor Sampah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tarik.index', [], false) ?? url('/tarik/index') }}"
                                class="nav-link {{ $isActive(['tarik']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tarik Dana</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('saldo.index', [], false) ?? url('/saldo') }}"
                                class="nav-link {{ $isActive(['saldo', 'saldo*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lihat Saldo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}"
                                class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $isActive(['laporan*']) ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $isActive(['laporan*']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporan.transaksi') }}"
                                class="nav-link {{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Transaksi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.saldo', [], false) ?? url('/laporan/saldo') }}"
                                class="nav-link {{ $isActive(['laporan/saldo*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Saldo</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            
            <!-- Logout -->
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-power-off"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</aside>
