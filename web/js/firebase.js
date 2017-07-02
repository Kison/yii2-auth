function firebaseAuthentication(provider, onSuccess, onFail) {
    firebase.auth().signInWithPopup(provider).then(function(result) {
        console.log(result);
        if (typeof(onSuccess) === 'function') {
            onSuccess(result);
        }
    }).catch(function(error) {
        if (typeof(onFail) === 'function') {
            onFail(error);
        }
        console.log(error);
    });
}