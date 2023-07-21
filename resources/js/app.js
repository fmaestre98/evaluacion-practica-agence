import './bootstrap';
$(function(){
    $("#datepicker_start").datepicker({
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"

    });       
    $("#datepicker_end").datepicker({
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"

    });     
    
    $("#datepicker_end").change(function() {
       Livewire.emit('onEndChange',$("#datepicker_end").val());
    });

    $("#datepicker_start").change(function() {
         Livewire.emit('onStartChange',$("#datepicker_start").val());
    });
});