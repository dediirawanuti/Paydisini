<?php
/*
.---------------------------------------------------------------------------.
|    Script: Atlantic Mutasi                                                |
|   Version: 1.5.8                                                          |
|   Release: November 24, 2019 (12:27 WIB)                                  |
|    Update: January 06, 2021 (03:31 WIB)                                   |
|                                                                           |
|                     Pasal 57 ayat (1) UU 28 Tahun 2014                    |
|      Copyright © 2019, Afdhalul Ichsan Yourdan. All Rights Reserved.      |
| ------------------------------------------------------------------------- |
| Hubungi Saya:                                                             |
| - Facebook    - Afdhalul Ichsan Yourdan   - https://s.id/ShennFacebook    |
| - Instagram   - ShennBoku                 - https://s.id/ShennInstagram   |
| - Telegram    - ShennBoku                 - https://t.me/ShennBoku        |
| - Twitter     - ShennBoku                 - https://s.id/ShennTwitter     |
| - WhatsApp    - 0857 7290 6190            - 0822 1158 2471                |
'---------------------------------------------------------------------------'
*/

class AtlanticMutasi
{
    private $url = 'https://atlantic-group.co.id/api/v1';
    public $id;
    public $key;
    public $sid;
    
    public $proxy_use;
    public $proxy_url;
    public $proxy_auth;

    public function __construct($punten) {
        $this->id = $punten['id'];
        $this->key = $punten['key'];
        $this->sid = $punten['sid'];

        if(isset($punten['proxy']['use'])) {
            $this->proxy_use = ($punten['proxy']['use'] == true) ? true : false;
            if(isset($punten['proxy']['url']) && isset($punten['proxy']['auth'])) {
                $this->proxy_url = (!empty($punten['proxy']['url'])) ? $punten['proxy']['url'] : 'proxy.rapidplex.com:3128';
                $this->proxy_auth = (!empty($punten['proxy']['auth'])) ? $punten['proxy']['auth'] : 'user:domainesia';
            } else {
                $this->proxy_url = 'proxy.rapidplex.com:3128';
                $this->proxy_auth = 'user:domainesia';
            }
        } else {
            $this->proxy_use = false;
        }
    }

    public function info($q = '') {
        $bank = strtoupper($q);
        if(in_array($bank,['BCA','BNI','GOPAY','OVO'])) {
            return $this->connect($this->url.'/mutasi/info',['payment' => $bank]);
        } else {
            return $this->connect($this->url.'/mutasi/info');
        }
    }

    public function bca($from,$to,$qty = '',$desc = '') {
        return $this->connect($this->url.'/mutasi/bca',['from_date' => $from,'to_date' => $to,'quantity' => $qty,'description' => $desc]);
    }

    public function bni($from,$to,$qty = '',$desc = '') {
        return $this->connect($this->url.'/mutasi/bni',['from_date' => $from,'to_date' => $to,'quantity' => $qty,'description' => $desc]);
    }

    public function gopay($limit = 10,$qty = '',$desc = '') {
        return $this->connect($this->url.'/mutasi/gopay',['limit' => $limit,'quantity' => $qty,'description' => $desc]);
    }

    /* Tidak bisa digunakana lagi */
    // public function gopayTrf($act,$phone,$amount,$secure,$description = '') {
    //     if($act == 'detail') {
    //         return $this->connect($this->url.'/transfer/gopay/detail',['target' => $phone]);
    //     } else if($act == 'transfer') {
    //         return $this->connect($this->url.'/transfer/gopay/',['target' => $phone,'jumlah' => $amount,'pin' => $secure,'description' => $description]);
    //     } else {
    //         return ['result' => false,'data' => null,'message' => 'Invaliid Action!'];
    //     }
    // }

    public function ovo($limit = 10,$qty = '',$desc = '') {
        return $this->connect($this->url.'/mutasi/ovo',['limit' => $limit,'quantity' => $qty,'description' => $desc]);
    }

