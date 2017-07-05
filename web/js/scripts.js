$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(window).on('load', function() {
        $(document).trigger("global:load");
    });
});