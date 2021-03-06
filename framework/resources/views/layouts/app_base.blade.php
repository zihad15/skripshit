<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIPAA</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendors/css/vendor.bundle.addons.css')}}" rel="stylesheet">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}">
  @yield('css')
</head>

<body>

  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ url('/') }}">
          <img src="{!! asset('assets/images/logo-trilogi.png') !!}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
          <img src="{!! asset('assets/images/logo-trilogi.png') !!}" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Halo {{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>
              <a href="{{ url('users/kelola-profil', Auth::user()->id) }}" class="dropdown-item mt-2">
                Kelola Profil
              </a>
              <a href="{{ route('logout') }}" class="dropdown-item">
                Keluar
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="text-wrapper">
                  <p class="profile-name">{{ Auth::user()->name }}</p>
                  <div>
                    @php($role = App\Role::find(Auth::user()->role_id))
                    <small class="designation text-muted">{{ $role->role_name }}</small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              <a href="{{ url('users/kelola-profil', Auth::user()->id) }}" class="btn btn-success btn-block">Kelola Profil</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('users.index') }}">
                <i class="menu-icon mdi mdi-account-box"></i>
                @if(Auth::user()->role_id == 2)
                  <span class="menu-title">Mahasiswa</span>
                  @if(Auth::user()->role_id == 2 && App\Helper::countFlexSM() > 0)
                  <span class="badge badge-pill badge-danger" style="margin-right: 20%">
                      {{ App\Helper::countFlexSM() }}
                  </span>
                  @endif
                @else
                  <span class="menu-title">Users</span>
                @endif
              </a>
            </li>
          @endif
          @if(Auth::user()->role_id == 2)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('prodi.index') }}">
                <i class="menu-icon mdi mdi-format-float-left"></i>
                <span class="menu-title">Prodi</span>
              </a>
            </li>
          @endif
          @if(Auth::user()->role_id != 1)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('permohonan.index') }}">
                <i class="menu-icon mdi mdi-clipboard-text"></i>
                <span class="menu-title">Permohonan</span>
                @if(Auth::user()->role_id == 2 && App\Helper::countKabagTask() > 0)
                  <span class="badge badge-pill badge-danger" style="margin-right: 20%">
                      {{ App\Helper::countKabagTask() }}
                  </span>
                @endif
              </a>
            </li>
          @endif
          @if(Auth::user()->role_id ==2)
            <li class="nav-item">
              <a class="nav-link" href="{{ url('report') }}">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Report</span>
              </a>
            </li>
          @endif
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper" @if(request()->is('/') || request()->is('home')) style="background-image: url('assets/images/bg_trilogi.png'); background-size: cover; background-repeat: no-repeat; background-position: center;" @endif>
            @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020
              <a href="#">Logic Dev</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{!! asset('assets/vendors/js/vendor.bundle.base.js') !!}"></script>
  <script src="{!! asset('assets/vendors/js/vendor.bundle.addons.js') !!}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{!! asset('assets/js/off-canvas.js') !!}"></script>
  <script src="{!! asset('assets/js/misc.js') !!}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{!! asset('assets/js/dashboard.js') !!}"></script>
  <!-- End custom js for this page-->
  @yield('js')
</body>
</html>