    public function ovoBank() {
        return $this->connect($this->url.'/transfer/ovo/data-bank');
    }

    public function ovoTrf($act,$phone,$amount,$secure,$description = '') {
        if($act == 'detail') {
            return $this->connect($this->url.'/transfer/ovo/detail',['type' => 'OVO','target' => $phone]);
        } else if($act == 'transfer') {
            return $this->connect($this->url.'/transfer/ovo/',['type' => 'OVO','target' => $phone,'jumlah' => $amount,'pin' => $secure,'description' => $description]);
        } else {
            return ['result' => false,'data' => null,'message' => 'Invaliid Action!'];
        }
    }

    public function ovoTrfBank($act,$bank,$reknya,$amount,$secure,$description = '') {
        if($act == 'detail') {
            return $this->connect($this->url.'/transfer/ovo/detail',['type' => 'BANK','target' => $reknya,'bank_code' => $bank]);
        } else if($act == 'transfer') {
            return $this->connect($this->url.'/transfer/ovo/',['type' => 'BANK','target' => $reknya,'jumlah' => $amount,'pin' => $secure,'bank_code' => $bank,'description' => $description]);
        } else {
            return ['result' => false,'data' => null,'message' => 'Invaliid Action!'];
        }
    }

    # END POINT CONNECTION #

    private function connect($end_point,$postdata = []) {
        $ch = curl_init();
        if($this->proxy_use == true) curl_setopt($ch, CURLOPT_PROXY, $this->proxy_url);
        if($this->proxy_use == true) curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy_auth);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $postdata['key'] = $this->key;
        $postdata['sid'] = $this->sid;
        $postdata['sign'] = md5($this->id.$this->key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postdata));
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}

$AtlMutasi = new AtlanticMutasi([
    'id'    => '', // API ID
    'key'   => '', // API Key
    'sid'   => '', // Subscription ID
    'proxy' => [    // Proxy Connection
        'use' => false, // Proxy Use
        'url' => '', // Proxy URL
        'auth' => '', // Proxy Authentication
    ]
]);

// print json_encode($AtlMutasi->info()); // Mendapatkan Informasi Rekening

// print json_encode($AtlMutasi->bca('Nomor Rekening / X',date('Y-m-d'),date('Y-m-d'))); // Mendapatkan Mutasi BCA hari ini

// print json_encode($AtlMutasi->bni('Nomor Rekening / X',date('Y-m-d'),date('Y-m-d'))); // Mendapatkan Mutasi BNI hari ini

// print json_encode($AtlMutasi->gopay('Nomor HP / X',20)); // Mendapatkan 20 Mutasi GOPAY
// Can't Use#print json_encode($AtlMutasi->gopayTrf('detail','nomor tujuan','jumlah trf','pin','deskripsi')); // Melihat detail transfer GOPAY
// Can't Use#print json_encode($AtlMutasi->gopayTrf('transfer','nomor tujuan','jumlah trf','pin','deskripsi')); // Melakukan transfer GOPAY

// print json_encode($AtlMutasi->ovo('Nomor HP / X',20)); // Mendapatkan 20 Mutasi OVO
// print json_encode($AtlMutasi->ovoBank()); // Melihat kode bank untuk Transfer OVO
// print json_encode($AtlMutasi->ovoTrf('detail','nomor tujuan','jumlah trf','pin','deskripsi')); // Melihat detail transfer OVO to OVO
// print json_encode($AtlMutasi->ovoTrf('transfer','nomor tujuan','jumlah trf','pin','deskripsi')); // Melakukan transfer OVO to OVO

// print json_encode($AtlMutasi->ovoTrfBank('detail','kode bank','nomor rekening','jumlah trf','pin','deskripsi')); // Melihat detail transfer OVO to BANK
// print json_encode($AtlMutasi->ovoTrfBank('transfer','kode bank','nomor rekening','jumlah trf','pin','deskripsi')); // Melakukan transfer OVO to BANK