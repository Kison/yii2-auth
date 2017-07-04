$(function(){
    $('[name="email-auth-button"]').on('click', function () {
        $('.phone-auth-button-wrapper').removeClass('hidden');
        $('.email-auth-button-wrapper').addClass('hidden');
        $('#phone-auth-form').addClass('hidden');
        $('#authentication-form').removeClass('hidden');
    });

    $('[name="phone-auth-button"]').on('click', function () {
        $('.phone-auth-button-wrapper').addClass('hidden');
        $('.email-auth-button-wrapper').removeClass('hidden');
        $('#phone-auth-form').removeClass('hidden');
        $('#authentication-form').addClass('hidden');
    });
});