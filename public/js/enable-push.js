initSW();

var api_key = config.NOTIFICATIONS;


function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    fetch('/push', {
            method: 'POST',
            body: JSON.stringify(pushSubscription),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-Token': token
            }
        })
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            // console.log(res)
        })
        .catch((err) => {
            console.log(err)
        });
}

function urlBase64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    api_key
                )
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            updateBtn();
            // console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
            const permissionResult = Notification.requestPermission(function (result) {
                resolve(result);
            });

            if (permissionResult) {
                permissionResult.then(resolve, reject);
            }
        })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
            subscribeUser();
        });
}

function initSW() {

    let pushButton = document.querySelector('.js-push-btn');

    let isSubscribed = false;

    if(pushButton)
    pushButton.addEventListener('click', function () {
        if (Notification.permission === "denied") {
            alert("Notifications blocked. Please enable them in your browser.");
          } else {
              subscribeUser();            
          }
    })

    updateBtn()

    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker.register('/serviceworker.js')
        .then(() => {
            // console.log('serviceWorker installed!')
            isSubscribed = true;
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}

function updateBtn() {
    let pushButton = document.querySelector('.js-push-btn');
    if(pushButton)
    if (Notification.permission !== "granted") {
        pushButton.style = "display: flex; z-index: 10"
    } else {
        pushButton.style = "display: none";
    }
}
