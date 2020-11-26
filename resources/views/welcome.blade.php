<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIADMIN</title>

  <script src="{{ asset('js/adminlte.js') }}" defer></script>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
  <link href="{{ asset('fontawesome-free//css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark bg-dark ">
          <div class="container">
            <a href="#" class="navbar-brand">
              <img src="{{asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
              <span class="brand-text font-weight-light">SIADMIN</span>
            </a>
      
            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
      
            <div class="collapse navbar-collapse order-3 justify-content-end" id="navbarCollapse">
              <!-- Left navbar links -->
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a href="#" class="nav-link active">Inicio</a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">Servicios</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contactenos</a>
                </li>
              </ul>
            </div>
        </nav>
        <!-- /.navbar -->
      
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">    
          <div class="content-header">
            <div class="container">
                <h1 class="m-0"> Sistema administrativo para MiPymes</h1>
            </div>
          </div>     
          <div class="content">
            <div class="container">
              <div class="row">
                <div class="col-lg-4">
                  <img class="img-fluid" src="{{asset('images/imagen-muestra.jpg')}}" alt="Logo siadmin">
                </div>
                <!-- /.col-md-6 -->
                <div class="col-lg-8">      
                  <div class="card card-primary card-outline">
                    <div class="card-header">
                      <h5 class="card-title m-0"><strong>SIADMIN</strong></h5>
                    </div>
                    <div class="card-body">
                      <h4>Mejores resultados para tu negocio</h4>
                      <p class="card-text my-3">Siadmin es una herramienta administrativa para gestionar tu negocio, escribenos para brindarte las mejores soluciones y los mejores planes para tu empresa. <br>Si necesitas una demostracion de lo que hace la herramienta <a href="/contacto">Contactanos.</a></p>                      
                      <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                          <input type="email" name="email" class="form-control" placeholder="Correo electronico">
                          <div class="input-group-append">
                              <div class="input-group-text">
                                  <i class="fas fa-envelope"></i>
                              </div>
                          </div>
                        </div>
                        <div class="input-group mb-3">
                          <input type="password" name="password" class="form-control" placeholder="Contraseña">
                          <div class="input-group-append">
                              <div class="input-group-text">
                                  <i class="fas fa-lock"></i>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-12">
                              <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt mr-2"></i>Entrar</button>
                          </div>
                        </div>
                      </form> 
                    </div>
                  </div>
                </div>
                <!-- /.col-md-6 -->
              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content -->
        </div>
      
        <!-- Main Footer -->
        <footer class="main-footer">
          <strong>Copyright &copy; 2020 <a href="#">SIADMIN</a>.</strong> Todos los derechos reservados.
        </footer>
      </div>
<!-- /.login-box -->

</body>
</html>