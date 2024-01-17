<?php
class FirebaseCM
{
    private $apiKey;
    private $serverKey;
    private $senderId;
    
    public function __construct($key,$skey,$sender) {
        $this->apiKey = $key;
        $this->serverKey = $skey;
        $this->senderId = $sender;
    }
    
    public function createGroup($regId,$user) {
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/notification',
            ['Content-Type: application/json','Authorization: key='.$this->apiKey,'project_id: '.$this->senderId],
            json_encode(['operation' => 'create','notification_key_name' => 'ShennX-'.$user,'registration_ids' => ["$regId"]])
        );
        if(isset($try['notification_key'])) return ['result' => true,'data' => $try['notification_key'],'message' => 'Group created successfully.'];
        return ['result' => false,'data' => null,'message' => 'Failed to create group.'];
    }
    
    public function groupToken($user) {
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/notification?notification_key_name=ShennX-'.$user,
            ['Content-Type: application/json','Authorization: key='.$this->apiKey,'project_id: '.$this->senderId],
            '{}'
        );
        if(isset($try['notification_key'])) return ['result' => true,'data' => $try['notification_key'],'message' => 'Successfully earned tokens.'];
        return ['result' => false,'data' => null,'message' => 'Failed to get token.'];
    }
    
    public function groupAdd($regId,$token,$user) {
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/notification',
            ['Content-Type: application/json','Authorization: key='.$this->apiKey,'project_id: '.$this->senderId],
            json_encode(['operation' => 'add','notification_key_name' => 'ShennX-'.$user,'notification_key' => $token,'registration_ids' => ["$regId"]])
        );
        if(isset($try['notification_key'])) return ['result' => true,'data' => $try['notification_key'],'message' => 'Successfully added to group.'];
        return ['result' => false,'data' => null,'message' => 'Failed to add to group.'];
    }
    
    public function groupKick($regId,$token,$user) {
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/notification',
            ['Content-Type: application/json','Authorization: key='.$this->apiKey,'project_id: '.$this->senderId],
            json_encode(['operation' => 'remove','notification_key_name' => 'ShennX-'.$user,'notification_key' => $token,'registration_ids' => ["$regId"]])
        );
        if(isset($try['notification_key'])) return ['result' => true,'data' => $try['notification_key'],'message' => 'Successfully removed from group.'];
        return ['result' => false,'data' => null,'message' => 'Failed to leave the group.'];
    }
    
    public function notifBrowser($to,$title,$body) {
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/send',
            ['Content-Type: application/json','Authorization: key='.$this->serverKey],
            json_encode(['data' => ['notification' => ['title' => $title,'body' => $body]],'to' => $to])
        );
        if(isset($try['success'])) {
            if($try['success'] > 0) return ['result' => true,'data' => $try,'message' => 'The notification was successfully sent to the device.'];
            return ['result' => false,'data' => null,'message' => 'Failed to send notification.'];
        } else {
            return ['result' => false,'data' => null,'message' => 'Connection Failed.'];
        }
    }
    
    public function notifBrowserMulti($to,$title,$body) {
        if(!is_array($to)) return ['result' => false,'data' => null,'message' => 'Recipient ID must be an array!'];
        $try = $this->connectHeaderPost(
            'https://fcm.googleapis.com/fcm/send',
            ['Content-Type: application/json','Authorization: key='.$this->serverKey],
            json_encode(['data' => ['notification' => ['title' => $title,'body' => $body]],'registration_ids' => $to])
        );
        if(isset($try['success'])) {
            if($try['success'] > 0) return ['result' => true,'data' => $try,'message' => 'The notification was successfully sent to the device.'];
            return ['result' => false,'data' => null,'message' => 'Failed to send notification.'];
        } else {
            return ['result' => false,'data' => null,'message' => 'Connection Failed.'];
        }
    }

    private function connectHeaderPost($end_point,$header,$postdata,$reqout = 'decode') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $chresult = curl_exec($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
}