@extends('layouts.apps')

@section('title', ' - Daftar Kursus')

@push('styles')
    <link href="{{ asset("assets/css/daftarKursusCustom.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/css/components/dropdown.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/components/toast-notifications.css") }}">
    {{-- CSS Select2 & Theme Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <style>
        /* Custom CSS untuk bagi Select2 nampak macam input transparent anda */
        .select2-container--bootstrap-5 .select2-selection {
            background-color: rgba(248, 249, 250, 0.75) !important; /* bg-light opacity-75 */
            border: 0 !important;
            min-height: 58px; /* Ikut tinggi form-floating */
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
        }
        
        /* Bagi label nampak elok */
        .form-floating .select2-container {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
    </style>
@endpush

@section('content')


@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary shadow'])


<div class="kursus-bg">
    <div class="container">
        <div class="glass-container">
            <div class="text-center mx-auto pb-4" style="max-width: 800px">
                <h1 class="display-6 text-capitalize mb-3 pt-sans-bold" style="color: #171717">Daftar Kehadiran Kursus</h1>
                <p class="mb-0 ">
                    Sila lengkapkan maklumat berikut untuk merekodkan kehadiran anda bagi kursus yang dihadiri.
                </p>
            </div>
            <form id="kursusFormUpper" action="{{ route('kursus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <select class="form-select border-0 bg-light bg-opacity-75 custom-input position-relative dropdown-icon" id="program" name="program" required>
                                <option selected disabled>Pilih Program Latihan</option>
                                <option value="1" data-has-end="4">Program</option>
                                <option value="2" data-has-end="3">Latihan</option>
                                <option value="3" data-has-end="1">Bengkel</option>
                                <option value="4" data-has-end="1">Seminar</option>
                                <option value="5" data-has-end="0">Pembelajaran Kendiri</option>
                                <option value="6" data-has-end="2">Sesi Pembelajaran</option>
                            </select>
                            <label for="program">Program Latihan</label>
                            <i class="fa-solid fa-caret-down dropdown-arrow"></i>
                        </div> <!--form floating-->
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating">
                            <select class="form-select border-0 bg-light bg-opacity-75 custom-input position-relative dropdown-icon" id="aktiviti" name="aktiviti" required>
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
                            </select>
                            <label for="aktiviti">Aktiviti</label>
                            <i class="fa-solid fa-caret-down dropdown-arrow"></i>
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

                    <div class="col-12" id="anjuranWrapper"> 
                        <div class="form-floating">    
                            <select class="form-select border-0 bg-light bg-opacity-75 custom-input position-relative dropdown-icon" 
                                    id="anjuran" 
                                    name="anjuran"
                                    data-url="{{ route('ajax.anjuran') }}">
                                @if(old('anjuran'))
                                    <option value="{{ old('anjuran') }}" selected>{{ old('anjuran') }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
    
                    <div class="col-lg-6">
                        <div class="form-floating position-relative">
                            <select class="form-select border-0 custom-input dropdown-icon" id="lokasi" name="lokasi" required>
                                <option selected value="dalam">Dalam Negara</option>
                                <option value="luar">Luar Negara</option>
                            </select>
                            <label for="lokasi">Dalam Negara / Luar Negara</label>
                            <i class="fa-solid fa-caret-down dropdown-arrow"></i>  
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

                    <!--********Letak input sijil sini*********-->
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="file"
                                class="form-control border-0 custom-input"
                                id="sijil"
                                name="sijil"
                                accept="application/pdf">
                            <label for="sijil">Sijil Kursus (PDF sahaja)</label>
                        </div>
                        <small class="text-muted">
                            * Optional. Muat naik sijil dalam format PDF sahaja.
                        </small>
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

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset("assets/js/components/toast-notifications.js") }}"></script>
    <script src="{{ asset("assets/js/daftar_kursus.js") }}"></script>

    <script>
        // Show toast notifications based on session messages
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Toast.success('{{ session('success') }}', 4000);
            @endif

            @if (session('error'))
                Toast.error('{{ session('error') }}', 5000);
            @endif

            @if (session('warning'))
                Toast.warning('{{ session('warning') }}', 4000);
            @endif

            @if (session('info'))
                Toast.info('{{ session('info') }}', 4000);
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Toast.error('{{ $error }}', 5000);
                @endforeach
            @endif
        });
    </script>
@endpush