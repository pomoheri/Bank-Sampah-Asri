      <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->

    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- @dd(auth()->user()) <!-- Debug di sini --> --}}
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth()->user()->name}}</a>
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

          @if(Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="/nasabah" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Pengelolaan Tabungan
              </p>
            </a>
          </li> 
          @endif
        
          <li class="nav-item">
            <a href="/nasabah" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Laporan
              </p>
            </a>
          </li> 
         
          @if(Auth::user()->role == 'admin')
          <li class="nav-item">
            <a href="/nasabah" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
              Pengelolaan  Nasabah
              </p>
            </a>
          </li> 
          @endif
          <li class="nav-item">
            <a href="/logout" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li> 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
</aside>
        <!-- /.sidebar -->
