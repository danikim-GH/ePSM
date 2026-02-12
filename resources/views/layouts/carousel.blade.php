{{-- Add this wherever you want the carousel in your existing index.blade.php --}}
@if(isset($carouselItems) && $carouselItems->count() > 0)
<!-- Carousel Section -->
<div class="carousel-header">
    <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @foreach($carouselItems as $key => $item)
            <li data-bs-target="#carouselId" 
                data-bs-slide-to="{{ $key }}" 
                class="{{ $key == 0 ? 'active' : '' }}">
            </li>
            @endforeach
        </ol>
        

        
        <!-- Slides -->
        <div class="carousel-inner" role="listbox">
            @foreach($carouselItems as $key => $item)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

                <div class="carousel-overlay"
                    style="background: rgba(0,0,0,{{ $item->overlay_opacity }});">
                </div>

                <img src="{{ asset($item->image_path) }}" class="img-fluid w-100"
                    style="max-height: 580px; object-fit: cover;" onerror="this.src='{{ asset('assets/img/kedah_scenery.jpg') }}'">

                @if($item->show_text)
                <div class="carousel-caption-{{ $key % 2 == 0 ? '1' : '2' }}">
                    <div class="carousel-caption-{{ $key % 2 == 0 ? '1' : '2' }}-content">

                        <h4 class="text-white text-uppercase gabarito-bold mb-4 wow fadeInLeft" data-wow-delay="0.5s" style="letter-spacing: 2px; font-size: 40px;">
                            {{ $item->title }}
                        </h4>

                        <p class="mb-5 fs-5 text-white fadeInLeft animated">
                            {{ $item->description }}
                        </p>

                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
            <span class="carousel-control-prev-icon btn btn-primary fadeInLeft animated" aria-hidden="true" data-animation="fadeInLeft"data-delay="1.1s" style="animation-delay: 1.3s;"> <i class="fa fa-angle-left fa-3x"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
            <span class="carousel-control-next-icon btn btn-primary fadeInRight animated" data-animation="fadeInRight" aria-hidden="true" data-delay="1.1s" style="animation-delay: 1.3s;"> <i class="fa fa-angle-right fa-3x"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
@endif