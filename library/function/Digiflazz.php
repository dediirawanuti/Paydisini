<?php
class DigiFlazz
{
    private $base = 'https://api.digiflazz.com/v1';
    private $refId;
    private $user;
    private $key;
    
    public function __construct($punten) {
        $this->refId = (isset($punten['refId'])) ? $punten['refId'] : 'SHENN-'.rand(000000,999999).'AIY';
        $this->user = $punten['username'];
        $this->key = $punten['apikey'];
    }

    public function CheckBalance() {
        $data = $this->connect($this->base.'/cek-saldo',['Content-Type: application/json'],json_encode([
            'cmd' => 'deposit',
            'username' => $this->user,
            'sign' => md5($this->user.$this->key.'depo')
        ]))['data'];
        
        if(isset($data['message'])) {
            return ['result' => false,'data' => null,'message' => $data['message']];
        } else if($data == null) {
            return ['result' => false,'data' => null,'message' => 'Failed to get balance information.'];
        } else {
            return ['result' => true,'data' => ['balance' => $data['deposit']],'message' => 'Balance information successfully obtained.'];
        }
    }
    
    public function PriceList() {
        $data['prepaid'] = $this->connect($this->base.'/price-list',['Content-Type: application/json'],json_encode([
            'cmd' => 'prepaid',
            'username' => $this->user,
            'sign' => md5($this->user.$this->key.$this->refId)
        ]))['data'];
        $data['postpaid'] = $this->connect($this->base.'/price-list',['Content-Type: application/json'],json_encode([
            'cmd' => 'pasca',
            'username' => $this->user,
            'sign' => md5($this->user.$this->key.$this->refId)
        ]))['data'];
        
        if(isset($data['prepaid']['message'])) {
            return ['result' => false,'data' => null,'message' => $data['prepaid']['message']];
        } else if($data['prepaid'] == null) {
            return ['result' => false,'data' => null,'message' => 'Failed to get service data.'];
        } else {
            for($i = 0; $i <= count($data['prepaid'])-1; $i++) {
                $status = $data['prepaid'][$i]['buyer_product_status'] == true ? 'available' : 'empty';
                $out[] = [
                    'name' => ucwords($data['prepaid'][$i]['product_name']),
                    'note' => $data['prepaid'][$i]['desc'],
                    'code' => $data['prepaid'][$i]['buyer_sku_code'],
                    'type' => 'Prepaid',
                    'brand' => strtoupper($data['prepaid'][$i]['brand']),
                    'price' => $data['prepaid'][$i]['price'],
                    'multi' => $data['prepaid'][$i]['multi'],
                    'status' => $data['prepaid'][$i]['seller_product_status'] == true ? $status : 'empty',
                    'cut_off' => [
                        'start' => $data['prepaid'][$i]['start_cut_off'],
                        'end' => $data['prepaid'][$i]['end_cut_off']
                    ],
                    'category' => strtoupper($data['prepaid'][$i]['category']),
                    'subcategory' => $data['prepaid'][$i]['type']
                ];
            }
            
            for($i = 0; $i <= count($data['postpaid'])-1; $i++) {
                $status = ($data['postpaid'][$i]['buyer_product_status'] == true) ? 'available' : 'empty';
                $price = ($data['postpaid'][$i]['admin'] < 1) ? '0' : $data['postpaid'][$i]['admin']-$data['postpaid'][$i]['commission'];
                $out[] = [
                    'name' => ucwords($data['postpaid'][$i]['product_name']),
                    'note' => '',
                    'code' => $data['postpaid'][$i]['buyer_sku_code'],
                    'type' => 'Postpaid',
                    'brand' => strtoupper($data['postpaid'][$i]['brand']),
                    'price' => ($data['postpaid'][$i]['admin'] < 1) ? '0' : $data['postpaid'][$i]['admin']-$data['postpaid'][$i]['commission'],
                    'multi' => false,
                    'status' => $data['postpaid'][$i]['seller_product_status'] == true ? $status : 'empty',
                    'cut_off' => [
                        'start' => '',
                        'end' => ''
                    ],
                    'category' => strtoupper($data['postpaid'][$i]['category']),
                    'subcategory' => 'Pascabayar'
                ];
            }
            return ['result' => true,'data' => $out,'message' => 'Service Data successfully obtained.'];
        }
    }

