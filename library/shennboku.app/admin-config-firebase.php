<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
if(isset($_POST['save'])) {
    $post_1 = filter($_POST['fcm_key']);
    $post_2 = filter($_POST['fcm_project']);
    $post_3 = filter($_POST['fcm_msgid']);
    $post_4 = filter($_POST['fcm_sendid']);
    $post_5 = filter($_POST['fcm_appid']);
    $post_6 = filter($_POST['fcm_measurement']);
    $post_7 = filter($_POST['fcm_version']);
    
    $post_auth = $post_2.'.firebaseapp.com';
    $post_storage = $post_2.'.appspot.com';
    
    $FirebaseSwing = "importScripts(\"https://www.gstatic.com/firebasejs/$post_7/firebase-app.js\");
importScripts(\"https://www.gstatic.com/firebasejs/$post_7/firebase-messaging.js\");
importScripts(\"https://www.gstatic.com/firebasejs/$post_7/firebase-analytics.js\");

firebase.initializeApp({
    messagingSenderId: \"$post_4\",
    apiKey: \"$post_1\",
    projectId: \"$post_2\",
    appId: \"$post_5\",
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(\"[firebase-messaging-sw.js] Received background message\",payload);
    const ShennData = JSON.parse(payload.data.notification);
    const notificationTitle = ShennData.title;
    const notificationOptions = {body: ShennData.body};
    return self.registration.showNotification(notificationTitle,notificationOptions);
});";
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!$post_1 || !$post_2 || !$post_3 || !$post_4 || !$post_5 || !$post_6 || !$post_7) {
        ShennXit(['type' => false,'message' => 'Firebase configuration data not detected.']);
    } else {
        if($call->query("UPDATE conf SET c1 = '$post_1', c2 = '$post_2', c3 = '$post_3', c4 = '$post_4', c5 = '$post_5', c6 = '$post_6', c7 = '$post_7', c8 = 'true' WHERE code = 'firebase'") == true) {
            file_put_contents(_DIR_('firebase-messaging-sw.js',''), $FirebaseSwing);
            ShennXit(['type' => true,'message' => 'Firebase configuration changed successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['disable'])) {
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else {
        if($call->query("UPDATE conf SET c1 = '', c2 = '', c3 = '', c4 = '', c5 = '', c6 = '', c7 = '', c8 = 'false' WHERE code = 'firebase'") == true) {
            if(file_exists(_DIR_('firebase-messaging-sw.js',''))) unlink(_DIR_('firebase-messaging-sw.js',''));
            ShennXit(['type' => true,'message' => 'Firebase has been successfully disabled.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_GET['activate'])) {
    if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else {
        if($call->query("UPDATE conf SET c1 = '', c2 = '', c3 = '', c4 = '', c5 = '', c6 = '', c7 = '', c8 = 'active' WHERE code = 'firebase'") == true) {
            ShennXit(['type' => true,'message' => 'Firebase has been successfully activated.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
}