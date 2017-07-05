
/**
 * Firebase sign in method
 * @param {object} provider
 * @param {string} providerName
 * @param {function} onSuccess
 * @param {function} onFail
 */
function firebaseAuthentication(provider, providerName, onSuccess, onFail) {
    firebase.auth().signInWithPopup(provider).then(function(result) {
        waitingDialog.show('Loading...');
        result.user.getIdToken().then(function (token) {
            var params = {
                'via' : providerName,
                'firebase_access_token'      : token,
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
        });

    }).catch(function(error) {
        // Link user to existing profile
        if (error.code === "auth/account-exists-with-different-credential") {
            var credential = error.credential,
                email = error.email;

            firebase.auth().fetchProvidersForEmail(email).then(function(providers) {
                console.log(providers);
                var provider,
                    providerName;

                if (providers[0] === 'facebook.com') {
                    providerName = 'facebook';
                    provider = new firebase.auth.FacebookAuthProvider();
                }
                if (providers[0] === 'twitter.com') {
                    providerName = 'twitter';
                    provider = new firebase.auth.TwitterAuthProvider();
                }

                if (typeof(provider) !== 'undefined') {
                    firebase.auth().signInWithPopup(provider).then(function(result) {
                        result.user.linkWithCredential(credential).then(function() {
                            waitingDialog.show('Loading...');
                            result.user.getIdToken().then(function (token) {
                                var params = {
                                    'via' :  providerName,
                                    'firebase_access_token'      : token,
                                    'firebase_user_id'           : result.user.uid,
                                    'user_email'                 : result.user.email,
                                    'user_name'                  : result.user.displayName
                                };

                                $.post('firebase/social', params, function(data) {
                                    console.log(data);
                                });
                            });
                        });
                    }).catch(function(error) {
                        console.log(error);
                    });
                } else {
                    alert("Something went wrong, please try again later!");
                }
            });
        }

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
            console.log('Sign out', this);
        }).catch(function(error) {
            if (typeof(onFail) === 'function') {
                onFail(error);
            }
            console.log(error);
        });
    }
}