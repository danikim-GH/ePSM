@extends('layouts.apps')

@section('title', ' - Helpdesk')

@push('styles')
<link href="{{ asset("assets/css/helpdesk_custom.css") }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset("assets/css/components/dropdown.css") }}">
@endpush

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary'])

<div class="helpdesk-bg">
  <div class="container">
    <div class="glass-card animate-fadeInUp">
      <div class="text-center mx-auto pb-4" style="max-width: 800px">
        <h4 class="text-uppercase section-subtitle pt-sans-bold">Sistem Aduan Helpdesk</h4>
        <h1 class="display-6 text-capitalize mb-3 fw-bold pt-sans-regular">Hantar Aduan Anda</h1>
        <p class="mb-0 text-muted">
          Sila isikan borang di bawah. Pihak kami akan menghubungi anda dalam masa terdekat.
        </p>
      </div>

      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <form id="helpdeskForm" action="{{ route('helpdesk.store')}}" method="POST">
        @csrf

        <div class="row g-4">

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <div class="dropdown dropdown-container w-100">
                <button class="form-select custom-input text-start dropdown-toggle dropdown-container" type="button" id="kategoriDropdown"
                  data-bs-toggle="dropdown" aria-expanded="false"
                >Pilih Kategori Aduan</button>

                <ul class="dropdown-menu w-100">
                  <li><a href="#" class="dropdown-item aduan-item" data-value="Teknikal">Isu Teknikal</a></li>
                  <li><a href="#" class="dropdown-item aduan-item" data-value="Akaun">Isu Akaun/Log Masuk</a></li>
                  <li><a href="#" class="dropdown-item aduan-item" data-value="Tempahan">Masalah Submit</a></li>
                  <li><a href="#" class="dropdown-item aduan-item" data-value="Lain">Lain-lain</a></li>
                </ul>
              </div>
              <input type="hidden" class="form-control custom-input" name="kategori" id="kategori" required>
              @error('kategori')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <input type="text" class="form-control custom-input @error('subject') is-invalid @enderror" 
                id="subject" 
                name="subject" 
                value="{{ old('subject') }}"
                required />
              <label for="subject">Subjek Aduan</label>
              @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-12">
            <div class="form-floating custom-floating">
              <textarea class="form-control custom-input @error('message') is-invalid @enderror" 
                id="message" 
                name="message" 
                style="height: 180px" 
                required>{{ old('message') }}</textarea>
              <label for="message">Butiran Aduan</label>
              @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="col-12">
            <button type="submit" class="btn btn-gradient w-100 py-3 fw-semibold shadow-sm hover-scale">
              Hantar Aduan
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid footer py-5 text-center">
  <p class="text-white mb-0">© 2025 ePSM Helpdesk. Semua Hak Terpelihara.</p>
</div>

<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top">
  <i class="fa fa-arrow-up"></i>
</a>

@endsection

@push('scripts')
<script>
  document.querySelectorAll('.aduan-item').forEach(item => {
    item.addEventListener('click', function (e) {
      e.preventDefault();

      const value = this.dataset.value;
      const text  = this.textContent;

      document.getElementById('kategori').value = value;
      document.getElementById('kategoriDropdown').textContent = text;
      document.getElementById('kategoriDropdown').classList.remove('is-invalid');
    });
  });

  @if ($errors->has('kategori'))
    document.getElementById('kategoriDropdown').classList.add('is-invalid');
  @endif
</script>
@endpush