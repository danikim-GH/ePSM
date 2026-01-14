{{-- resources/views/admin/carousel.blade.php --}}
@extends('layouts.apps')

@section('title', '- Admin Carousel Settings')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/adminSetting.css') }}">
@endpush

@section('content')
@include('components.spinnerLoading')

<div class="admin-panel">
    @include('partials.sidebarAdmin')
    
    <div class="admin-content">

        <div class="content-header wow fadeInUp" data-wow-duration="1.3s">
            <div class="breadcrumb">
                <a href="{{ route('admin.setting') }}" class="breadcrumb-link">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Carousel</span>
            </div>
            <h1 class="gabarito-regular">Home Page Carousel Settings</h1>
            <p>Upload and manage carousel images for the home page (slider)</p>
        </div>

        <div class="admin-container">
            <!-- Current Carousel Images -->
            <div class="card">
                <div class="card-header">
                    <h3 class="gabarito-regular">Current Carousel Images</h3>
                    <button class="btn btn-primary" id="addNewImageBtn">
                        <i class="fas fa-plus"></i> Add New Image
                    </button>
                </div>
                
                <div class="card-body">
                    <div id="carouselImagesGrid" class="images-grid">
                        <!-- Carousel images will be loaded here via AJAX -->
                        @foreach($carouselItems as $item)
                        <div class="image-card" data-id="{{ $item->id }}">
                            <div class="image-preview">
                                <img src="{{ asset($item->image_path) }}" alt="Carousel Image {{ $loop->iteration }}">
                                <div class="image-overlay">
                                    <button class="btn-edit" onclick="editCarouselItem({{ $item->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-delete" onclick="openDeleteModal({{ $item->id }}, '{{ addslashes($item->title) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="image-info">
                                <h4 class="pt-sans-bold">{{ $item->title }}</h4>
                                <p>{{ $item->description }}</p>
                                <small>Order: {{ $item->order }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Add/Edit Form (Initially Hidden) -->
            <div class="card mt-4" id="carouselFormContainer" style="display: none;">
                <div class="card-header">
                    <h3 id="formTitle" class="gabarito-regular">Add New Carousel Image</h3>
                </div>
                <div class="card-body">
                    <form id="carouselForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="carouselId" name="id">
                        
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Enter title">
                            <span class="error" id="titleError"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            <span class="error" id="descriptionError"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="button_text">Button Text (Optional)</label>
                            <input type="text" id="button_text" name="button_text" class="form-control" placeholder="e.g., Learn More">
                        </div>
                        
                        <div class="form-group">
                            <label for="button_link">Button Link (Optional)</label>
                            <input type="text" id="button_link" name="button_link" class="form-control" placeholder="e.g., /products">
                        </div>
                        
                        <div class="form-group">
                            <label for="order">Display Order</label>
                            <input type="number" id="order" name="order" class="form-control" min="1" value="1">
                        </div>
                        
                        <div class="form-group">
                            <label for="image">Carousel Image</label>
                            <div class="file-upload">
                                <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
                                <small class="form-text text-muted">Recommended size: 1920x1080px, Max size: 2MB</small>
                            </div>
                            <div class="image-preview mt-2" id="imagePreview" style="display: none;">
                                <img id="previewImage" src="" alt="Preview">
                            </div>
                            <span class="error" id="imageError"></span>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span id="submitText">Add Image</span>
                                <span id="loadingSpinner" style="display: none;">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('admin.components.mobile_bottom_nav')
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal" id="deleteModal" style="background-color: rgba(60, 55, 55, 0.596); backdrop-filter: blur(2.5px);">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fa fa-warning text-danger" style="margin-right: 1px;" aria-hidden="true"></i>
            <h3 class="gabarito-bold text-danger " style="margin-right: 1px;">Delete Confirmation</h3>
            <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
        </div>
        <div class="modal-body" >
            <h5 class="gabarito-regular text-muted">Title: <strong class="text-dark mt-2 text-uppercase " id="deleteItemTitle" > </strong></h5>
            <p>Are you sure you want to delete this carousel image? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/admin.js') }}"></script>
    <script src="{{ asset('assets/js/adminSetting.js') }}"></script>
    <script>
        console.log('CSRF Token from meta:', document.querySelector('meta[name="csrf-token"]')?.content);
        console.log('CSRF Token from input:', document.querySelector('input[name="_token"]')?.value);
        console.log('Current URL:', window.location.href);
    </script>
@endpush