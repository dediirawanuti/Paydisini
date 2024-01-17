<?php 
require '../../connect.php';
require _DIR_('library/session/session');
require 'gnc.php';

function err($x,$y) {
    if($x == true) {
        return json_encode(['result' => true,'data' => $y]);
    } else {
        return json_encode(['result' => false,'message' => $y]);
    }
}

$GameNC = new GameNickChecker(conf('atlantic-cfg',1), conf('atlantic-cfg',2));
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && isset($data_user)) {
    if(!isset($_POST['target']) || !isset($_POST['category'])) exit(err(false,'No direct script access allowed!'));
    
    $c = isset($_POST['category']) ? filter($_POST['category']) : '';
    $id = isset($_POST['target']) ? filter($_POST['target']) : '';
    $id2 = isset($_POST['target2']) ? filter($_POST['target2']) : '';
    
    if($c == "Free Fire") $result = $GameNC->FreeFire($id);
    else if($c == "PB Zepetto") $result = $GameNC->pointblank($id);
    else if($c == "Mobile Legends") $result = $GameNC->MobileLegends($id,$id2);
    else if($c == "Mobile Legends A") $result = $GameNC->MobileLegends($id,$id2);
    else if($c == "Mobile Legends B") $result = $GameNC->MobileLegends($id,$id2);
    else if($c == "HAGO") $result = $GameNC->HAGO($id);
    else if($c == "Call of Duty Mobile") $result = $GameNC->CallOfDuty($id);
    else if($c == "LifeAfter") $result = $GameNC->LifeAfter($id);
    else if($c == "Light of Thel") $result = $GameNC->LightofThel($id);
    else if($c == "Dragon Raja") $result = $GameNC->DragonRaja($id);
    else if($c == "Lords Mobile") $result = $GameNC->LordsMobile($id);
    else if($c == "Ragnarok M Eternal Love") $result = $GameNC->RagnarokEternalLove($id);
    else if($c == "UC PUBGM") $result = $GameNC->PUBG($id);
    else if($c == "World of Dragon Nest") $result = ['result' => true,'data' => ['name' => '']];
    else if($c == "Valorant") $result = $GameNC->Valorant($id);
    else exit(err(false,'The game is not registered, please contact the developer!'));
    
    if(isset($result['result'])) {
        if($result['result'] == true) {
            if(isset($result['data']['name'])) {
                exit(err(true,$result['data']['name']));
            } else {
                exit(err(false,'Player not found!'));
            }
        } else {
            exit(err(false,$result['message']));
        }
    } else {
        exit(err(false,'Connection Failed!'));
    }
} else {
	exit(err(false,'No direct script access allowed!'));
}