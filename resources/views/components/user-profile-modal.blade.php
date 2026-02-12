@auth
@php
    $user = Auth::guard('lampirana')->user();
@endphp

<div class="modal fade" style="background-color: rgba(60, 55, 55, 0.596); backdrop-filter: blur(2.5px);" id="userProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title gabarito-regular">
                    Profil Pengguna
                </h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>

            <form id="editProfileForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <!-- PROFILE PIC -->
                    <div class="text-center mb-4 position-relative">
                        <img id="profilePreview" src="{{ $user->gambar ? asset('storage/'.$user->gambar) : asset('assets/img/cropped-kedah-baru.png') }}"
                            class="rounded-circle shadow"
                            width="110" height="110">

                        <!-- Edit icon -->
                        <button type="button"
                                class="btn btn-sm btn-dark position-absolute bottom-0 end-50 translate-middle-x rounded-circle"
                                onclick="document.getElementById('profilePic').click()">
                            <i class="bi bi-pencil"></i>
                        </button>

                        <input type="file" id="profilePic" name="profile_pic" class="d-none" accept="image/*">
                    </div>

                    <!-- FIELD TEMPLATE -->
                    @php
                        $fields = [
                            'Nama' => 'Nama',
                            'NoKP' => 'NoKP',
                            'emel' => 'emel',
                            'hp' => 'No Telefon'
                        ];
                    @endphp

                    @foreach($fields as $key => $label)
                    @php $readonly = $key === 'NoKP' @endphp
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <small class="text-muted">{{ $label }}</small>

                            <!-- text -->
                            <div class="view-mode" id="view-{{ $key }}">
                                {{ $user->$key ?? '-' }}
                            </div>

                            @if (!$readonly)
                                
                                <!-- input -->
                                <input type="text"
                                class="form-control form-control-sm edit-mode d-none"
                                name="{{ $key }}"
                                value="{{ $user->$key }}">
                            @endif
                        </div>

                        @if (!$readonly)
                        <!-- edit icon -->
                        <button type="button"
                                class="btn btn-link text-secondary"
                                onclick="enableEdit('{{ $key }}')">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        @endif
                    </div>
                    @endforeach

                </div>

                <!-- FOOTER (hidden by default) -->
                <div class="modal-footer d-none" id="modalFooter">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
