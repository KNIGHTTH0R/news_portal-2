<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
class UploadImageController extends Controller
{
    /**
     * Store a newly uploaded image file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {

            $link = self::uploadImage($request->image);
            $link = url('/').'/' . $link;

            return response()
                ->json(['link' => $link], 200, [], JSON_UNESCAPED_SLASHES);
        }
    }

    /**
     * trying to store image, if validate will be successful
     *
     * @param UploadedFile $image
     * @param bool $title
     * @return bool|string
     */

    public static function uploadImage(UploadedFile $image, $title = false)
    {
        $extensionAllowed = ['png', 'jpeg', 'jpg'];

        if($image->isValid()) {
            if (in_array($image->extension(), $extensionAllowed)) {

                $image->store('public/images');
                $img = Image::make($image);

                if ($title != true) {

                    if ($img->width() > 800) {
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    if ($img->height() > 550) {
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize(null, 550, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                } else {

                    $img->resize(1100, 550);
                }

                $img->save('storage/images/' . $image->hashName());

                return 'storage/images/' . $image->hashName();

            } else {

                return false;
            }
        }
    }
}
