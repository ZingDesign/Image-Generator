<?php
//ini_set("memory_limit","12M");

class ImageGenerator {

    static function process_images($image) {
//        if(!isset($_POST)) {
//            return false;
//        }

        $temp_folder_name = "temp";

        $img_sizes = $compress = $retina = $temp_filepath = $new_img_size_folder = $new_retina_folder = null;
        extract($_POST);

        $is_retina = isset($retina) && $retina;

        $filename = $image["filename"];
        $filepath = $image["filepath"];

        $image_size = getimagesize(dirname(__FILE__) .DS.'..'.DS.'..'.DS.$filepath);
        $image_width = $image_size[0];
        unset($image_size);

        $temp_folder = date('Y-m-d-Hi') . '_' .uniqid();

        $temp_directory = '..' . DS . $temp_folder_name;
        if(!is_dir($temp_directory)) {
            mkdir($temp_directory);
        }

        $temp_output_path = '..' . DS . $temp_folder_name . DS . $temp_folder;

        if(!is_dir($temp_output_path)) {
            mkdir($temp_output_path);
        }
        $png_comp = isset($compress) ? 9 : 0;
        $jpg_comp = isset($compress) ? 60 : 100;

        $is_png = preg_match('/.png/i', $filename);
        $is_jpeg = preg_match('/.jpeg|.jpg/i', $filename);

        $load_image = WideImage::load($filepath);

        if( !empty($img_sizes) && is_array($img_sizes) ) {
            foreach($img_sizes as $img_size) {
                if($image_width > $img_size) {
                    $new_img_size_folder = $temp_output_path . DS . $img_size;
                    if(isset($separate_folders)) {
                        if(!is_dir($new_img_size_folder)) {
                            mkdir($new_img_size_folder);
                        }
                        $temp_filepath = $new_img_size_folder . DS . $filename;
                    }
                    else {
                        $temp_filepath = $temp_output_path . DS . $filename;
                    }

                    if($is_jpeg) {
                        $temp_filepath = preg_replace('/.jpeg|.jpg/i', '_'.$img_size.'$0', $temp_filepath);
                        $resized = $load_image->resize($img_size);
                        $resized->saveToFile($temp_filepath, $jpg_comp);
                        unset($resized);
                    }
                    else if($is_png) {
                        $temp_filepath = str_replace('.png', '_'.$img_size.'.png', $temp_filepath);
                        $resized = $load_image->resize($img_size);
                        $resized->saveToFile($temp_filepath, $png_comp);
                        unset($resized);
                    }
                }
            }
            unset($new_img_size_folder, $img_size);
        }

        if($is_retina) {
            $new_retina_folder = $temp_output_path . DS . "retina";
            if(!is_dir($new_retina_folder)) {
                mkdir($new_retina_folder);
            }
            $temp_filepath_retina = $new_retina_folder . DS . preg_replace('/.jpg|.jpeg|.png/i', '_retina$0', $filename);

            if($is_jpeg) {
                $load_image->saveToFile($temp_filepath_retina, 20);
                $resized = WideImage::load($temp_filepath_retina)->resize("200%");
                $resized->saveToFile($temp_filepath_retina);
                unset($resized);
            }
            else if($is_png) {
                $load_image->saveToFile(preg_replace("/.png/i", "@2x$0", $temp_filepath_retina), $png_comp);
                $resized = $load_image->resize("50%");
                $resized->saveToFile($temp_filepath_retina, $png_comp);
                unset($resized);
            }
            unset($new_retina_folder);
        }

        unset($load_image, $filename, $filepath, $image_width, $img_sizes, $compress, $retina, $is_png, $is_jpeg,
        $jpg_comp, $png_comp, $temp_output_path, $temp_directory, $temp_filepath, $temp_filepath_retina, $temp_folder);

        return true;
    }
}