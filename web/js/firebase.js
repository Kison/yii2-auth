function firebaseAuthentication(provider, providerName, onSuccess, onFail) {
    firebase.auth().signInWithPopup(provider).then(function(result) {
        console.log(result);
        if (typeof(onSuccess) === 'function') {
            onSuccess(result);

            var params = {
                'via' : providerName
            };

            $.post('firebase/auth', params, function(data) {
                console.log(data);
            });
        }
    }).catch(function(error) {
        if (typeof(onFail) === 'function') {
            onFail(error);
        }
        console.log(error);
    });
}