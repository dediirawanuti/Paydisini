<?php
if(!isset($call)) die("You cannot directly connect your application to the ShennBoku App system!<br>- Afdhalul Ichsan Yourdan");
$scan_dir = scandir(_DIR_('library/assets/banner/',''));
for($iDir = 2; $iDir < count($scan_dir); $iDir++) {
    if($scan_dir[$iDir] !== 'ShennSample-Dont-Delete-This!.jpg') {
        $dirFile = _DIR_('library/assets/banner/'.$scan_dir[$iDir],'');
        $baseFile = base_url('library/assets/banner/'.$scan_dir[$iDir]);
        if($call->query("SELECT id FROM information WHERE `type` = 'banner' AND content = '$baseFile'")->num_rows == false) {
            $metadata = exif_read_data($dirFile);
            if(is_array($metadata) && isset($metadata['COMPUTED']) && isset($metadata['MimeType'])) {
                if(in_array($metadata['MimeType'],['image/jpeg','image/jpg']) && $metadata['COMPUTED']['Width'] == 1280 && $metadata['COMPUTED']['Height'] == 500) {
                    $call->query("INSERT INTO information VALUES (null,'$date $time','banner','$baseFile')");
                }
            }
        }
    }
}


if(isset($_POST['addbanner'])) {
    $post_content = $_FILES['content'];
    $var_conType = explode('/', $post_content['type']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array(strtolower(end($var_conType)),['jpg','jpeg'])) {
        ShennXit(['type' => false,'message' => 'Invalid image format.']);
    } else if($post_content['size'] > 3000000) {
        ShennXit(['type' => false,'message' => 'Image size is too large.']);
    } else {
        $newFile = date('YmdHis').'.'.strtolower(end($var_conType));
        if(move_uploaded_file($post_content['tmp_name'], _DIR_('library/assets/banner/'.$newFile,''))) {
            ShennXit(['type' => true,'message' => 'Banner added successfully.']);
        } else {
            ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
        }
    }
} if(isset($_POST['editbanner'])) {
    $web_token = base64_decode($_POST['web_token']);
    $post_content = $_FILES['content'];
    $var_conType = explode('/', $post_content['type']);
    
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if(!in_array(strtolower(end($var_conType)),['jpg','jpeg'])) {
        ShennXit(['type' => false,'message' => 'Invalid image format.']);
    } else if($post_content['size'] > 3000000) {
        ShennXit(['type' => false,'message' => 'Image size is too large.']);
    } else if($call->query("SELECT id FROM information WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        $oldData = $call->query("SELECT * FROM information WHERE id = '$web_token'")->fetch_assoc();
        $newFile = date('YmdHis').'.'.strtolower(end($var_conType));
        $oldPic = _DIR_(str_replace(base_url(),'',$oldData['content']),'');
        
        if(file_exists($oldPic)) {
            if(unlink($oldPic)) {
                if(move_uploaded_file($post_content['tmp_name'], _DIR_('library/assets/banner/'.$newFile,''))) {
                    $call->query("UPDATE information SET content = '".base_url('library/assets/banner/'.$newFile)."' WHERE id = '$web_token'");
                    ShennXit(['type' => true,'message' => 'Banner updated successfully.'],base_url('admin/others/banner/'));
                } else {
                    ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
                }
            } else {
                ShennXit(['type' => false,'message' => 'Failed to delete old banner.']);
            }
        } else {
            if(move_uploaded_file($post_content['tmp_name'], _DIR_('library/assets/banner/'.$newFile,''))) {
                $call->query("UPDATE information SET content = '".base_url('library/assets/banner/'.$newFile)."' WHERE id = '$web_token'");
                ShennXit(['type' => true,'message' => 'Banner updated successfully.'],base_url('admin/others/banner/'));
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        }
    }
} if(isset($_POST['deletebanner'])) {
    $web_token = base64_decode($_POST['web_token']);
    if($result_csrf == false) {
        ShennXit(['type' => false,'message' => 'System Error, please try again later.']);
    } else if($_CONFIG['lock']['status'] == true) {
        ShennXit(['type' => false,'message' => $_CONFIG['lock']['reason']]);
    } else if(!in_array($data_user['level'],['Admin'])) {
        ShennXit(['type' => false,'message' => 'You do not have access to use this feature.']);
    } else if($call->query("SELECT id FROM information WHERE id = '$web_token'")->num_rows == 0) {
        ShennXit(['type' => false,'message' => 'Data not found.']);
    } else {
        $oldData = $call->query("SELECT * FROM information WHERE id = '$web_token'")->fetch_assoc();
        $oldPic = _DIR_(str_replace(base_url(),'',$oldData['content']),'');
        
        if(file_exists($oldPic)) {
            if(unlink($oldPic)) {
                if($call->query("DELETE FROM information WHERE id = '$web_token'") == true) {
                    ShennXit(['type' => true,'message' => 'Banner deleted successfully.']);
                } else {
                    ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
                }
            } else {
                ShennXit(['type' => false,'message' => 'Failed to delete old banner.']);
            }
        } else {
            if($call->query("DELETE FROM information WHERE id = '$web_token'") == true) {
                ShennXit(['type' => true,'message' => 'Banner deleted successfully.']);
            } else {
                ShennXit(['type' => false,'message' => 'Our server is in trouble, please try again later.']);
            }
        }
    }
}