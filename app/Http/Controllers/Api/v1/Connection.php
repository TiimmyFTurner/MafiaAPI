<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Connection as ConnectionModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Connection extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
                    'value' => 'required',

                ]
            );
            $connection = ConnectionModel::create([
                'type' => $request->type,
                'value' => $request->value,
                'user_id' => Auth::id(),
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            ConnectionModel::find($id)->delete();
            return response()->json([
                'status' => 200,
                'data' => ['message' => 'delete saccessful'],
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in delete',
                'error' => $error,
            ]);
        }
    }
}
