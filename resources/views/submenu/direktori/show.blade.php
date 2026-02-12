@extends('layouts.apps')


@section('title', '- Direktori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/direktori.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endpush

@section('content')

@include('components.spinnerLoading')
@include('components.navbar_wrapper',['navbarClass'=>'navbar-light-secondary bg-secondary'])

<div class="container">
    <h2 class="gabarito-regular">{{ $unitName }}</h2>

    <div class="staff-grid">
        @foreach($direktori as $staff)
            <div class="staff-card">
                <img src="{{ asset('uploads/direktori/'.$staff->dir_gambar) }}"
                     onerror="this.src='{{ asset('assets/img/cropped-kedah-baru.png') }}'">
                <h5 class="pt-sans-regular">{{ $staff->dir_nama }}</h5>
                <p>{{ $staff->dir_jawatan }}</p>
                <small>{{ $staff->dir_tel }}</small>
            </div>
        @endforeach
    </div>
</div>
@endsection
