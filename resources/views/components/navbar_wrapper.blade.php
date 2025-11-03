<nav class="navbar navbar-expand-lg {{ $navbarClass }} px-4 px-lg-5 py-3 py-lg-0">
    <a href="{{url('/')}}" class="navbar-brand p-0">
        <h1 class="text-primary">
            <img src="{{asset('assets/img/cropped-kedah-baru.png')}}" alt="Logo negeri kedah" class="me-3" style="height: 40px;">
            ePSM
        </h1>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            @include('partials.navbar')
        </div>
    </div>
</nav>
