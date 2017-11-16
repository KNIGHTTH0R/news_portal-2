<?php
require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

// create an image manager instance with favored driver
$imgManager = new ImageManager(array('driver' => 'gd'));

// to finally create image instances
$images = scandir('storage/app/public/images/');
unset($images[0]);
unset($images[1]);
print_r( $images);
foreach ($images as $image){
    $img = $imgManager->make('storage/app/public/images/'.$image);
    echo $img->width() . PHP_EOL;
    if ($img->width() >= 1024){
        // resize the image to a width of 300 and constrain aspect ratio (auto height)
        $img->resize(900, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    $img->save('storage/app/public/images/'.$image);
}
