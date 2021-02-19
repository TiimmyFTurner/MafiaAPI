<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Event as EventModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Event extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EventModel::with('connections')->paginate(10);
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
                    'title' => 'required',
                    'description' => 'required',
                    'location' => 'required',
                    'date' => 'required'
                ]
            );
            $event = EventModel::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'date' => $request->date,
                'user_id' => Auth::id(),
                'status' => $request->status,

            ]);
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'event' => $event
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
    public function show($filter)
    {
        return EventModel::where('location', 'LIKE', "%{$filter}%")->orWhere('title', 'LIKE', "%{$filter}%")->with('connections', 'user')->paginate(10);
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
            EventModel::find($id)->update(['status' => $request->status]);
            return response()->json([
                'status' => 200,
                'data' => ['message' => 'update saccessful'],
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in update',
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
            EventModel::find($id)->delete();
            return response()->json([
                'status' => 200,
                'data' => ['message' => 'delete saccessful'],
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in update',
                'error' => $error,
            ]);
        }
    }
}
