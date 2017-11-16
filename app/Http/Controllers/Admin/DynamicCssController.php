<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DynamicCssController extends Controller
{
    public function get()
    {

        if (Storage::disk('local')->exists('custom_css/css.json') == false){

            return null;
        } else {

            $css = json_decode(Storage::get('custom_css/css.json'), true);

            return response()->view('css.custom', ['css' => $css], 200, ['Content-Type' => 'text/css']);
        }
    }

    public function post(Request $css)
    {

        if (!$css->native) {

            $css->validate([
                'nav'  => 'sometimes|required',
                'body' => 'sometimes|required'
            ]);

            $css = $css->except(['_token']);

            if (isset($css['nav'])){

                $css['.nav-color'] = $css['nav'];
                unset($css['nav']);
            }

            if (Storage::disk('local')->exists('custom_css/css.json') == false) {

                Storage::put('custom_css/css.json', json_encode($css));
            } else {

                $text = json_decode(Storage::get('custom_css/css.json'), true);

                Storage::put('custom_css/css.json', json_encode(array_merge($text, $css)));
            }
        } else {

            $css->validate([
                'selector'  => 'required',
                'css' => 'required'
            ]);

            $css = $css->except(['_token']);

            $native[$css['selector']] = $css['css'];

            $text = json_decode(Storage::get('custom_css/css.json'), true);

            Storage::put('custom_css/css.json', json_encode(array_merge($text, $native)));
        }

        return redirect()->back();
    }

    public function destroy(Request $css)
    {
        if($css->reset == 1){

            Storage::disk('local')->delete('custom_css/css.json');
        }

        return redirect()->back();
    }
}
