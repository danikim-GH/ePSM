@extends('layouts.apps')

@section('content')

<div class="container">
    <h2>Direktori Pegawai</h2>

    @foreach($direktori as $unit => $staffList)

        <h4 class="mt-4">{{ $unit }}</h4>

        <div class="staff-grid">
            @foreach($staffList as $staff)
                <div class="staff-card">
                    <img src="{{ asset('uploads/direktori/'.$staff->dir_gambar) }}"
                         onerror="this.src='{{ asset('images/default-user.png') }}'">

                    <h5>{{ $staff->dir_nama }}</h5>
                    <p>{{ $staff->dir_jawatan }}</p>
                    <small>{{ $staff->dir_tel }}</small>
                </div>
            @endforeach
        </div>

    @endforeach
</div>
@endsection
