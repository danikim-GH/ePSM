@extends('layouts.apps') {{-- Ini akan panggil header/footer kau yang sedia ada --}}

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary shadow'])

<div class="container mt-5" style="margin-top: 11rem !important; margin-bottom: 5rem !important;">
    @if($maklumat)
        <div class="card">
            <div class="card-body">
                {{-- Guna {!! !!} supaya Laravel render tag HTML, bukan paparkan sebagai teks biasa --}}
                {!! $maklumat->info_html !!}
            </div>
        </div>
    @else
        <p>Maaf, maklumat tidak ditemui.</p>
    @endif
</div>
@endsection