<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Desa Lunto Timur</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
    body {
    margin-top: 50px; /* Sesuaikan nilai ini sesuai tinggi navbar Anda */
    }
    .hero-slide {
    height: 100vh;
    background-size: cover;
    background-position: center;
    position: relative;
    }

    .hero-slide::before {
    content: "";
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Efek gelap */
    z-index: 1;
    }

    .hero-slide > .text-center, /* Untuk slide 1 dan 2 */
    .hero-slide > .container {  /* Untuk slide 3 */
        z-index: 2;
        position: relative;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        z-index: 3; /* Pastikan ini lebih tinggi dari z-index overlay (z-index: 1) */
    }

    .btn-custom-readmore {
        background-color: #4CAF50!important;
        border-color: #4CAF50 !important;
        color: #ffffff !important;
    }

    .btn-custom-readmore:hover {
        background-color: #41be45ff!important;
        border-color: #7bdd7eff !important;
    }

    .btn-custom-login, .btn-custom {
        background-color: #FFC107 !important; /* !important untuk menimpa gaya Bootstrap */
        border-color: #FFC107 !important;
        color: #000000 !important; /* Warna teks hitam agar terbaca */
    }

    /* Opsional: Efek hover untuk tombol */
    .btn-custom-login, .btn-custom:hover {
        background-color: #dba504ff!important; /* Warna sedikit lebih gelap saat di-hover */
        border-color: #dba504ff !important;
    }

    </style>
</head>

<body>
    <!-- Navbar -->
    @include('user.layout.navbar')

    @yield('content')


    <!-- Footer -->
    @include('user.layout.footer')

    @stack('scripts')
    
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('template/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('template/js/demo/chart-pie-demo.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    const carousel = document.querySelector('#heroCarousel');
    const bsCarousel = new bootstrap.Carousel(carousel, {
        interval: 5000,
        ride: 'carousel'
    });
</script>

</body>

</html>