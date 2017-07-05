$(function () {
    var idPrefix = '#firebase-phone-auth-widget-',
        phoneInputElement = $(idPrefix + "phone-input"),
        phoneButtonElement = $(idPrefix + "phone-apply"),
        codeInputElement = $(idPrefix + "code-input"),
        codeButtonElement = $(idPrefix + "code-apply"),
        resendCodeButtonElement = $(idPrefix + "resend-code"),
        changePhoneButtonElement = $(idPrefix + "change-phone"),
        errorBoxMessageWrapperElement = $(idPrefix + "error-box");

    console.log(errorBoxMessageWrapperElement);

    phoneInputElement.on('change keyup', updateSignInButtonUI);
    codeInputElement.on('change keyup', updateCodeButtonUI);

    phoneButtonElement.on('click', function(){
        if (isPhoneNumberValid()) {
            window.signingIn = true;
            updateSignInButtonUI();
            resetRecaptcha();
            var phoneNumber = getPhoneNumberFromUserInput(),
                appVerifier = window.recaptchaVerifier;

            $('.phone-first-step').addClass('hidden');
            signInWithNumber(phoneNumber, appVerifier);
        }
    });

    resendCodeButtonElement.on('click', function(){
        resetRecaptcha();
        console.log("Resend");
        var phoneNumber = getPhoneNumberFromUserInput(),
            appVerifier = window.recaptchaVerifier;
        signInWithNumber(phoneNumber, appVerifier);
    });

    changePhoneButtonElement.on('click', function(){
        hideError();
        resetRecaptcha();
        console.log("Change phone");
        $('.phone-first-step').removeClass('hidden');
        $('.phone-second-step, .phone-third-step').addClass('hidden');
        phoneInputElement.val("");
        updateSignInButtonUI();
    });

    function signInWithNumber(phoneNumber, appVerifier) {
        $('.phone-second-step').removeClass('hidden');
        $('.phone-third-step').addClass('hidden');
        codeInputElement.val("");
        updateCodeButtonUI();

        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
            .then(function(confirmationResult) {
                window.signingIn = false;

                $('.phone-second-step').addClass('hidden');
                $('.phone-third-step').removeClass('hidden');

                codeButtonElement.one('click', function() {
                    confirmationResult.confirm(getCodeFromUserInput()).then(function(result) {
                        $(document).trigger("firebase:phoneVerified", [result.user]);
                    }).catch(function (error) {
                        console.log(error);
                        showError(error.message);
                    });
                });

            }).catch(function(error) {
                console.log(error);
                window.signingIn = false;
                showError('Something went wrong, please try again');
            });
    }

    /**
     * Shows error message
     * @param message
     */
    function showError(message) {
        errorBoxMessageWrapperElement.children('.message').text(message);
        errorBoxMessageWrapperElement.removeClass('hidden');
    }

    /** Hides error message */
    function hideError() {
        errorBoxMessageWrapperElement.children('.message').text("");
        errorBoxMessageWrapperElement.addClass('hidden');
    }

    function getPhoneNumberFromUserInput() {
        return phoneInputElement.val();
    }

    function getCodeFromUserInput() {
        return codeInputElement.val();
    }

    function isCodeValid() {
        var pattern = /^[0-9]+$/,
            code = getCodeFromUserInput();
        return code.search(pattern) !== -1;
    }

    function isPhoneNumberValid() {
        var pattern = /^\+[0-9\s\-\(\)]+$/,
            phoneNumber = getPhoneNumberFromUserInput();
        return phoneNumber.search(pattern) !== -1;
    }

    function resetRecaptcha() {
        return window.recaptchaVerifier.render().then(function(widgetId) {
            grecaptcha.reset(widgetId);
        });
    }

    function updateSignInButtonUI() {
        phoneButtonElement.prop('disabled', (!isPhoneNumberValid() || !!window.signingIn));
    }

    function updateCodeButtonUI() {
        codeButtonElement.prop('disabled', !isCodeValid());
    }
});

$(document).on("global:load", function(){
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('firebase-phone-auth-widget-recaptcha-container');
});
