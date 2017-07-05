$(function(){
    $('[name="email-auth-button"]').on('click', function () {
        $('.phone-auth-button-wrapper').removeClass('hidden');
        $('.email-auth-button-wrapper').addClass('hidden');
        $('#phone-widget-wrapper').addClass('hidden');
        $('#authentication-form').removeClass('hidden');
    });

    $('[name="phone-auth-button"]').on('click', function () {
        $('.phone-auth-button-wrapper').addClass('hidden');
        $('.email-auth-button-wrapper').removeClass('hidden');
        $('#phone-widget-wrapper').removeClass('hidden');
        $('#authentication-form').addClass('hidden');
    });
});