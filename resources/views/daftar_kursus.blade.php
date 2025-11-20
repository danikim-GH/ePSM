@extends('layouts.apps')

@section('title', ' - Daftar Kursus')

@push('styles')
    <link href="{{ asset("assets/css/daftarKursusCustom.css") }}" rel="stylesheet">
@endpush

@section('content')


@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light bg-dark shadow'])


<div class="kursus-bg">
    <div class="container">
        <div class="glass-container">
            <div class="text-center mx-auto pb-4" style="max-width: 800px">
                <h1 class="display-6 text-capitalize mb-3 pt-sans-bold" style="color: #171717">Daftar Kehadiran Kursus</h1>
                <p class="mb-0 ">
                    Sila lengkapkan maklumat berikut untuk merekodkan kehadiran anda bagi kursus yang dihadiri.
                </p>
            </div>
            <form id="kursusFormUpper" action="{{ route('kursus.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <select class="form-select border-0 bg-light bg-opacity-75 custom-input" id="program" name="program" required>
                                <option selected disabled>Pilih Program Latihan</option>
                                <option value="1" data-has-end="4">Program</option>
                                <option value="2" data-has-end="3">Latihan</option>
                                <option value="3" data-has-end="1">Bengkel</option>
                                <option value="4" data-has-end="1">Seminar</option>
                                <option value="5" data-has-end="0">Pembelajaran Kendiri</option>
                                <option value="6" data-has-end="2">Sesi Pembelajaran</option>
                            </select>
                            <label for="program">Program Latihan</label>
                        </div> <!--form floating-->
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <select class="form-select border-0 bg-light bg-opacity-75 custom-input" id="aktiviti" name="aktiviti" required>
                                <option selected disabled>Sila pilih aktiviti</option>
                                <option value="0">Kursus</option>
                                <option value="1">Seminar</option>
                                <option value="2">Konvensyen</option>
                                <option value="3">Bengkel</option>
                                <option value="4">Forum</option>
                                <option value="5">Simposium</option>
                                <option value="6">Kolokium</option>
                                <option value="7">Lawatan Rasmi/Korporat/Sambil Belajar</option>
                                <option value="8">Klinik Kaunseling</option>
                                <option value="9">Pembelajaran Online</option>
                                <option value="10">Jika tiada, klik di sini untuk daftar</option>
                                <option value="11">Pentadbiran</option>
                                <option value="12">Pentadbiran</option>
                                <option value="13">Pentadbiran</option>
                                <option value="14">Pentadbiran</option>
                                <option value="15">Pentadbiran</option>
                                <option value="16">Pentadbiran</option>
                                <option value="17">Pentadbiran</option>
                                <option value="18">Pentadbiran</option>
                                <option value="19">Pentadbiran</option>
                                <option value="20">Pentadbiran</option>
                                <option value="21">Pentadbiran</option>
                                <option value="22">Pentadbiran</option>
                                <option value="23">Pentadbiran</option>
                                <option value="24">Pentadbiran</option>
                                <option value="25">Pentadbiran</option>
                                <option value="26">Pentadbiran</option>
                                <option value="27">Pentadbiran</option>
                                <option value="28">Pentadbiran</option>
                                <option value="29">Pentadbiran</option>
                            </select>
                            <label for="aktiviti">Aktiviti</label>
                        </div>
                    </div>
    
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="tajuk" name="tajuk" placeholder="Tajuk Kursus" required>
                            <label for="tajuk">Tajuk Kursus</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <input type="date" class="form-control border-0 custom-input" id="tarikh_mula" name="tarikh_mula" required>
                            <label for="tarikh_mula">Tarikh Kursus Mula</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <input type="date" class="form-control border-0 custom-input" id="tarikh_tamat" name="tarikh_tamat" required>
                            <label for="tarikh_tamat">Tarikh Kursus Tamat</label>
                        </div>
                    </div>
    
                    <div class="col-12">
                        <div class="row g-3 align-items-center" id="masaWrapper">
                            <div class="col-lg-6" id="masaMulaWrapper">
                                <div class="form-floating">
                                    <input type="time" class="form-control border-0 custom-input" id="masa_mula" name="masa_mula" required>
                                    <label for="masa_mula">Masa Mula</label>
                                </div>
                            </div>
                            <div class="col-lg-6" id="masaAkhirWrapper">
                                <div class="form-floating">
                                    <input type="time" class="form-control border-0 custom-input" id="masa_akhir" name="masa_akhir" required>
                                    <label for="masa_akhir">Masa Akhir</label>
                                </div>
                            </div>
                        </div>
                    </div>

    
                    
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="pembentangan" name="pembentangan" placeholder="Pembentangan">
                            <label for="pembentangan">Pembentangan</label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="tempat" name="tempat" placeholder="Tempat Kursus" required>
                            <label for="tempat">Tempat</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="sumber" name="sumber" placeholder="Sumber" >
                            <label for="sumber">Sumber</label>
                        </div>
                    </div>
                
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="penyelia" name="penyelia" placeholder="Penyelia">
                            <label for="penyelia">Penyelia</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="anjuran" name="anjuran" placeholder="Anjuran" required>
                            <label for="anjuran">Anjuran</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <select class="form-select border-0 custom-input" id="lokasi" name="lokasi" required>
                                <option selected value="dalam">Dalam Negara</option>
                                <option value="luar">Luar Negara</option>
                            </select>
                            <label for="lokasi">Dalam Negara / Luar Negara</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="negeri" name="negeri" placeholder="Nama Negeri / Negara">
                            <label for="negeri">Nama Negeri / Negara</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <input type="number" class="form-control border-0 custom-input" id="hari" name="hari" placeholder="Bilangan Hari" min="0">
                            <label for="hari">Bilangan Hari</label>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <input type="number" class="form-control border-0 custom-input" id="jam" name="jam" placeholder="Bilangan Jam" min="0">
                            <label for="jam">Jumlah Jam</label>
                        </div>
                    </div>
    
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 custom-input" id="rujukan" name="rujukan" placeholder="No Rujukan">
                            <label for="rujukan">No Rujukan</label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-sm-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-3 px-sm-5 py-3">Hantar</button>
                        <button type="reset" class="btn btn-outline-secondary px-3 px-sm-5 py-3">Batal</button>
                    </div>
                </div>
            </form>
        </div><!--div glass container-->
    </div>
