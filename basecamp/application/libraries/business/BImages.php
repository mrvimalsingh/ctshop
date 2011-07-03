<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 7/3/11
 * Time: 6:20 PM
 * To change this template use File | Settings | File Templates.
 */

class BImages {

    /**
     * this method will read the uploaded file and store the image on the hd
     * @param $category the category the image belongs to
     * @return the image hash created for the uploaded image... or false if the upload failed.
     */
    function uploadImage($category) {

    }

    /**
     * outputs the image based on the hash and other configurations
     * if the image doesn't exist in the configuration specified it will create it
     * and if it doesn't exist at all then it will just return false... so the controller
     * calling this method will handle the situation.
     * @param $category
     * @param  $imageHash
     * @param  $x the image width
     * @param  $y the image height
     * @param  $t type of scaling (crop|fit)
     * @return void
     */
    function outputImage($category, $imageHash, $x, $y, $t) {
        // check if parameters are valid...
        if ($t != 'crop' && $t != 'fit') return false;
        if ($category == null || $category == '') return false;

        $CI = &get_instance();
        $CI->config->load('myconf');
        $base_dir = $CI->config->item("site_base_dir");
        $image_dir = $base_dir.'/uploads/images/'.$category.'/';

        $base_image_file = $image_dir.$imageHash.'.png';
        // check if the image exists (if the top level image doesn't, the other ones will not either)
        if (!file_exists($base_image_file)) return false;

        // create the image configuration string
        $img_conf = $x."x".$y.$t;
        $requested_file = $image_dir.$img_conf.'/'.$imageHash.'.png';
        // check if the folder for that configuration exists
        if (!file_exists($image_dir.$img_conf)) {
            mkdir($image_dir.$img_conf);
        }
        // check whether the image exists
        if (!file_exists($requested_file)) {
            // the image in the specified configuration does not exist we have to create it

            $CI->load->library('image_lib');

            if ($t == 'crop') {
                // create a temporary image and crop that after
                $tmp_image = $image_dir.$img_conf.'/'.$imageHash.'.tmp.png';

                //calculate image size
                $sizearr = getimagesize($base_image_file);
                $origX = $sizearr[0];
                $origY = $sizearr[1];

                $tmpX = $x;
                $tmpY = $y;
                // the smalles of the size taken as reference
                if ($origX > $origY) {
                    $r = $origX / $origY;
                    $tmpX = $r * $tmpY;
                } else {
                    $r = $origY / $origX;
                    $tmpY = $r * $tmpX;
                }

                $config['image_library'] = 'gd2';
                $config['source_image']	= $base_image_file;
                $config['maintain_ratio'] = TRUE;
                $config['width']	 = $tmpX;
                $config['height']	= $tmpY;
                $config['new_image'] = $tmp_image;

                $CI->image_lib->initialize($config);
                if (!$CI->image_lib->resize()) return false;
                $CI->image_lib->clear();

                $config['image_library'] = 'gd2';
                $config['source_image']	= $tmp_image;
                $config['width']	 = $x;
                $config['height']	= $y;
                $config['x_axis']	= ($tmpX-$x)/2;
                $config['y_axis']	= ($tmpY-$y)/2;
                $config['maintain_ratio'] = false;
                $config['new_image'] = $requested_file;

                $CI->image_lib->initialize($config);
                if (!$CI->image_lib->crop()) return false;
                unlink($tmp_image);
            } else {

                $config['image_library'] = 'gd2';
                $config['source_image']	= $base_image_file;
                $config['maintain_ratio'] = TRUE;
                $config['width']	 = $x;
                $config['height']	= $y;
                $config['new_image'] = $requested_file;

                $CI->image_lib->initialize($config);
                if (!$CI->image_lib->resize()) return false;
            }
        }

        header('Content-Type: image/png');
        readfile($requested_file);
    }

}
