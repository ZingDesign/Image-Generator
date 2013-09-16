---
layout: default
title: Image Generator
slug: img-gen
base_url: "../"
---

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

if(isset($_POST['generate'])) {
    $sent = 1;
    extract($_POST);

//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";

    if(isset($_SESSION['uploaded_files'])) {

        if(count($_SESSION['uploaded_files']) > 1) {
            for($i = 0; $i < count($_SESSION['uploaded_files']); $i++) {
                ImageGenerator::process_images($_SESSION['uploaded_files'][$i]);
            }
        }
        else {
            ImageGenerator::process_images($_SESSION['uploaded_files'][0]);
        }
//        unset($_SESSION['uploaded_files']);
    }
}

$retina_on = !$sent || (isset($retina) && $retina);
$compress_on = !$sent || (isset($compress) && $compress);
$separate_on = !$sent || (isset($separate_folders) && $separate_folders);

?>

<main class="bs-masthead" role="main">
    <div class="container">
        <h2>The ultimate image tool for designers</h2>

        <div class="row">
            <div class="col-md-6">
                <form action="file-upload.php" class="dropzone square" id="my-awesome-dropzone">

                    <div class="fallback">
                        <input type="file" name="file" />
                    </div>

                </form>
            </div>



            <form class="col-md-6" role="form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                <p><strong>Device width(s) to support:</strong></p>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="320"<?php if(!$sent || in_array("320",$img_sizes)) echo " checked"; ?> /> 320px
                    </label>
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="480"<?php if(!$sent || in_array("480",$img_sizes)) echo " checked"; ?> /> 480px
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="720"<?php if(!$sent || in_array("720",$img_sizes)) echo " checked"; ?> /> 720px
                    </label>
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="768"<?php if(!$sent || in_array("768",$img_sizes)) echo " checked"; ?> /> 768px
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="960"<?php if(!$sent || in_array("960",$img_sizes)) echo " checked"; ?> /> 960px
                    </label>
                    <label>
                        <input type="checkbox" name="img_sizes[]" value="1200"<?php if(!$sent || in_array("1200", $img_sizes)) echo " checked"; ?> /> 1200px
                    </label>
                </div>
                <div class="form-group">
                    <label>Custom device width:</label>
                    <input type="text" name="custom_size" value="<?= $custom_size; ?>" />
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="retina" value="<?php if($retina_on) echo "1"; ?>"<?php if($retina_on) echo " checked"; ?> />
                        Retinafy
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="compress" value="<?php if($compress_on) echo "1"; ?>"<?php if ($compress_on) echo " checked"; ?> /> Compress
                    </label>
                    <a class="help-message" href="#" data-toggle="tooltip" title="Compress all uncompressed PNG and JPEG
                images">?</a>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="separate_folders" value="<?php if($separate_on) echo "1"; ?>"<?php if ($separate_on) echo " checked"; ?> /> Separate folders
                    </label>
                    <a class="help-message" href="#" data-toggle="tooltip" title="Tick this box if you would
                    like all your images in separate folders with names based on their image width">?</a>
                </div>
                <p>
                    <button type="button" class="btn btn-default" name="preview" value="0">Preview</button>
                    <button type="submit" class="btn btn-primary" name="generate" value="1">Generate!</button>
                </p>

            </form>

        </div> <!-- .row -->

        <div class="row">
            <div id="preview-box" class="col-md-12">

            </div> <!-- #preview-box -->
        </div> <!-- .row -->


    </div> <!-- .container -->

</main>
