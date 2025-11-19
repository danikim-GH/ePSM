@extends('layouts.apps')

@section('title', ' - Helpdesk')

@push('styles')
  <link href="assets/css/helpdesk_custom.css" rel="stylesheet">
@endpush

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light bg-dark shadow'])

<div class="helpdesk-bg">
  <div class="container">
    <div class="glass-container">
      <div class="text-center mx-auto pb-4" style="max-width: 800px">
        <h4 class="text-uppercase text-primary">Sistem Aduan Helpdesk</h4>
        <h1 class="display-6 text-capitalize mb-3">Hantar Aduan Anda</h1>
        <p class="mb-0">
        Sila isikan borang di bawah untuk menghantar aduan atau pertanyaan anda.
        Pihak kami akan menghubungi anda dalam masa terdekat.
        </p>
      </div>
      <!--FORM START-->
      <form id="helpdeskForm" action="{{ route('helpdesk.store')}}" method="POST">
      @csrf
        <div class="row g-4">
          <div class="col-lg-6">
            <div class="form-floating">
              <input
                type="text"
                class="form-control border-0"
                id="name"
                name="name"
                placeholder="Nama Penuh"
                required
              />
              <label for="name">Nama Penuh</label>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-floating">
              <input
                type="email"
                class="form-control border-0"
                id="email"
                name="email"
                placeholder="Emel"
                required
              />
              <label for="email">Alamat Emel</label>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-floating">
              <input
                type="text"
                class="form-control border-0"
                id="phone"
                name="phone"
                placeholder="No Telefon"
              />
              <label for="phone">No. Telefon</label>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-floating">
              <select
                class="form-select border-0"
                id="kategori"
                name="kategori"
                required
              >
                <option value="" selected disabled>Pilih Kategori Aduan</option>
                <option value="Teknikal">Isu Teknikal</option>
                <option value="Akaun">Isu Akaun / Log Masuk</option>
                <option value="Tempahan">Masalah Tempahan</option>
                <option value="Lain">Lain-lain</option>
              </select>
              <label for="kategori">Kategori Aduan</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating">
              <input
                type="text"
                class="form-control border-0"
                id="subject"
                name="subject"
                placeholder="Subjek Aduan"
                required
              />
              <label for="subject">Subjek Aduan</label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating">
              <textarea
                class="form-control border-0"
                placeholder="Taip mesej di sini"
                id="message"
                name="message"
                style="height: 175px"
                required
              ></textarea>
              <label for="message">Butiran Aduan</label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary w-100 py-3">
              Hantar Aduan
            </button>
          </div>
        </div>
      </form>
    </div><!--glass container-->
  </div>
</div>

<!-- 
<div class="container-fluid contact bg-light py-5 mt-5">
  <div class="container py-5">
    <div class="text-center mx-auto pb-5" style="max-width: 800px">
      <h4 class="text-uppercase text-primary">Sistem Aduan Helpdesk</h4>
      <h1 class="display-5 text-capitalize mb-3">Hantar Aduan Anda</h1>
      <p class="mb-0">
      Sila isikan borang di bawah untuk menghantar aduan atau pertanyaan anda.
      Pihak kami akan menghubungi anda dalam masa terdekat.
      </p>
    </div>

  </div>
</div>
Helpdesk Form End -->

<!-- Footer -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
<div class="container text-center">
<p class="text-white mb-0">© 2025 ePSM Helpdesk. Semua Hak Terpelihara.</p>
</div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top">
  <i class="fa fa-arrow-up"></i>
</a>
@endsection