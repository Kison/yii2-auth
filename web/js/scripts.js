$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(window).on('load', function() {
        $(document).trigger("global:load");
    });

    $('#sign-out-form').on('submit', function () {
        firebaseSingOut();
        return true;
    });
});