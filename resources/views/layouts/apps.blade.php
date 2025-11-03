<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ePSM</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ePSM, EPSM, Bahagian Sumber Manusia SUK, SUK Kedah" name="keywords">
    <meta content="ePSM BPSM adalah satu sistem yang ditubuhkan kepada BPSM SUK Negeri Kedah" name="description">
    <link rel="icon" href="{{ asset('acuas-1.0.0/img/cropped-kedah-baru.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('acuas-1.0.0/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('acuas-1.0.0/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Stylesheet -->
    <link href="{{ asset('acuas-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <link href="{{ asset('acuas-1.0.0/css/stylesUpdate.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    @stack('scripts')

</body>
</html>
