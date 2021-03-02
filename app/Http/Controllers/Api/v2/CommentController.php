<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required',
                'body' => 'required'

            ]);
            $comment = Comment::create([
                'body' => $request->body,
                'event_id' => $request->event_id,
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'connection' => $comment
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in store',
                'error' => $th,
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (auth()->id() == Comment::find($id)->user_id) {
                Comment::find($id)->delete();
                return response()->json([
                    'status' => 200,
                    'data' => ['message' => 'delete saccessful'],
                ]);
            } else abort(403, 'Access Denied');
        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in delete',
                'error' => $error,
            ]);
        }
    }
}
