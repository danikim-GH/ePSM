<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ePSM - Daftar Kehadiran Kursus</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="ePSM, EPSM, Bahagian Sumber Manusia SUK, SUK Kedah" name="keywords">
        <meta content="ePSM BPSM adalah satu sistem yang ditubuhkan kepada BPSM SUK Negeri Kedah" name="description">
        <link rel="icon" href="acuas-1.0.0/img/cropped-kedah-baru.png">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="acuas-1.0.0/lib/animate/animate.min.css" rel="stylesheet">
        <link href="acuas-1.0.0/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="acuas-1.0.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="acuas-1.0.0/css/stylesUpdate.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    </head>

    <body>
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        @include('components.navbar_wrapper',['navbarClass'=>'navbar-light bg-dark shadow'])

        <style>
            .container{
                padding-top: 5rem
            }
            /* === Glass Effect Container === */
            .glass-container {
                background: rgba(99, 145, 164, 0.308);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(15px);
                border-radius: 20px;
                box-shadow: 0 8px 32px 0 rgba(3, 205, 255, 0.434);
                border: 1px solid rgba(255, 255, 255, 0.18);
                padding: 3rem;
                transition: transform 0.5s ease;
            }
            .glass-container:hover {
                transform: scale(1.01);
            }

            /* Background behind form */
            .kursus-bg {
                background: #ffffff;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 60px 20px;
            }

            label {
                color: #363636 !important;
            }
        </style>

        <div class="kursus-bg">
            <div class="container">
                <div class="glass-container">
                    <div class="text-center mx-auto pb-4" style="max-width: 800px">
                        <h1 class="display-6 text-capitalize mb-3" style="color: #171717">Daftar Kehadiran Kursus</h1>
                        <p class="mb-0 ">
                            Sila lengkapkan maklumat berikut untuk merekodkan kehadiran anda bagi kursus yang dihadiri.
                        </p>
                    </div>
                    <form id="kursusFormUpper" action="{{ route('kursus.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="form-select border-0 bg-light bg-opacity-75" id="program" name="program" required>
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
                                    <select class="form-select border-0 bg-light bg-opacity-75" id="aktiviti" name="aktiviti" required>
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
                                    <input type="text" class="form-control border-0" id="tajuk" name="tajuk" placeholder="Tajuk Kursus" required>
                                    <label for="tajuk">Tajuk Kursus</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control border-0" id="tarikh_mula" name="tarikh_mula" required>
                                    <label for="tarikh_mula">Tarikh Kursus Mula</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control border-0" id="tarikh_tamat" name="tarikh_tamat" required>
                                    <label for="tarikh_tamat">Tarikh Kursus Tamat</label>
                                </div>
                            </div>
            
                            <div class="col-12">
                                <div class="row g-3 align-items-center" id="masaWrapper">
                                    <div class="col-lg-6" id="masaMulaWrapper">
                                        <div class="form-floating">
                                            <input type="time" class="form-control border-0" id="masa_mula" name="masa_mula" required>
                                            <label for="masa_mula">Masa Mula</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="masaAkhirWrapper">
                                        <div class="form-floating">
                                            <input type="time" class="form-control border-0" id="masa_akhir" name="masa_akhir" required>
                                            <label for="masa_akhir">Masa Akhir</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

            
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="pembentangan" name="pembentangan" placeholder="Pembentangan">
                                    <label for="pembentangan">Pembentangan</label>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="tempat" name="tempat" placeholder="Tempat Kursus" required>
                                    <label for="tempat">Tempat</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="sumber" name="sumber" placeholder="Sumber" >
                                    <label for="sumber">Sumber</label>
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="penyelia" name="penyelia" placeholder="Penyelia">
                                    <label for="penyelia">Penyelia</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="anjuran" name="anjuran" placeholder="Anjuran" required>
                                    <label for="anjuran">Anjuran</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <select class="form-select border-0" id="lokasi" name="lokasi" required>
                                    <option selected value="dalam">Dalam Negara</option>
                                    <option value="luar">Luar Negara</option>
                                    </select>
                                    <label for="lokasi">Dalam Negara / Luar Negara</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="negeri" name="negeri" placeholder="Nama Negeri / Negara">
                                    <label for="negeri">Nama Negeri / Negara</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control border-0" id="hari" name="hari" placeholder="Bilangan Hari" min="0">
                                    <label for="hari">Bilangan Hari</label>
                                </div>
                            </div>
            
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control border-0" id="jam" name="jam" placeholder="Bilangan Jam" min="0">
                                    <label for="jam">Jumlah Jam</label>
                                </div>
                            </div>
            
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-0" id="rujukan" name="rujukan" placeholder="No Rujukan">
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

        <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="acuas-1.0.0/lib/wow/wow.min.js"></script>
        <script src="acuas-1.0.0/lib/easing/easing.min.js"></script>
        <script src="acuas-1.0.0/js/main.js"></script>
        <script src="acuas-1.0.0/js/daftar_kursus.js"></script>

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

    </body>
</html>
