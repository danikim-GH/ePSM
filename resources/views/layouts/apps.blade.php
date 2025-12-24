<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ePSM @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ePSM, EPSM, Bahagian Sumber Manusia SUK, SUK Kedah" name="keywords">
    <meta content="ePSM BPSM adalah satu sistem yang ditubuhkan kepada BPSM SUK Negeri Kedah" name="description">
    <link rel="icon" href="{{ asset('assets/img/cropped-kedah-baru.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Righteous&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=groups_3" />
    <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400..900&display=swap" rel="stylesheet">
    

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/lib/animate/animate.css') }}">
    <link href="{{ asset("assets/lib/animate/animate.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/lib/owlcarousel/assets/owl.carousel.min.css") }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset("assets/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @stack('styles')
</head>
<body>

    <!-- User Profile Modal -->

    @auth
        @include('components.user-profile-modal')
    @endauth

    <!-- Navbar -->

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="{{ asset("assets/lib/wow/wow.min.js") }}"></script>
    <script src="{{ asset("assets/lib/owlcarousel/owl.carousel.min.js") }}"></script>

    @stack('scripts')

    <!-- Template Javascript -->
    <script src="{{ asset("assets/js/main.js") }}"></script>

    <!-- Bootstrap JS (Dropdown, Modal, Collapse etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <!-- User Profile Modal JS -->
    <script src="{{ asset('assets/js/components/userProfileModal.js') }}"></script>

</body>
</html>