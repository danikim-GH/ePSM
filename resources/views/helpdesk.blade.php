@extends('layouts.apps')

@section('title', ' - Helpdesk')

@push('styles')
<link href="{{ asset("assets/css/helpdesk_custom.css") }}" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light bg-dark shadow'])

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

      <form id="helpdeskForm" action="{{ route('helpdesk.store')}}" method="POST">
        @csrf

        <div class="row g-4">

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <input type="text" class="form-control custom-input" id="name" name="name" required />
              <label for="name">Nama Penuh</label>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <input type="email" class="form-control custom-input" id="email" name="email" required />
              <label for="email">Alamat Emel</label>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <input type="text" class="form-control custom-input" id="phone" name="phone" />
              <label for="phone">No. Telefon</label>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-floating custom-floating">
              <select class="form-select custom-input" id="kategori" name="kategori" required>
                <option selected disabled>Pilih Kategori Aduan</option>
                <option value="Teknikal">Isu Teknikal</option>
                <option value="Akaun">Isu Akaun / Log Masuk</option>
                <option value="Tempahan">Masalah Tempahan</option>
                <option value="Lain">Lain-lain</option>
              </select>
              <label for="kategori">Kategori Aduan</label>
            </div>
          </div>

          <div class="col-12">
            <div class="form-floating custom-floating">
              <input type="text" class="form-control custom-input" id="subject" name="subject" required />
              <label for="subject">Subjek Aduan</label>
            </div>
          </div>

          <div class="col-12">
            <div class="form-floating custom-floating">
              <textarea class="form-control custom-input" id="message" name="message" style="height: 180px" required></textarea>
              <label for="message">Butiran Aduan</label>
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
