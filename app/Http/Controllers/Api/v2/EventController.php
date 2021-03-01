<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filter)
            return Event::where('location', 'LIKE', "%{$request->filter}%")->orWhere('title', 'LIKE', "%{$request->filter}%")->paginate(10);
        else
            return Event::paginate(10);
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
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'date' => $request->date,
                'user_id' => auth()->id(),
                'status' => $request->status,

            ]);
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'event' => $event
                ]
            ]);
        } catch (\Exception $error) {
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
        try {
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'event' => Event::find($id)
                ]
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in get ',
                'error' => $error,
            ]);
        }
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
            if (auth()->id() == Event::find($id)->user_id) {
                Event::find($id)->update(['status' => $request->status]);
                return response()->json([
                    'status' => 200,
                    'data' => ['message' => 'update saccessful'],
                ]);
            } else abort(403, 'Access Denied');
        } catch (\Exception $error) {
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
            if (auth()->id() == Event::find($id)->user_id) {
                Event::find($id)->delete();
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

    /**
     * get the connectios of event .
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function connections($id)
    {
        // return 'hi';
        try {
            return response()->json([
                'status' => 200,
                'data' => [
                    'message' => 'saccess',
                    'event' => Event::find($id)->connections()->get()
                ]
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 500,
                'message' => 'Error in get ',
                'error' => $error,
            ]);
        }
    }
}
