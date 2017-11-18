<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class CssEditorController extends Controller
{
    /**
     * If json file with custom css not exists - creating it.
     *
     * Setting background color to Html body or nav.
     *
     * Names and hex-values storing in .json,
     * chosen color of body or nav storing in .json, too.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {

        if (Storage::disk('local')->exists('custom_css/colors.json') == true) {

            $colors = json_decode(Storage::disk('local')->get('custom_css/colors.json'), true);

            if (Storage::disk('local')->exists('custom_css/css.json') == true) {

                $chosen = json_decode(Storage::disk('local')->get('custom_css/css.json'), true);

                isset($chosen['body'])?
                    $active['body'][$chosen['body']['background-color']] = $colors[$chosen['body']['background-color']]:
                    $active['body'] = [];

                isset($chosen['.nav-color'])?
                    $active['nav'][$chosen['.nav-color']['background-color']] = $colors[$chosen['.nav-color']['background-color']]:
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
