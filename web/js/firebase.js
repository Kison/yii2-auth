
/**
 * Firebase sign in method
 * @param {object} provider
 * @param {string} providerName
 * @param {function} onSuccess
 * @param {function} onFail
 */
function firebaseAuthentication(provider, providerName, onSuccess, onFail) {
    firebase.auth().signInWithPopup(provider).then(function(result) {
        console.log(result);

        var params = {
            'via' : providerName,
            'firebase_access_token'      : result.credential.accessToken,
            'firebase_user_id'           : result.user.uid,
            'user_email'                 : result.user.email,
            'user_name'                  : result.user.displayName
        };

        $.post('firebase/social', params, function(data) {
            console.log(data);
        });

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

/**
 * Firebase sign out method
 * @param {function} onSuccess
 * @param {function} onFail
 */
function firebaseSingOut(onSuccess, onFail) {
    var user = firebase.auth().currentUser;
    if (user) {
        firebase.auth().signOut().then(function() {
            if (typeof(onSuccess) === 'function') {
                onSuccess(this);
            }
            console.log(this);
        }).catch(function(error) {
            if (typeof(onFail) === 'function') {
                onFail(error);
            }
            console.log(error);
        });
    }

}