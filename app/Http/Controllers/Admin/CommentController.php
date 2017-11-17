<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function rate_up(Request $request, Comment $comment)
    {
        if(!Auth::check()){
            return response('Unauthorized', 401);
        }

        $comment = $comment->find($request->comment_id);

        try {

            $comment->rated_user()->attach(Auth::user()->id, ['rate' => 1]);

        } catch (\Exception $e){
//            print_r(Auth::user()->rated_up->where('pivot.comment_id', $request->comment_id)->toArray());die;
            if (Auth::user()->rated_up->where('pivot.comment_id', $request->comment_id)->isNotEmpty()){

                $comment->rated_user()->detach(Auth::user()->id);

            } else {

                $comment->rated_user->where('pivot.user_id', Auth::user()->id)->first()->pivot->rate = 1;
                $comment->rated_user->where('pivot.user_id', Auth::user()->id)->first()->pivot->save();

            }
        }

        $rate = $this->refresh_rates($comment);

        $data = $request->except(['_token']);
        $data['user'] = Auth::user()->name;
        $data['rate'] = $rate;

        return json_encode($data);
    }

    public function rate_down(Request $request, Comment $comment)
    {
        if(!Auth::check()){
            return response('Unauthorized', 401);
        }

        $comment = $comment->find($request->comment_id);

        try {

            $comment->rated_user()->attach(Auth::user()->id, ['rate' => 0]);

        } catch (\Exception $e){

            if (Auth::user()->rated_down->where('pivot.comment_id', $request->comment_id)->isNotEmpty()){

                $comment->rated_user()->detach(Auth::user()->id);

            } else {
//                print_r($comment->rated_user->where('pivot.user_id', Auth::user()->id)->toArray());die;
                $comment->rated_user->where('pivot.user_id', Auth::user()->id)->first()->pivot->rate = 0;
                $comment->rated_user->where('pivot.user_id', Auth::user()->id)->first()->pivot->save();

            }
        }

        $rate = $this->refresh_rates($comment);

        $data = $request->except(['_token']);
        $data['user'] = Auth::user()->name;
        $data['rate'] = $rate;

        return json_encode($data);
    }

    private function refresh_rates($comment)
    {
            $rate['down'] = count($comment->rated_down);

            $comment->rate_down = $rate['down'];
            $comment->save();

            $rate['up'] = count($comment->rated_up);

            $comment->rate_up = $rate['up'];
            $comment->save();

            return $rate;

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function set(CommentRequest $request, Comment $comment)
    {
        try {

            $id = $comment->create([
                'body'      => $request->comment,
                'user_id'   => Auth::user()->id,
                'news_id'   => $request->news_id,
                'parent_id' => $request->parent_id
            ])->id;

            if (News::find($request->news_id)->category->protected){
                $comment = $comment->find($id);
                $comment->allowed = 0;
                $comment->save();
            }


        } catch (\Exception $e){
            return response('', 500);

        }


        return response(json_encode([
                                    'comment'    => $request->comment,
                                    'comment_id' => $id,
                                    'parent_id'  => $request->parent_id,
                                    'user_name'  => Auth::user()->name,
                                    'time'       => Carbon::now()->diffForHumans()
                                    ]),200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(CommentRequest $request,Comment $comment)
    {
        try {
            $comment = $comment->find($request->comment_id);
            if(Auth::user()->id != $comment->user->id){

                throw new \Exception('Кибер-полиция уже выехала за тобой');

            }
            if (Carbon::parse($comment->created_at)->addMinute() < Carbon::now()){

                throw new \Exception('timeout, you can\'t modify message');

            }

            $comment->body = $request->comment;
            $comment->save();

        } catch (\Exception $e){

            return response($e->getMessage(), 500);
        }

        return response(json_encode([
            'text' => $request->comment,
            'comment_id' => $request->comment_id,
            'action'  => 'edit'
        ]),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Comment $comment)
    {
        $comment = $comment->find($id);

        if ($comment->child->isEmpty()) {
            $comment->destroy($id);
        } else {
            $comment->delete($id);
        }

        return response('ok', 200);
    }
}