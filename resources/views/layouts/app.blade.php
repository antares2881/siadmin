<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/adminlte.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome-free//css/all.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper" id="app">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>            
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->email }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                        </a>

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
          <a href="index3.html" class="brand-link">
            <img src="{{asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SIADMIN</span>
          </a>
      
          <!-- Sidebar -->
          <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-header">MENU</li>
                @if (Auth::user()->role_id == 1)
                  <li class="nav-item @yield('open')">
                    <a href="#" class="nav-link @yield('administrar-active')">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        Administrar
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="categorias" class="nav-link @yield('categorias-active')">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Categorias</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="clientes" class="nav-link @yield('clientes-active')">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Clientes</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/empresas" class="nav-link @yield('empresas-active')'">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Empresas</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/productos" class="nav-link @yield('productos-active')">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Productos</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/proveedores" class="nav-link @yield('proveedores-active')">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Proveedores</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/usuarios" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Usuarios</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                @endif               
                
                <li class="nav-item">
                  <a href="/inventario" class="nav-link @yield('home-active')">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                      Inventario
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link @yield('compras-active')">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                      Compras
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link @yield('ventas-active')">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                      Ventas
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link @yield('reportes-active')">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>
                      Reportes
                    </p>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
