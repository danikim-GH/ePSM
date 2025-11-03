<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>ePSM - Bahagian Sumber Manusia</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="ePSM, EPSM, Bahagian Sumber Manusia SUK, SUK Kedah" name="keywords">
        <meta content="ePSM BPSM adalah satu sistem yang ditubuhkan kepada BPSM SUK Negeri Kedah" name="description">
        <link rel="icon" href="assets/img/cropped-kedah-baru.png">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wdth,wght@0,75..100,300..800;1,75..100,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
        <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="assets/css/style.css" rel="stylesheet">
    </head>

    <body>
        <!-- Spinner End -->

        @include('components.navbar_wrapper',['navbarClass'=>'navbar-light bg-dark shadow'])

        <div class="container responsive-padding">
            <h2 class="mb-4">Senarai Kehadiran Kursus</h2>

            <!--search & sort-->
            <form action="{{route('senarai.index')}}" method="GET">
                <div class="d-flex py-0" >
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari kursus..." class="form-control me-2" >
                    <button class="btn btn-primary">Cari</button>
                </div>
                <div class="d-flex py-3">
                    <select name="sort_by" class="form-select me-2" onchange="this.form.submit()">
                        <option value="tajuk" {{$sortBy=='tajuk'?'selected':''}}>Tajuk</option>
                        <option value="tarikh" {{$sortBy=='tarikh'?'selected':''}}>Tarikh</option>
                    </select>
                    <select name="order" class="form-select" onchange="this.form.submit()">
                        <option value="asc" {{$order == 'asc'?'selected':''}}>Menaik</option>
                        <option value="desc" {{$order == 'desc'?'selected':''}}>Menurun</option>
                    </select>
                </div>
            </form>

            <!--Table list untuk senarai kursus-->
            <div class="table-responsive rounded-3">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Bil</th>
                            <th>Kategori</th>
                            <th>Tajuk</th>
                            <th>Tarikh</th>
                            <th>Tempat</th>
                            <th>Bil Jam</th>
                            <th>Bil Hari</th>
                            <th>Maklumat Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kursus as $index => $k)
                            <tr>
                                <td>{{$kursus->firstItem()+$index}}</td>
                                <td>{{ $k -> kursus_idprogram }}</td>
                                <td>{{ $k -> kursus_tajuk }}</td>
                                <td>{{ $k -> kursus_thmula }}</td>
                                <td>{{ $k -> kursus_tempat}}</td>
                                <td class="text-center">{{ $k -> kursus_biljam }}</td>
                                <td class="text-center">{{ $k -> kursus_bilhari }}</td>
                                <td> {{ $k -> kursus_sijil}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!--Pagination 1,2,3,4,5,6-->
            <div class="d-flex justify-content-center py-5">
                {{ $kursus->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div> 

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
        <script src="assets/lib/wow/wow.min.js"></script>
        <script src="assets/lib/easing/easing.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
    
</html>

