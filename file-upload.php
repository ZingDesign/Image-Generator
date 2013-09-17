<?php
if(!isset($_SESSION)) session_start();
$ds = DIRECTORY_SEPARATOR;  //1

$storeFolder = '..'.$ds.'uploads';   //2

//$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
//$targetPath = $storeFolder . $ds;

if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetFile = $storeFolder . $ds . $_FILES['file']['name'];  //5

    move_uploaded_file($tempFile, $targetFile); //6

    $_SESSION['uploaded_files'][] = array(
        "filepath" => $targetFile,
        "filename" => $_FILES['file']['name'],
        "filetype" => $_FILES['file']['type']
    );

//    echo 1;
}

if(isset($_POST['remove_file'])) {
    //    $file_to_delete = $_POST['current_file'];

    //    echo $_POST['current_file']['remove_file'] . "\n";
    $file_to_delete = $storeFolder . $ds . $_POST['remove_file']['current_file'];
    //    echo $file_to_delete . "\n";

    //    $arr = array('nice_item', 'remove_me', 'another_liked_item', 'remove_me_also');

    $new_values = array_diff($_SESSION['uploaded_files'], array($file_to_delete));

    //    echo json_encode($new_values);

    $_SESSION['uploaded_files'] = $new_values;

    echo json_encode($_SESSION['uploaded_files']);
    die();
}
else {
    die("Restricted Access. Please turn around and go back the way you came.");
}

//if((isset($_GET) && !empty($_GET)) || (isset($_PUT) && !empty($_PUT))) {
//    die("Restricted Access. Please turn around and go back the way you came.");
//}
//die();