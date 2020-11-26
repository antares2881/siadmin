<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login SIADMIN</title>

        <script src="{{ asset('js/adminlte.js') }}" defer></script>


        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/adminlte.css') }}" rel="stylesheet">
        <link href="{{ asset('fontawesome-free//css/all.min.css') }}" rel="stylesheet">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                <a href="#" class="h1"><b>SI</b>ADMIN</a>
                </div>
                <div class="card-body">

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
                        <div class="col-8">
                            <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Recuerdame
                            </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt mr-2"></i>Entrar</button>
                        </div>
                        <!-- /.col -->
                        </div>
                    </form>               

                    <p class="mb-1">
                        <a href="/recupera-contraseña">Olvidaste tu contraseña ?</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </body>
</html>