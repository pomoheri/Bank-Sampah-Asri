<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Bank Sampah Digital</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('Adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('Adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('Adminlte/dist/css/adminlte.min.css')}}">

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
      width: 480px;
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
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

      <p class="login-box-msg">Register Akun</p>

      <form action="{{ route('register.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap">
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email aktif">
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
               id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 08123456789">
        @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control @error('address') is-invalid @enderror" 
                  id="address" name="address" rows="2" placeholder="Masukkan alamat">{{ old('address') }}</textarea>
        @error('address')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" placeholder="Masukkan password">
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">
      </div>

        <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
            <button type="submit" class="btn btn-green btn-block">Daftar</button>
            </div>
        </div>

        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="{{ route('login') }}" class="text-success fw-bold">Masuk di sini</a></small>
        </div>
    </form>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{ asset('Adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('Adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('Adminlte/dist/js/adminlte.min.js')}}"></script>
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
