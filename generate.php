<?php
if(!isset($_SESSION)) session_start();

if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once('libs/wideimage-11.02.19-full/demo/helpers/common.php');
require_once('libs/wideimage-11.02.19-full/lib/WideImage.php');

require_once('libs/image-generator/ImageGenerator.php');

//$igc = new ImageGeneratorClass();

$sent = 0;
$img_sizes = array();
$custom_size = $retina = $compress = $separate_folders = null;

if(isset($_POST['ajax_submit'])) {
    $sent = 1;
    extract($_POST);

    //    echo "<pre>";
    //    print_r($_POST);
    //    echo "</pre>";

    if(isset($_SESSION['uploaded_files'])) {
        if($result = ImageGenerator::process_images($_SESSION['uploaded_files'])) {
            echo $result;
            die();
        }

//        if(count($_SESSION['uploaded_files']) > 1) {
//            for($i = 0; $i < count($_SESSION['uploaded_files']); $i++) {
//                ImageGenerator::process_images($_SESSION['uploaded_files'][$i]);
//            }
//        }
//        else {
//            ImageGenerator::process_images($_SESSION['uploaded_files'][0]);
//        }
        //        unset($_SESSION['uploaded_files']);
    }

//    echo json_encode($_POST);
}

$retina_on = !$sent || (isset($retina) && $retina);
$compress_on = !$sent || (isset($compress) && $compress);
$separate_on = !$sent || (isset($separate_folders) && $separate_folders);

?>