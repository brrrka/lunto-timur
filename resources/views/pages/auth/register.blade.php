<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Desa Lunto Timur - Register</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<style>
    body {
        /* Background gambar */
        background-size: cover; /* Menutupi seluruh area */
        background-position: center; /* Memusatkan gambar */
        background-repeat: no-repeat; /* Mencegah pengulangan gambar */
        
        height: 100vh; /* Pastikan body setinggi viewport */
        position: relative; /* Penting untuk pseudo-element overlay */
        overflow: hidden; /* Mencegah scroll yang tidak diinginkan jika gambar terlalu besar */
    }

    /* Menambahkan overlay gelap sebagai pseudo-element */
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Hitam dengan opacity 50% */
        z-index: 1; /* Pastikan overlay di atas gambar background */
    }

    .container { /* Sesuaikan selektor ini jika kontainer konten kamu punya kelas lain */
        position: relative;
        z-index: 2; /* Harus lebih tinggi dari z-index overlay */
    }

    .bg-login-image {
        background: url('{{ asset('images/hero_slide3.jpg') }}'); /* Ganti dengan path gambar kamu */
        background-position: center;
        background-size: cover;
    }

    .btn-custom-register{
        background-color: #4CAF50 !important;
        border-color: #4CAF50 !important;
        color: #ffffff !important;
    }

    /* Opsional: Efek hover untuk tombol */
    .btn-custom-register:hover{
        background-color: #41be45ff!important;
        border-color: #7bdd7eff !important;
    }
</style>

<body class="bg-cover d-flex align-items-center justify-content-center" style="background-image: url('{{ asset('images/hero_slide1.jpg') }}');">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Registrasi</h1>
                                    </div>
                                    <form class="user" action="/register" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="inputName" name="name" placeholder="Full Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number"
                                                placeholder="Nomor Telepon" value="{{ old('phone_number') }}">
                                            @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="inputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="inputPassword" name="password" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-custom-register btn-user btn-block">
                                            Simpan
                                        </button>
                                        <hr>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" style="color: #4CAF50" href="/login">Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}{"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>