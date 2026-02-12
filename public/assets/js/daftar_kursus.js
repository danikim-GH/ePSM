$(document).ready(function () {
    // Existing form handlers...
    const tarikhTamatWrapper = $("#tarikh_tamat").closest(".col-lg-6");
    const masaMulaWrapper = $("#masa_mula").closest(".col-lg-6");
    const masaAkhirWrapper = $("#masa_akhir").closest(".col-lg-6");
    const pembentanganWrapper = $("#pembentangan").closest(".col-12");
    const penyeliaWrapper = $("#penyelia").closest(".col-12");
    const sumberWrapper = $("#sumber").closest(".col-12");
    const anjuranWrapper = $("#anjuran").closest(".col-12");
    const lokasiWrapper = $("#lokasi").closest(".col-lg-6");
    const negeriWrapper = $("#negeri").closest(".col-lg-6");

    const tarikhMula = $('#tarikh_mula');
    const tarikhTamat = $('#tarikh_tamat');
    const bilHari = $('#hari');
    const bilJam = $('#jam');
    const masaMula = $("#masa_mula");
    const masaAkhir = $("#masa_akhir");
    const pembentangan = $("#pembentangan");
    const penyelia = $("#penyelia");
    const sumber = $("#sumber");
    const anjuran = $("#anjuran");
    const lokasi = $("#lokasi");
    const negeri = $("#negeri");

    // ============================================
    // TOAST NOTIFICATIONS FOR FILE UPLOAD
    // ============================================
    $('#sijil').on('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Check file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                Toast.error('Saiz fail terlalu besar! Maksimum 2MB sahaja.', 5000);
                this.value = '';
                return;
            }
            
            // Check file type
            if (file.type !== 'application/pdf') {
                Toast.error('Hanya fail PDF sahaja dibenarkan!', 5000);
                this.value = '';
                return;
            }
            
            // Success notification
            Toast.success(`Sijil dipilih: ${file.name}`, 3000);
        }
    });

    // 1. Initialize Select2 untuk Anjuran
