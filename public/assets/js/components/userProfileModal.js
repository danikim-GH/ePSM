document.addEventListener('DOMContentLoaded', () => {

    const modalEl = document.getElementById('userModal');
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
