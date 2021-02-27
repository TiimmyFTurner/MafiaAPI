<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use Exception;
use Illuminate\Http\Request;

class ConnectionController extends Controller
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
            $request->validate(
                [
                    'type' => 'required',
                    'value' => 'required'
                ]
            );
            $connection = Connection::create([
                'type' => $request->type,
                'value' => $request->value,
                'user_id' => auth()->id(),
            ]);
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'connection' => $connection
                ]
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in store',
                'error' => $error,
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
            if (auth()->id() == Connection::find($id)->user_id) {
                Connection::find($id)->delete();
                return response()->json([
                    'status' => 200,
                    'data' => ['message' => 'delete saccessful'],
                ]);
            } else abort(403, 'Access Denied');
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in delete',
                'error' => $error,
            ]);
        }
    }
}
