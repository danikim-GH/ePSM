$(document).ready(function () {
    //wrapper = column dalam daftar kursus
    const tarikhTamatWrapper = $("#tarikh_tamat").closest(".col-lg-6");
    const masaMulaWrapper = $("#masa_mula").closest(".col-lg-6");
    const masaAkhirWrapper = $("#masa_akhir").closest(".col-lg-6");
    const pembentanganWrapper = $("#pembentangan").closest(".col-12");
    const penyeliaWrapper = $("#penyelia").closest(".col-12");
    const sumberWrapper = $("#sumber").closest(".col-12");
    const anjuranWrapper = $("#anjuran").closest(".col-12");
    const lokasiWrapper = $("#lokasi").closest(".col-lg-6");
    const negeriWrapper = $("#negeri").closest(".col-lg-6");

    //input fields
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



    // Kira bil hari dan bil jam
function countBilHari(){
    const start = new Date(tarikhMula.val());
    const end = new Date(tarikhTamat.val());

    if(!isNaN(start) && !isNaN(end)){
        const diffTime = end - start;
        // calculate integer days difference: same-day => 0, next-day => 1, etc.
        let days = Math.floor(diffTime / (1000 * 60 * 60 * 24));

        if(days < 0) days = 0;

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
        // same day: user chooses 1-6 hours
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


// Kawal visibiliti ikut data-has-end
function applyVisibilityByOption($opt) {
    const hasEndAttr = $opt ? $opt.data("has-end") : undefined;

    const toggleField = (wrapper, input, show) => {
        if(show){
            wrapper.removeClass('hidden-field');
            input.prop("disabled", false);
        } else{
            wrapper.addClass('hidden-field');
            input.prop("disabled", true);
        }
    };
    //const extra field
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

    // fallback - tunjuk semua kalau tak detect
    //(wrapper, input, show[t/f])
    if (typeof hasEndAttr === "undefined") {
        toggleField(tarikhTamatWrapper, tarikhTamat, true);
        toggleField(masaMulaWrapper, masaMula, true);
        toggleField(masaAkhirWrapper, masaAkhir, true);
        toggleField(anjuranWrapper, anjuran, true);
        return;
    }

    if (hasEndAttr == 0) {// pembelajran kendiri
        // hide tarikh tamat & semua masa
        toggleField(tarikhTamatWrapper, tarikhTamat, false);
        toggleMasaField(false, false);
        toggleField(anjuranWrapper, anjuran, false);
        toggleField(lokasiWrapper, lokasi, false);
        toggleField(negeriWrapper, negeri, false);
        extraFields.forEach(field => toggleField(field.wrapper, field.input, true));
    } else if (hasEndAttr == 1) {
        // field bengkel
        toggleField(tarikhTamatWrapper, tarikhTamat, true);
        toggleMasaField(false, false);
        toggleField(pembentanganWrapper, pembentangan, true);
        toggleField(penyeliaWrapper, penyelia, false);
        toggleField(sumberWrapper, sumber, true);         
    } else if (hasEndAttr == 2) {//sesi pembelajaran
        toggleField(tarikhTamatWrapper, tarikhTamat, false);
        toggleField(anjuranWrapper, anjuran, true);
        toggleMasaField(true, true);
    } else if(hasEndAttr == 3){ // latihan
        toggleMasaField(false, false);

    } else if(hasEndAttr == 4){//program-> untuk sumber & penyelia
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

    // Update masa akhir & jam ikut tarikh
    function updateJamDanMasa() {
        const startVal = $("#tarikh_mula").val();
        const endVal = $("#tarikh_tamat").val();

        if (!startVal || !endVal) return;

        const start = new Date(startVal);
        const end = new Date(endVal);

        // compute integer days difference
        const diffHariFloat = (end - start) / (1000 * 60 * 60 * 24);
        const days = Math.floor(diffHariFloat >= 0 ? diffHariFloat : 0);

        if (days === 0) {
            // same day: user chooses 1-5 hours
            bilJam.removeAttr('readonly').val('');
            bilJam.attr({ min: 1, max: 6 });
            masaAkhir.removeAttr('readonly');
        } else if (days === 1) {
            // next day: fixed 6 hours
            bilJam.val(6).attr('readonly', true);
            // auto masa akhir = masa mula + 6 hours
            const masaStart = masaMula.val();
            if (masaStart) {
                let [h, m] = masaStart.split(':').map(Number);
                const hoursToAdd = 6;
                h = (h + hoursToAdd) % 24;
                const formatted = `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}`;
                masaAkhir.val(formatted).attr('readonly', true);
            }
        } else if (days >= 2) {
            // multi-day: 6 hours per day
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
            // fallback
            bilJam.removeAttr('readonly').val('');
            masaAkhir.removeAttr('readonly');
        }
    }

    // Event handler
    tarikhMula.on("change", function () {
        countBilHari();
        updateJamDanMasa();
    });

    tarikhTamat.on("change", function () {
        countBilHari();
        updateJamDanMasa();
    });

    masaMula.on("change", function () {
        updateJamDanMasa();
    });

    // Enforce jam limits on manual input
    bilJam.on('input', function() {
        if (!$(this).prop('readonly')) {
            let value = parseInt($(this).val()) || 0;
            if (value < 1) $(this).val(1);
            if (value > 6) $(this).val(6);
        }
    });
});

document.addEventListener("DOMContentLoaded",function(){  
    const calendarEl = document.getElementById('calendar');
    if(!calendarEl) return console.warn("Calendar element not found");

    fetch('/kursus/events').then(res => res.json()).then(data=>{
        const grouped = {};
        data.forEach(event => {
            const date = event.start;
            const key = `${date}_${event.title}`;
            grouped[key] = grouped[key] || {title: event.title, start:date, count:0};
            grouped[key].count++;
        });

        const byDate = {};
        Object.values(grouped).forEach(e=>{
            const date = e.start;
            byDate[date] = byDate[date] || [];
            byDate[date].push(e.title);
        });

        const eventsProcessed = Object.values(grouped).map(e =>({
            title: e.count > 1 ? `${e.title} (x${e.count})`: e.title,
            start: e.start,
        }));

        const calendar = new FullCalendar.Calendar(calendarEl,{
            initialView:'dayGridMonth',
            locale:'ms',
            displayEventTime:false,
            eventDisplay:'block',
            events: eventsProcessed,
            eventColor: '#007BFF',
            eventTextColor: '#FFFFFF',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listMonth'
            },
            dateClick: function(info){
                const kursusList = byDate[info.dateStr];
                if(!kursusList || kursusList.length === 0)return;

                let html = '<ul class="list-group">';
                kursusList.forEach(k =>{
                    html+= `<li class="list-group-item">${k}</li>`
                });
                html += '</ul>';

                $('#modalKursusBody').html(html);
                $('#modalKursusTitle').text(`Senarai Kursus (${info.dateStr})`);
                $('#kursusModal').modal('show');
            }
        });
        calendar.render();
    })
    .catch(err => console.error('Error fetching events:',err));

});