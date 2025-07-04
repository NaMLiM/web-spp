<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: green;">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel d-flex mb-3 mt-3 pb-3">
            <div class="my-auto ml-3">
                <i class="nav-icon fas fa-user-circle fa-2x text-light"></i>
            </div>
            <div class="info">
                <a class="d-block" href="javascript:void(0)">{{ Auth::user()->username }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" data-accordion="false"
                role="menu">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'home' ? 'active' : '' }}"
                        href="{{ route('home.index') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Beranda
                        </p>
                    </a>
                </li>

                @role('admin')
                    <li class="nav-header">MANAJEMEN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'siswa' ? 'active' : '' }}"
                            href="{{ route('siswa.index') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Siswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'pembayaran-spp' ? 'active' : '' }}"
                            href="{{ route('pembayaran-spp.index') }}">
                            <i class="nav-icon fas fa-list"></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}"
                            href="{{ route('kelas.index') }}">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Kelas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'admin-list' ? 'active' : '' }}"
                            href="{{ route('admin-list.index') }}">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Admin
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'user' ? 'active' : '' }}"
                            href="{{ route('user.index') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'petugas' ? 'active' : '' }}"
                            href="{{ route('petugas.index') }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Petugas
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'spp' ? 'active' : '' }}"
                            href="{{ route('spp.index') }}">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>
                                SPP
                            </p>
                        </a>
                    </li>
                @endrole

                @role('petugas')
                    <li class="nav-header">MANAJEMEN DATA</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'siswa' ? 'active' : '' }}"
                            href="{{ route('siswa.index') }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Siswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'kelas' ? 'active' : '' }}"
                            href="{{ route('kelas.index') }}">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Kelas
                            </p>
                        </a>
                    </li>
                @endrole

                @role('admin')
                    <li class="nav-header">PEMBAYARAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'bayar' ? 'active' : '' }}"
                            href="{{ route('pembayaran.kelas') }}">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'status-pembayaran' ? 'active' : '' }}"
                            href="{{ route('pembayaran.status-pembayaran') }}">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>
                                Status Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'history-pembayaran' ? 'active' : '' }}"
                            href="{{ route('pembayaran.history-pembayaran') }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Riwayat Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'laporan' ? 'active' : '' }}"
                            href="{{ route('pembayaran.laporan') }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(3) == 'belum-bayar' ? 'active' : '' }}"
                            href="{{ route('laporan.belum_bayar') }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan Pembayaran
                            </p>
                        </a>
                    </li>
                @endrole

                @role('petugas')
                    <li class="nav-header">PEMBAYARAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'history-pembayaran' ? 'active' : '' }}"
                            href="{{ route('pembayaran.history-pembayaran') }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Riwayat Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'laporan' ? 'active' : '' }}"
                            href="{{ route('pembayaran.laporan') }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(3) == 'belum-bayar' ? 'active' : '' }}"
                            href="{{ route('laporan.belum_bayar') }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan Pembayaran
                            </p>
                        </a>
                    </li>
                @endrole

                @role('siswa')
                    <li class="nav-header">PEMBAYARAN</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::segment(2) == 'pembayaran-spp' ? 'active' : '' }}"
                            href="{{ route('siswa.pembayaran-spp') }}">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('siswa/history-pembayaran') ? 'active' : '' }}"
                            href="{{ route('siswa.history-pembayaran') }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                Riwayat Pembayaran
                            </p>
                        </a>
                    </li>
                @endrole

                {{-- @role('admin')
                <li class="nav-header">ROLES - PERMISSIONS</li>
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Roles List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('permissions.index') }}"
                        class="nav-link {{ Request::segment(2) == 'permissions' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-key"></i>
                        <p>
                            Permissions List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('role-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'role-permission' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Role - Permission
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-role.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user-role' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            User - Role
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-permission.index') }}"
                        class="nav-link {{ Request::segment(2) == 'user-permission' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            User - Permission
                        </p>
                    </a>
                </li>
                @endrole --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
