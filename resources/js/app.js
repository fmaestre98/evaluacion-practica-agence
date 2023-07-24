import './bootstrap';
$(function () {
    $("#datepicker_start").datepicker({
        format: "dd/mm/yyyy",
        startView: "year",
        autoclose: true,

    });
    $("#datepicker_end").datepicker({
        format: "dd/mm/yyyy",
        startView: "months",
        autoclose: true

    });


    $("#datepicker_end").change(function () {

        Livewire.emit('onEndChange', $("#datepicker_end").val());
    });

    $("#datepicker_start").change(function () {

        Livewire.emit('onStartChange', $("#datepicker_start").val());
    });

});