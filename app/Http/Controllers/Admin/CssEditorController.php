<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class CssEditorController extends Controller
{
    public function index()
    {

        if (Storage::disk('local')->exists('custom_css/colors.json') == true) {

            $colors = json_decode(Storage::disk('local')->get('custom_css/colors.json'), true);

            if (Storage::disk('local')->exists('custom_css/css.json') == true) {
                $choosen = json_decode(Storage::disk('local')->get('custom_css/css.json'), true);
                isset($choosen['body'])?
                    $active['body'][$choosen['body']['background-color']] = $colors[$choosen['body']['background-color']]:
                    $active['body'] = [];
                isset($choosen['.nav-color'])?
                    $active['nav'][$choosen['.nav-color']['background-color']] = $colors[$choosen['.nav-color']['background-color']]:
                    $active['nav'] = [];
            } else {

                $active['body'] = [];
                $active['nav'] = [];
            }



        } else {
            $colors[] = [];
            $active['body'] = null;
            $active['nav'] = null;
        }

        return view('admin.css-editor', ['title' => 'Admin panel', 'colors' => $colors, 'active' => $active]);
    }
}
