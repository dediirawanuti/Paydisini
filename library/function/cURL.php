<?php
class cURL
{
    public function connectHeader($end_point,$header,$reqout = 'decode') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $chresult = curl_exec($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }

    public function connectPost($end_point,$postdata,$reqout = 'decode') {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        if(!$chresult) $chresult = $this->connectHeaderPost($end_point,['content-type: multipart/form-data;'],$postdata,'original');
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }

    public function connectHeaderPost($end_point,$header,$postdata,$reqout = 'decode') {
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
    
    public function connectCustom($data,$res = 'decode') {
        $ch = curl_init();
        curl_setopt_array($ch, $data);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return ($res == 'decode') ? json_decode($chresult, true) : $chresult;
    }
    
    public function connectGet($end_point,$getdata,$reqout = 'decode') {
        $link = (is_array($getdata)) ? $end_point.'?'.http_build_query($getdata) : $end_point;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.47 Safari/537.36');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return ($reqout == 'decode') ? json_decode($chresult, true) : $chresult;
    }
}

$curl = new cURL;