<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blood Bank</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="sweetalert2/dist/sweetalert2.all.min.js"></script>

  <!-- Include a polyfill for ES6 Promises (optional) for IE11 -->
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill9/dist/polyfill.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"  href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <a class="dropdown-item" href = "/BloodBank/public/admin/home" >Dashboard</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        
    </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('admin/home')}}" class="brand-link">
      <img src="{{asset('adminlte/img/AdminLTELogo.png')}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Adminstration</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('adminlte/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin name</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Posts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @if(Auth::user()->can('post-list'))
                <li class="nav-item">
                  <a href="{{url(route('post.index'))}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Posts</p>
                  </a>
                </li>
              @endif

              @if(Auth::user()->can('category-list'))
                <li class="nav-item">
                  <a href="{{url(route('category.index'))}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Categiries</p>
                  </a>
                </li>
              @endif
            </ul>
          </li>
          
          @if(Auth::user()->can('user-list'))
            <li class="nav-item">
              <a href="{{url(route('client.index'))}}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Clients</p>
              </a>
            </li>
          @endif

          @if(Auth::user()->can('governorate-list'))
            <li class="nav-item">
                  <a href="{{url(route('governorate.index'))}}" class="nav-link">
                      <i class="nav-icon fas fa-list"></i>
                      <p>Governorates</p>
                  </a>
            </li>
          @endif

          @if(Auth::user()->can('city-list'))
            <li class="nav-item">
              <a href="{{url(route('city.index'))}}" class="nav-link">
                  <i class="nav-icon fas fa-list"></i>
                  <p>Cities</p>
              </a>
            </li>
          @endif

          @if(Auth::user()->can('contact-list'))
            <li class="nav-item">
              <a href="{{url(route('contact.index'))}}" class="nav-link">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>Contacts</p>
              </a>
            </li>
          @endif

          @if(Auth::user()->can('donation-list'))
            <li class="nav-item">
                <a href="{{url(route('donation.index'))}}" class="nav-link">
                    <i class="nav-icon fas fa-bell"></i>
                    <p>Donation Requests</p>
                </a>
            </li>
          @endif

          @if(Auth::user()->can('setting-edit'))
            <li class="nav-item">
              <a href="{{url(route('setting.create'))}}" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings</p>
              </a>
            </li>
          @endif

          
          <li class="nav-item">
            <a href="{{url(route('changePassword'))}}" class="nav-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>Change Password</p>
            </a>
          </li>
          

          @if(Auth::user()->can('role-list'))
            <li class="nav-item">
                <a href="{{url(route('role.index'))}}" class="nav-link">
                  <i class="nav-icon fas fa-user-tag"></i>
                  <p>Roles</p>
                </a>
            </li>
          @endif

          @if(Auth::user()->can('user-list'))
            <li class="nav-item">
                <a href="{{url(route('user.index'))}}" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Users</p>
                </a>
            </li>
          @endif

          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('parties.flash-message')
   @yield('content')
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{asset('js/custom.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/js/demo.js')}}"></script>

</body>
</html>
