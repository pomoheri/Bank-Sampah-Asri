<!-- Sidebar Menu -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Bank Sampah</span>
    </a>
    <nav class="mt-2">
        @php
            $isActive = fn($patterns) => collect((array) $patterns)->contains(fn($p) => request()->is($p));
            $tabunganOpen = $isActive(['setoran*', 'tarik*', 'saldo*']) ? 'menu-open' : '';
            $tabunganActive = $isActive(['setoran*', 'tarik*', 'saldo*']) ? 'active' : '';
            $nasabahOpen = $isActive(['nasabah*']) ? 'menu-open' : '';
            $nasabahActive = $isActive(['nasabah*']) ? 'active' : '';
            $laporanActive = $isActive(['laporan', 'laporan*']) ? 'active' : '';
            $role = Auth::user()->role ?? 'viewer';
        @endphp

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            {{-- ===== Pengelolaan Tabungan (admin & teller) ===== --}}
            @if (in_array($role, ['admin', 'teller']))
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item {{ $tabunganOpen }}">
                    <a href="#" class="nav-link {{ $tabunganActive }}">
                        <i class="nav-icon fas fa-piggy-bank"></i>
                        <p>
                            Pengelolaan Tabungan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        @if (in_array($role, ['admin', 'teller']))
                            <li class="nav-item">
                                <a href="{{ route('setoran.create', [], false) ?? url('/setoran/create') }}"
                                    class="nav-link {{ $isActive(['setoran/create']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Setor Sampah</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('tarik.create', [], false) ?? url('/tarik/create') }}"
                                    class="nav-link {{ $isActive(['tarik/create']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tarik Dana</p>
                                </a>
                            </li>
                        @endif
                        {{-- Semua role boleh lihat saldo --}}
                        <li class="nav-item">
                            <a href="{{ route('saldo.index', [], false) ?? url('/saldo') }}"
                                class="nav-link {{ $isActive(['saldo', 'saldo*']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lihat Saldo</p>
                            </a>
                        </li>
                        {{-- MENU BARU --}}
                        {{-- MENU BARU --}}
                        @php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            $role = $user->role ?? 'guest';
                            $nasabah = $user->nasabah ?? null;
                            $saldo = 0;

                            if ($role === 'nasabah' && $nasabah) {
                                $total_setoran = \App\Models\Setoran::where('nasabah_id', $nasabah->id)->sum('jumlah_uang');
                                $total_tarik = \App\Models\Tarik::where('nasabah_id', $nasabah->id)->sum(
                                    'jumlah_uang_tarik',
                                );
                                $saldo = $total_setoran - $total_tarik;
                            }
                        @endphp

                        

                        @if ($role === 'nasabah')
                            <li class="nav-item">
                                <a href="{{ route('transaksi.saldo') }}"
                                    class="nav-link {{ request()->routeIs('transaksi.saldo') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>
                                        Saldo Saya
                                        <span class="right badge badge-success">Rp {{ number_format($saldo) }}</span>
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- ===== Laporan (admin & teller & viewer) ===== --}}
            {{-- ===== Laporan (semua role bisa) ===== --}}
            <li class="nav-item {{ $isActive(['laporan*']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ $isActive(['laporan*']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>
                        Laporan
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if ($role === 'admin')
                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}"
                                class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-database"></i>
                                <p>Data Transaksi</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('transaksi.report') }}"
                            class="nav-link {{ request()->routeIs('transaksi.report') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan Transaksi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('setoran.report') }}"
                            class="nav-link {{ request()->routeIs('setoran.report') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan Setoran (Baru)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tarik.report') }}"
                            class="nav-link {{ request()->routeIs('tarik.report') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan Tarik (Baru)</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.setor', [], false) ?? url('/laporan/setor') }}"
                            class="nav-link {{ $isActive(['laporan/setor*']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Setor Sampah per Tanggal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.tarik', [], false) ?? url('/laporan/tarik') }}"
                            class="nav-link {{ $isActive(['laporan/tarik*']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tarik Dana per Tanggal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('laporan.saldo', [], false) ?? url('/laporan/saldo') }}"
                            class="nav-link {{ $isActive(['laporan/saldo*']) ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan Saldo</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tarik.report') }}" class="nav-link">
                            <i class="nav-icon fas fa-file-invoice"></i>
                            <p>Laporan Tarik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaksi.report') }}" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Laporan Transaksi</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ===== Pengelolaan Nasabah (admin only) ===== --}}
            @if ($role === 'admin')
                <li class="nav-item {{ $nasabahOpen }}">
                    <a href="#" class="nav-link {{ $nasabahActive }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Pengelolaan Nasabah
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('nasabah.create', [], false) ?? url('/nasabah/create') }}"
                                class="nav-link {{ $isActive(['nasabah/create']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Nasabah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nasabah.index', [], false) ?? url('/nasabah') }}"
                                class="nav-link {{ $isActive(['nasabah']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hapus Nasabah</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nasabah.index', [], false) ?? url('/nasabah') }}"
                                class="nav-link {{ $isActive(['nasabah']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Edit Nasabah</p>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            {{-- ===== Jenis Sampah (admin only) ===== --}}
            @if ($role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('sampah.index') }}"
                        class="nav-link {{ request()->routeIs('sampah.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-recycle"></i>
                        <p>Jenis Sampah</p>
                    </a>
                </li>
            @endif

            {{-- ===== Logout ===== --}}
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link">
                    <i class="nav-icon fas fa-power-off"></i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </nav>
</aside>
