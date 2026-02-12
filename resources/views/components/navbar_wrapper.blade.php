<nav class="navbar navbar-expand-lg {{ $navbarClass }}  px-4 px-lg-5 py-3 py-lg-0">
    @include('layouts.logo-on-navbar')
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            @include('partials.navbar')
        </div>
    </div>
</nav>
