<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;

class UploadImageController extends Controller
{


    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }



    public static function uploadImage(UploadedFile $image)
    {
        $extensionAllowed = ['png', 'jpeg', 'jpg'];
        if($image->isValid()) {
            if(in_array($image->extension(), $extensionAllowed)) {
                $image->store('public/images');

                return 'storage/images/' . $image->hashName();
            }
        }

    }
}
