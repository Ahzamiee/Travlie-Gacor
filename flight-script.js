// js/flight-script.js

$(function() {
    // Datepicker
    $(".datepicker-input").datepicker({
        dateFormat: "dd/mm/yy", // Format input ke hh/bb/tttt
        minDate: 0 // Tidak bisa memilih tanggal di masa lalu
    });

    // Autocomplete untuk "Dari Mana?" dan "Ke Mana?"
    $(".autocomplete-input").autocomplete({
        source: function(request, response) {
            $.ajax({
                // Pastikan URL ini benar sesuai dengan routing index.php Anda
                // Asumsi base URL adalah 'http://localhost/Travlie/tugasLK02/'
                url: "index.php?c=flight&m=getCitiesAutocomplete", // Sesuaikan dengan routing Anda
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error for autocomplete:", textStatus, errorThrown);
                }
            });
        },
        minLength: 2 // Mulai pencarian setelah 2 karakter
    });

    // Passenger Selector Logic
    $('.passenger-input-group').on('click', function(e) {
        e.stopPropagation(); // Mencegah penutupan dropdown saat klik di dalam
        $('.passenger-selector').toggle();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.passenger-input-group').length) {
            $('.passenger-selector').hide();
        }
    });

    $('.passenger-selector').on('click', function(e) {
        e.stopPropagation(); // Mencegah penutupan dropdown saat klik di dalam
    });

    $('.btn-minus').on('click', function() {
        let target = $(this).data('target');
        let input = $('#' + target);
        let currentValue = parseInt(input.val());
        if (currentValue > (target === 'dewasa' ? 1 : 0)) { // Minimum 1 dewasa, minimum 0 anak
            input.val(currentValue - 1).change();
        }
    });

    $('.btn-plus').on('click', function() {
        let target = $(this).data('target');
        let input = $('#' + target);
        let currentValue = parseInt(input.val());
        input.val(currentValue + 1).change();
    });

    $('#dewasa, #anak').on('change', function() {
        let dewasa = parseInt($('#dewasa').val());
        let anak = parseInt($('#anak').val());
        $('#penumpang').val(dewasa + ' Dewasa, ' + anak + ' Anak');
    });
});
