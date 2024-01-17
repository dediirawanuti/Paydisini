<?php
class GameNickChecker
{
    private $id;
    private $key;
    
    public function __construct($id,$key) {
        $this->id = $id;
        $this->key = $key;
    }
    
    public function RagnarokEternalLove($id) {
        return $this->connectPost(['game' => 'Ragnarok','id' => $id]);
    }
    
    public function MobileLegends($id,$zone) {
        return $this->connectPost(['game' => 'Mobile Legends','id' => $id,'zone' => $zone]);
    }
    
    public function ArenaOfValor($id) {
        return $this->connectPost(['game' => 'Arena of Valor','id' => $id]);
    }
    
    public function CrisisAction($id,$zone = '211104') {
        return $this->connectPost(['game' => 'CrisisAction','id' => $id,'zone' => $zone]);
    }
    
    public function SpeedDrifters($id) {
        return $this->connectPost(['game' => 'Speed Drifters','id' => $id]);
    }
    
    public function HAGO($id) {
        return $this->connectPost(['game' => 'HAGO','id' => $id]);
    }
    
    public function FreeFire($id) {
        return $this->connectPost(['game' => 'Free Fire','id' => $id]);
    }
    
    public function CallOfDuty($id) {
        return $this->connectPost(['game' => 'Call of Duty Mobile','id' => $id]);
    }
    
    public function LifeAfter($id,$zone = '211104') {
        return $this->connectPost(['game' => 'Life After','id' => $id,'zone' => $zone]);
    }
    
    public function PUBG($id) {
        return $this->connectPost(['game' => 'PUBG Mobile','id' => $id]);
    }
    
    public function PUBGLite($id) {
        return $this->connectPost(['game' => 'PUBG Mobile Lite','id' => $id]);
    }
    
    public function ChessRush($id) {
        return $this->connectPost(['game' => 'ChessRush','id' => $id]);
    }
    
    public function PointBlank($id) {
        return $this->connectPost(['game' => 'Point Blank','id' => $id]);
    }
    
    public function LightofThel($id) {
        return $this->connectPost(['game' => 'Light of Thel','id' => $id]);
    }
    
    public function Valorant($id) {
        return $this->connectPost(['game' => 'Valorant','id' => $id]);
    }
    
    public function LordsMobile($id) {
        return $this->connectPost(['game' => 'Lords Mobile','id' => $id]);
    }
    
    public function DragonRaja($id) {
        return $this->connectPost(['game' => 'Dragon Raja','id' => $id]);
    }
    
    public function LaplaceM($id) {
        return $this->connectPost(['game' => 'Laplace M','id' => $id]);
    }
    
    // END POINT CONNECTION
    
    public function connectPost($postdata,$reqout = 'decode') {
        $end_point = 'https://atlantic-group.co.id/api/v1/game-validation';
        $postdata['key'] = $this->key;
        $postdata['sign'] = md5($this->id.$this->key);
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
}