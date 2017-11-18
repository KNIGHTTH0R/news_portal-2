<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentValidateController extends Controller
{
    /**
     * Display a listing of the comments
     * which are moderator verification.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('allowed', '0')->get();

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Allow one chosen comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function allow(Request $request, Comment $comment)
    {
        $request->validate([
            'comment_id' => 'required',
        ]);

        try {

            $comment = $comment->find($request->comment_id);
            $comment->allowed = 1;
            $comment->save();

        } catch (\Exception $e) {

            return response($e->getMessage(), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }

    /**
     * Allowing list of chosen comments
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function massAllow(Request $request, Comment $comment)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        $ids = json_decode($request->ids, true);

        try {

            $comment->whereIn('id', $ids)->update(['allowed' => 1]);

        } catch (\Exception $e) {

            return response($e->getMessage(), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }

    /**
     * Changing the specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'comment_id' => 'required',
            'body'       => 'required|max:255'
        ]);

        try {

            $comment = $comment->find($request->comment_id);
            $comment->body = $request->body;
            $comment->save();

        } catch (\Exception $e) {

            return response($e->getMessage(), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        $request->validate([
            'comment_id' => 'required',
        ]);

        try {

            $comment->destroy($request->comment_id);

        } catch (\Exception $e) {

            return response($e->getMessage(), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }

    /**
     * Remove the specified list of comments.
     *
     * @array  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request, Comment $comment)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        $ids = json_decode($request->ids, true);

        try {

            $comment->destroy($ids);

        } catch (\Exception $e) {

            return response($e->getMessage(), 500);
        }

        return response(json_encode(['status' => 'ok']), 200);
    }
}
