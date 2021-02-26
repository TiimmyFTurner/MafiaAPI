<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (auth()->id() == $id) {
            return response()->json([
                'status' => 200,
                'data' => ['user' => User::find($id)],
            ]);
        } else
            abort(403, 'Access Denied');
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
        try {
            if (auth()->id() == $id) {
                $request->validate(['name' => 'required']);
                User::find($id)->update(['name' => $request->name]);
                return response()->json([
                    'status' => 200,
                    'message' => 'user updated',
                    'data' => ['user' => User::find($id)],
                ]);
            } else
                abort(403, 'Access Denied');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'error in updating user',
                'error' => $th
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
            if (auth()->id() == $id) {
                User::destroy($id);
                return response()->json([
                    'status' => 200,
                    'message' => 'user deleted',
                ]);
            } else
                abort(403, 'Access Denied');
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'error on deleting user',
                'error' => $th
            ]);
        }
    }
}
