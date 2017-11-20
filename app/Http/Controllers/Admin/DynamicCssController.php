<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DynamicCssController extends Controller
{

    /**
     * Get current custom-css data from json file.
     *
     * @return \Illuminate\Http\Response|null
     */

    public function get()
    {
        if (Storage::disk('local')->exists('custom_css/css.json') == false){

            return null;

        } else {

            $css = json_decode(Storage::get('custom_css/css.json'), true);

            return response()->view('css.custom', ['css' => $css], 200, ['Content-Type' => 'text/css']);
        }
    }

    /**
     * Getting custom css parameters from admin panel,
     * and storing in json file.
     *
     * @param Request $css
     * @return \Illuminate\Http\RedirectResponse
     */

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
                'selector'  => ['required', Rule::notIn(['body', '.nav-color'])],
                'css' => 'required'
            ]);

            $css = $css->except(['_token']);
            $native[$css['selector']] = $css['css'];
            if (Storage::disk('local')->exists('custom_css/css.json')) {
                $text = json_decode(Storage::get('custom_css/css.json'), true);
                Storage::put('custom_css/css.json', json_encode(array_merge($text, $native)));
            } else {
                Storage::put('custom_css/css.json', json_encode($native));
            }


        }

        return redirect()->back();
    }

    /**
     * Deleting custom css file.
     *
     * @param Request $css
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Request $css)
    {
        if($css->reset == 1){

            Storage::disk('local')->delete('custom_css/css.json');
        }

        return redirect()->back();
    }
}