    public function Topup($id,$target,$reff) {
        $data = $this->connect($this->base.'/transaction',['Content-Type: application/json'],json_encode([
            'username' => $this->user,
            'buyer_sku_code' => $id,
            'customer_no' => $target,
            'ref_id' => $reff,
            'sign' => md5($this->user.$this->key.$reff),
            'msg' => ''
        ]))['data'];
        
        if($data['status'] == 'Gagal') {
            return ['result' => false,'data' => null,'message' => $data['message']];
        } else if(in_array($data['status'],['Sukses','Pending'])) {
            return ['result' => true,'data' => [
            	'trxid' => $data['ref_id'],
            	'price' => $data['price'],
            	'status' => $data['status'] == 'Sukses' ? 'success' : 'waiting',
            	'balance' => $data['buyer_last_saldo']
            ],'message' => $data['sn'] !== '' ? $data['sn'] : $data['message']];
        } else {
            return ['result' => false,'data' => null,'message' => $data['message']];
        }
    }
    
    public function CheckTopup($id,$target,$refId) {
        if($refId == '') return ['result' => false,'data' => null,'message' => 'RefID is empty.'];
        $data = $this->connect($this->base.'/transaction',['Content-Type: application/json'],json_encode([
            'username' => $this->user,
            'buyer_sku_code' => $id,
            'customer_no' => $target,
            'ref_id' => $refId,
            'sign' => md5($this->user.$this->key.$refId),
            'msg' => ''
        ]))['data'];
        
        if(isset($data['ref_id']) && isset($data['status']) && isset($data['price']) && isset($data['buyer_last_saldo']) && isset($data['sn'])) {
            $status = 'waiting';
            if($data['status'] == 'Sukses') $status = 'success';
            if($data['status'] == 'Gagal') $status = 'error';
            return ['result' => true,'data' => [
            	'trxid' => $data['ref_id'],
            	'price' => $data['price'],
            	'status' => $status,
            	'balance' => $data['buyer_last_saldo']
            ],'message' => $data['sn'] !== '' ? $data['sn'] : $data['message']];
        } else {
            return ['result' => false,'data' => null,'message' => $data['message']];
        }
    }

    public function CheckBill($id,$target,$reff) {
        $data = $this->connect($this->base.'/transaction',['Content-Type: application/json'],json_encode([
            'commands' => 'inq-pasca',
            'username' => $this->user,
            'buyer_sku_code' => $id,
            'customer_no' => $target,
            'ref_id' => $reff,
            'sign' => md5($this->user.$this->key.$reff),
            'msg' => ''
        ]))['data'];
        
        if($data['status'] == 'Gagal') {
            return ['result' => false,'data' => null,'message' => $data['message']];
        } else if($data['status'] == 'Sukses') {
            return ['result' => true,'data' => [
                'trxid' => $data['ref_id'],
                'price' => $data['price'],
                'selling_price' => $data['selling_price'],
                'customer_name' => $data['customer_name'],
                'customer_no' => $data['customer_no'],
                'admin' => $data['admin'],
                'status' => $data['status'] == 'Sukses' ? 'success' : 'waiting',
                'balance' => $data['buyer_last_saldo']
            ],'message' => $data['sn'] !== '' ? $data['sn'] : $data['message']];
        } else {
            return ['result' => false,'data' => null,'message' => $data['message']];
        }
    }

    public function PayBill($id,$target,$reff) {
        $data = $this->connect($this->base.'/transaction',['Content-Type: application/json'],json_encode([
            'commands' => 'pay-pasca',
            'username' => $this->user,
            'buyer_sku_code' => $id,
            'customer_no' => $target,
            'ref_id' => $reff,
            'sign' => md5($this->user.$this->key.$reff),
            'msg' => ''
        ]))['data'];
        
        if($data['status'] == 'Gagal') {
            return ['result' => false,'data' => null,'message' => $data['message']];
        } else if($data['status'] == 'Sukses') {
            return ['result' => true,'data' => [
            	'trxid' => $data['ref_id'],
            	'price' => $data['price'],
            	'selling_price' => $data['selling_price'],
            	'customer_name' => $data['customer_name'],
            	'customer_no' => $data['customer_no'],
            	'admin' => $data['admin'],
            	'status' => $data['status'] == 'Sukses' ? 'success' : 'waiting',
            	'balance' => $data['buyer_last_saldo']
            ],'message' => $data['sn'] !== '' ? $data['sn'] : $data['message']];
        } else {
            return ['result' => false,'data' => null,'message' => $data['message']];
        }
    }
    
    // END POINT CONNECTION

    private function connect($end_point,$header,$postdata) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        $chresult = curl_exec($ch);
        return json_decode($chresult, true);
    }
}