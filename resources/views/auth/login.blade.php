<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Bank Sampah Digital</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">

  <style>
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Source Sans Pro', sans-serif;
      background: linear-gradient(135deg, rgba(76,175,80,0.9), rgba(46,125,50,0.9)),
                  url("https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1500&q=80") 
                  no-repeat center center fixed;
      background-size: cover;
    }

    .login-box {
      width: 380px;
      z-index: 2;
    }

    .card {
      border-radius: 15px;
      overflow: hidden;
      backdrop-filter: blur(8px);
      background: rgba(255,255,255,0.9);
    }

    .btn-green {
      background-color: #2e7d32;
      color: #fff;
      border: none;
    }
    .btn-green:hover {
      background-color: #256528;
      color: #fff;
    }
  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <i class="fas fa-recycle text-success"></i> <b>Bank Sampah</b> Asri
  </div>

  <div class="card shadow">
    <div class="card-body login-card-body">
      @if(session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
      @endif

      <p class="login-box-msg">Silakan masuk untuk melanjutkan</p>

      <form action="/login" method="post">
        @csrf
        {{-- Email --}}
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>

        {{-- Password --}}
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
          <div class="input-group-append show-password">
            <div class="input-group-text"><span class="fas fa-lock" id="password-lock"></span></div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-success">
              <input type="checkbox" name="remember" id="remember">
              <label for="remember">Ingat saya</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-green btn-block">Masuk</button>
          </div>
        </div>
      </form>

      <p class="mb-1 mt-3">
        <a href="{{ url('/forgot-password') }}">Lupa password?</a>
      </p>
      <p class="mb-0">
        <a href="{{ url('/register') }}" class="text-center">Daftar akun baru</a>
      </p>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<script>
  $('.show-password').on('click', function() {
    var passwordField = $('#password');
    var passwordLock = $('#password-lock');
    if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
        passwordLock.removeClass('fa-lock').addClass('fa-unlock');
    } else {
        passwordField.attr('type', 'password');
        passwordLock.removeClass('fa-unlock').addClass('fa-lock');
    }
  });
</script>

</body>
</html>