</div>



<!-- Form Daftar Kursus End -->

<!-- Footer -->
<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container text-center">
        <p class="text-white mb-0">© 2025 ePSM BPSM. Semua Hak Terpelihara.</p>
    </div>
</div>

<!-- Back to Top -->
<a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top">
    <i class="fa fa-arrow-up"></i>
</a>

@if (session('success'))
<script>
Swal.fire({
    title: 'Berjaya!',
    text: '{{ session('success') }}',
    icon: 'success',
    background: '#f0fff4',
    color: '#166534',
    confirmButtonText: 'OK',
    confirmButtonColor: '#16a34a',
    showConfirmButton: true,
    timer: 3000,
    timerProgressBar: true,
    showClass: {
        popup: 'swal2-noanimation', // disable popup animation
        backdrop: 'swal2-noanimation'
    },
    hideClass: {
        popup: '' // biar kosong untuk elak goyang
    },
    didOpen: (popup) => {
        // biar icon tick default SweetAlert animate sendiri
        const icon = popup.querySelector('.swal2-success');
        if (icon) icon.style.animation = 'swal2-animate-success-icon 0.8s ease-in-out';
    }
});
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    title: 'Gagal!',
    text: '{{ session('error') }}',
    icon: 'error',
    background: '#fef2f2',
    color: '#7f1d1d',
    confirmButtonText: 'Cuba Lagi',
    confirmButtonColor: '#dc2626',
    showConfirmButton: true,
    showClass: {
        popup: 'swal2-noanimation', // disable popup slide
        backdrop: 'swal2-noanimation'
    },
    hideClass: {
        popup: ''
    },
    didOpen: (popup) => {
        const icon = popup.querySelector('.swal2-error');
        if (icon) icon.style.animation = 'swal2-animate-error-icon 0.7s ease-in-out';
    }
});
</script>
@endif

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset("assets/js/daftar_kursus.js") }}"></script>
@endpush