$('#anjuran').select2({
        theme: 'bootstrap-5',
        placeholder: "Anjuran: Sila taip untuk cari...",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#anjuran').parent(),
        ajax: {
            url: function() {
                    return $('#anjuran').data('url');
                },
            dataType: 'json',
            delay: 250, // Tunggu 250ms lepas user taip baru request (elak spam server)
            data: function (params) {
                return {
                    q: params.term, // Search term
                    page: params.page || 1 // Page number
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 0, // Boleh set 1 kalau nak paksa user taip baru keluar list
    });

    $('.anjuran-item').on('click', function (e) {
        e.preventDefault();

        const value = $(this).data('value');
        const text  = $(this).text();

        // Set nilai sebenar
        $('#anjuran').val(value);

        // Update UI
        $('#anjuranDropdown').text(text);
    });

    // ============================================
    // TOAST FOR FORM RESET
    // ============================================
    $('button[type="reset"]').on('click', function() {
        setTimeout(() => {
            Toast.info('Borang telah diset semula.', 2000);
        }, 100);
        setTimeout(()=>{
            window.location.reload();
        }, 400);
    });

    function countBilHari(){
        const start = new Date(tarikhMula.val());
        const end = new Date(tarikhTamat.val());

        if(!isNaN(start) && !isNaN(end)){
            const diffTime = end - start;
            let days = Math.floor(diffTime / (1000 * 60 * 60 * 24));

            if(days < 0) {
                days = 0;
                // Toast notification for invalid date range
                Toast.warning('Tarikh tamat mestilah selepas tarikh mula!', 3000);
            }

            bilHari.val(days);
            countBilJam(days);
        } else {
            bilHari.val('');
            bilJam.val('');
            bilJam.prop('readonly', false);
        }
    }

    function countBilJam(days){
        if(days === 0){
            bilJam.val('');
            bilJam.prop('readonly', false);
            bilJam.attr({ min: 1, max: 6 });
        } 
        else if(days === 1){
            bilJam.val(6);
            bilJam.prop('readonly', true);
        } 
        else if(days >= 2){
            const totalJam = days * 6;
            bilJam.val(totalJam);
            bilJam.prop('readonly', true);
        } 
        else {
            bilJam.val('');
            bilJam.prop('readonly', false);
            bilJam.attr({ min: 1, max: 6 });
        }
    }

    function applyVisibilityByOption($opt) {
        const hasEndAttr = $opt ? $opt.data("has-end") : undefined;

        const toggleField = (wrapper, input, show) => {
            if(show){
                wrapper.removeClass('hidden-field');
                input.prop("disabled", false);
                wrapper.css({visibility: 'visible', opacity: 1, height: 'auto'}); // Tambah CSS reset
            } else{
                wrapper.addClass('hidden-field');
                input.prop("disabled", true);
                wrapper.css({visibility: 'hidden', opacity: 0, height: 0}); // Sorok habis
            }
        };

        const extraFields = [
            {wrapper: pembentanganWrapper, input:pembentangan},
            {wrapper: penyeliaWrapper, input:penyelia},
            {wrapper: sumberWrapper, input:sumber}
        ];

        const toggleMasaField = (showMula, showAkhir) => {
            const masaWrapper = $("#masaWrapper");
            const field = [
                {wrapper: masaMulaWrapper, input: masaMula, show: showMula},
                {wrapper: masaAkhirWrapper, input: masaAkhir, show: showAkhir}
            ];

            if(!showMula && !showAkhir){
                masaWrapper.addClass('hidden-field');
                masaWrapper.find('input').prop("disabled", true);
            } else {
                masaWrapper.removeClass('hidden-field');
                masaWrapper.find('input').prop("disabled", false);
            }

            field.forEach(({wrapper, input, show}) =>{
                if(show){
                    wrapper.css({visibility: 'visible', opacity: 1});
                    input.prop("disabled", false);
                } else{
                    wrapper.css({visibility: 'hidden', opacity: 0});
                    input.prop("disabled", true);
                }
            });
        };

        extraFields.forEach(field => toggleField(field.wrapper, field.input, false));

        if (typeof hasEndAttr === "undefined") {
            toggleField(tarikhTamatWrapper, tarikhTamat, true);
            toggleField(masaMulaWrapper, masaMula, true);
            toggleField(masaAkhirWrapper, masaAkhir, true);
            toggleField(anjuranWrapper, anjuran, true);
            return;
        }

        if (hasEndAttr == 0) {
            toggleField(tarikhTamatWrapper, tarikhTamat, false);
            toggleMasaField(false, false);
            toggleField(anjuranWrapper, anjuran, false);
            toggleField(lokasiWrapper, lokasi, false);
            toggleField(negeriWrapper, negeri, false);
            extraFields.forEach(field => toggleField(field.wrapper, field.input, true));
        } else if (hasEndAttr == 1) {
            toggleField(tarikhTamatWrapper, tarikhTamat, true);
            toggleMasaField(false, false);
            toggleField(pembentanganWrapper, pembentangan, true);
            toggleField(penyeliaWrapper, penyelia, false);
            toggleField(sumberWrapper, sumber, true);         
        } else if (hasEndAttr == 2) {
            toggleField(tarikhTamatWrapper, tarikhTamat, false);
            toggleField(anjuranWrapper, anjuran, true);
            toggleMasaField(true, true);
        } else if(hasEndAttr == 3){
            toggleMasaField(false, false);
        } else if(hasEndAttr == 4){
            toggleField(pembentanganWrapper, pembentangan, true);
            toggleField(penyeliaWrapper, penyelia, true);
            toggleField(sumberWrapper, sumber, true);
            toggleField(tarikhTamatWrapper, tarikhTamat, false);
            toggleField(anjuranWrapper, anjuran, false);
            toggleMasaField(false, false);
        }
    }

    const $initOpt = $("#program").find("option:selected");
    applyVisibilityByOption($initOpt);

    $("#program").on("change", function () {
        const $sel = $(this).find("option:selected");
        applyVisibilityByOption($sel);
    });

    function updateJamDanMasa() {
        const startVal = $("#tarikh_mula").val();
        const endVal = $("#tarikh_tamat").val();

        if (!startVal || !endVal) return;

        const start = new Date(startVal);
        const end = new Date(endVal);

        const diffHariFloat = (end - start) / (1000 * 60 * 60 * 24);
        const days = Math.floor(diffHariFloat >= 0 ? diffHariFloat : 0);

        if (days === 0) {
            bilJam.removeAttr('readonly').val('');
            bilJam.attr({ min: 1, max: 6 });
            masaAkhir.removeAttr('readonly');
        } else if (days === 1) {
            bilJam.val(6).attr('readonly', true);
            const masaStart = masaMula.val();
            if (masaStart) {
                let [h, m] = masaStart.split(':').map(Number);
                const hoursToAdd = 6;
                h = (h + hoursToAdd) % 24;
                const formatted = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                masaAkhir.val(formatted).attr('readonly', true);
            }
        } else if (days >= 2) {
            const total = 6 * days;
            bilJam.val(total).attr('readonly', true);
            const masaStart = masaMula.val();
            if (masaStart) {
                let [h, m] = masaStart.split(':').map(Number);
                const hoursToAdd = total;
                h = (h + hoursToAdd) % 24;
                const formatted = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                masaAkhir.val(formatted).attr('readonly', true);
            }
        } else {
            bilJam.removeAttr('readonly').val('');
            masaAkhir.removeAttr('readonly');
        }
    }

    tarikhMula.on("change", function () {
        countBilHari();
        updateJamDanMasa();
    });

    tarikhTamat.on("change", function () {
        const start = new Date(tarikhMula.val());
        const end = new Date(this.value);
        
        // Validate date range with toast notification
        if (end < start) {
            Toast.error('Tarikh tamat mestilah selepas atau sama dengan tarikh mula!', 4000);
            $(this).val('');
            return;
        }
        
        countBilHari();
        updateJamDanMasa();
        
        // Show course duration info
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        if (diffDays > 0) {
            Toast.info(`Tempoh kursus: ${diffDays} hari`, 2000);
        }
    });

    masaMula.on("change", function () {
        updateJamDanMasa();
    });

    bilJam.on('input', function() {
        if (!$(this).prop('readonly')) {
            let value = parseInt($(this).val()) || 0;
            if (value < 1) {
                $(this).val(1);
                Toast.warning('Jumlah jam minimum adalah 1 jam.', 2000);
            }
            if (value > 6) {
                $(this).val(6);
                Toast.warning('Jumlah jam maksimum adalah 6 jam.', 2000);
            }
        }
    });

    // ============================================
    // FORM VALIDATION BEFORE SUBMIT
    // ============================================
    $('#kursusFormUpper').on('submit', function(e) {
        const requiredFields = [
            { field: $('#program'), name: 'Program Latihan' },
            { field: $('#aktiviti'), name: 'Aktiviti' },
            { field: $('#tajuk'), name: 'Tajuk Kursus' },
            { field: $('#tarikh_mula'), name: 'Tarikh Mula' },
            { field: $('#tempat'), name: 'Tempat' }
        ];

        let isValid = true;
        let missingFields = [];

        requiredFields.forEach(item => {
            if (!item.field.val() || item.field.val() === '') {
                isValid = false;
                missingFields.push(item.name);
            }
        });

        if (!isValid) {
            e.preventDefault();
            Toast.error(`Sila lengkapkan: ${missingFields.join(', ')}`, 5000);
            return false;
        }

        // Show loading toast
        Toast.info('Sedang menghantar data...', 2000);
    });
});

// ============================================
// ENHANCED CALENDAR INITIALIZATION
// ============================================
document.addEventListener("DOMContentLoaded", function(){  
    const calendarEl = document.getElementById('calendar');
    if(!calendarEl) return console.warn("Calendar element not found");

    let currentCalendar = null;
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // View toggle handlers
    $('.btn-view-toggle').on('click', function() {
        const view = $(this).data('view');
        $('.btn-view-toggle').removeClass('active');
        $(this).addClass('active');
        
        if (currentCalendar) {
            currentCalendar.changeView(view);
            Toast.info(`Paparan ditukar kepada: ${$(this).text()}`, 1500);
        }
    });

    // Fetch and render calendar
    fetch('/kursus/events')
        .then(res => res.json())
        .then(data => {
            //console.log('Raw data from API:', data); // DEBUG
            
            // Group courses by date and title
            const grouped = {};
            data.forEach(event => {
                const date = event.start;
                const key = `${date}_${event.title}`;
                grouped[key] = grouped[key] || {
                    title: event.title, 
                    start: date, 
                    count: 0,
                    originalEvent: event
                };
                grouped[key].count++;
            });

            // Create date-to-courses mapping
            const byDate = {};
            Object.values(grouped).forEach(e => {
                const date = e.start;
                byDate[date] = byDate[date] || [];
                byDate[date].push({
                    title: e.title,
                    count: e.count
                });
            });

            //console.log('Courses by date:', byDate); // DEBUG

            // Update total courses count
            $('#totalCoursesCount').text(data.length);

            // Process events for calendar display
            const eventsProcessed = Object.values(grouped).map(e => {
                const eventDate = new Date(e.start);
                eventDate.setHours(0, 0, 0, 0);
                
                const isPast = eventDate < today;
                const isToday = eventDate.getTime() === today.getTime();
                
                let className = 'event-upcoming';
                if (isToday) className = 'event-ongoing';
                if (isPast) className = 'event-past';

                return {
                    title: e.count > 1 ? `${e.title} (${e.count})` : e.title,
                    start: e.start,
                    className: className,
                    extendedProps: {
                        count: e.count,
                        isPast: isPast,
                        isToday: isToday
                    }
                };
            });

            // Initialize FullCalendar
            currentCalendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                dayMaxEvents: 3,
                locale: 'ms',
                displayEventTime: false,
                eventDisplay: 'auto',
                events: eventsProcessed,
                
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    list: 'Senarai'
                },
                
                // Enhanced day cell rendering
                dayCellDidMount: function(info) {
                    const cellDate = new Date(info.date);
                    cellDate.setHours(0, 0, 0, 0);
                    
                    if (cellDate.getTime() === today.getTime()) {
                        info.el.classList.add('today-cell');
                    }
                    
                    // Add hover effect
                    info.el.addEventListener('mouseenter', function() {
                        this.style.transform = 'scale(1.02)';
                        this.style.transition = 'transform 0.2s ease';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        this.style.transform = 'scale(1)';
                    });
                },
                
                // Enhanced event rendering
                eventDidMount: function(info) {
                    // Add tooltip
                    const tooltip = document.createElement('div');
                    tooltip.className = 'event-tooltip';
                    tooltip.innerHTML = `
                        <strong>${info.event.title}</strong>
                        <br>
                        <small>${formatDate(info.event.start)}</small>
                    `;
                    info.el.appendChild(tooltip);
                    
                    // Add click animation
                    info.el.addEventListener('click', function() {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                },
                
                // Enhanced date click
                dateClick: function(info) {
                    //console.log('Date clicked:', info.dateStr); // DEBUG
                    //console.log('Available courses:', byDate[info.dateStr]); // DEBUG
                    
                    const kursusList = byDate[info.dateStr];
                    if (!kursusList || kursusList.length === 0) {
                        Toast.info('Tiada kursus pada tarikh ini.', 2000);
                        return;
                    }

                    // Animate clicked cell
                    const cell = info.dayEl;
                    cell.style.transition = 'all 0.3s ease';
                    cell.style.transform = 'scale(0.95)';
                    
                    setTimeout(() => {
                        cell.style.transform = 'scale(1)';
                    }, 300);

                    // Build enhanced modal content - FIXED
                    let html = '<div class="courses-list-modern">';
                    kursusList.forEach((k, index) => {
                        const animationDelay = index * 0.1;
                        html += `
                            <div class="course-item-modern" style="animation-delay: ${animationDelay}s;">
                                <div class="course-icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div class="course-details">
                                    <h6 class="course-title gabarito-regular">${k.title}</h6>
                                    ${k.count > 1 ? `<span class="course-badge">${k.count} sesi</span>` : ''}
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';

                    //console.log('Generated HTML:', html); // DEBUG

                    // Update modal
                    $('#modalKursusBody').html(html);
                    $('#modalKursusTitle').text('Senarai Kursus');
                    $('#modalKursusDate').text(formatDateMalay(info.date));
                    
                    // Show modal with animation
                    const modal = new bootstrap.Modal(document.getElementById('kursusModal'));
                    modal.show();
                    
                    //console.log('Modal should be visible now'); // DEBUG
                }
            });

            currentCalendar.render();
            
            // Success notification for calendar load
            Toast.success(`${data.length} kursus berjaya dimuatkan`, 2000);
            //console.log('Calendar rendered successfully');
        })
        .catch(err => {
            console.error('Error fetching events:', err);
            Toast.error('Ralat memuatkan kalendar. Sila cuba sebentar lagi.', 5000);
            $('#calendar').html(`
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle mb-2"></i>
                    <p class="mb-0">Ralat memuatkan kalendar. Sila cuba sebentar lagi.</p>
                </div>
            `);
        });
});

// Helper function to format date
function formatDate(date) {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('ms-MY', options);
}

function formatDateMalay(date) {
    const options = { day: 'numeric', month: 'long', year: 'numeric' };
    return new Date(date).toLocaleDateString('ms-MY', options);
}