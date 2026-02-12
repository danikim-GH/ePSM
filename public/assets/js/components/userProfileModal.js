document.addEventListener('DOMContentLoaded', () => {

    const modalEl = document.getElementById('userProfileModal');
    if (!modalEl) return; 

    const modal = new bootstrap.Modal(modalEl);
    let edited = false;

    // --- SIMPAN DATA ASAL ---
    const inputs = modalEl.querySelectorAll('input.form-control');
    const initialValues = {};
    inputs.forEach(input => initialValues[input.name] = input.value);

    const profilePreview = modalEl.querySelector('#profilePreview');
    if (profilePreview) profilePreview.dataset.original = profilePreview.src;

    function showFooter() {
        if (!edited) {
            edited = true;
            const footer = document.getElementById('modalFooter');
            if (footer) footer.classList.remove('d-none');
        }
    }

    window.enableEdit = function (field) {
        const viewEl = document.getElementById('view-' + field);
        const inputEl = document.querySelector(`input[name="${field}"]`);

        if (!viewEl || !inputEl) return;

        viewEl.classList.add('d-none');
        inputEl.classList.remove('d-none');
        showFooter();
    };

    const profilePicInput = document.getElementById('profilePic');
    if (profilePicInput && profilePreview) {
        profilePicInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                profilePreview.src = URL.createObjectURL(file);
                showFooter();
            }
        });
    }

    window.closeModal = function() {
        if(!modalEl) return;

        // --- Reset ke nilai asal ---
        inputs.forEach(input => {
            if(initialValues[input.name] !== undefined)
                input.value = initialValues[input.name];
        });

        // Reset view / edit mode
        const viewEls = modalEl.querySelectorAll('.view-mode');
        viewEls.forEach(el => el.classList.remove('d-none'));
        const editInputs = modalEl.querySelectorAll('.edit-mode');
        editInputs.forEach(el => el.classList.add('d-none'));

        // Reset profile pic
        if (profilePreview) profilePreview.src = profilePreview.dataset.original;

        // Hide footer
        const footer = modalEl.querySelector('#modalFooter');
        if (footer) footer.classList.add('d-none');

        edited = false;

        // Tutup modal
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
    };
});

document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('editProfileForm');
    if (!form) return;

    form.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/profile/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return;

            // Update profile pic live
            if (data.gambar) {
                document.getElementById('profilePreview').src =
                    '/storage/' + data.gambar + '?t=' + Date.now();
            }

            // Sync text view (kalau nak tanpa reload)
            document.getElementById('view-Nama').innerText = data.user.Nama ?? '-';
            document.getElementById('view-emel').innerText = data.user.emel ?? '-';
            document.getElementById('view-hp').innerText   = data.user.hp ?? '-';

            if(data.success){
                window.location.reload();
            }
        })
        .catch(console.error);
    });
});

window.openProfileModalManual = function() {
    const modalEl = document.getElementById('userProfileModal');
    if (modalEl) {
        // Guna getInstance supaya tak buat backdrop baru bertindih-tindih
        let modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (!modalInstance) {
            modalInstance = new bootstrap.Modal(modalEl);
        }
        modalInstance.show();
    }
};