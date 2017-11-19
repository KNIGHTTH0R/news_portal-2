<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $right = Advertisement::where('block_side', 'right')->get();
        $left = Advertisement::where('block_side', 'left')->get();


        return view('admin.advertisement.index', compact('left', 'right'));
    }

    /**
     * @param $side
     * @param $position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($side, $position)
    {
        return view('admin.advertisement.create', compact('side', 'position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        $adv = Advertisement::where('block_position', $request->block_position)
                            ->where('block_side', $request->block_side)
                            ->get();
        try {

            if ($adv->isEmpty()){

                Advertisement::create($request->except('_token'));
            } elseif ($adv->isEmpty()){
                dd($adv);
            }



        } catch (\Exception $e){

            session()->flash('flash_message', 'Что-то пошло не так, попробуйте еще раз!');

            return back()->withInput();
        }

        return redirect()->action('Admin\AdvertisementController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(Advertisement $advertisement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Advertisement $advertisement)
    {
        $advertisement = $advertisement->find($id);

        if(is_null($advertisement)){
            return abort(404);
        }

        return view('admin.advertisement.edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update($id, AdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement = $advertisement->find($id);
        if (is_null($advertisement)){

            session()->flash('flash_message_error', 'Объявление не найдено');

            return redirect()->back()->withInput();
        }
        $advertisement->fill($request->except(['_token']));
        $advertisement->save();

        return redirect()->action('Admin\AdvertisementController@index');
    }

    /**
     * @param $id
     * @param Advertisement $advertisement
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id, Advertisement $advertisement)
    {
        try {

            $advertisement->destroy($id);
        } catch (\Exception $e){

             return response('', 422);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }
}
