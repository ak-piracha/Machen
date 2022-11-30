<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindToDoRequest;
use App\Http\Requests\StoreToDoRequest;
use App\Http\Resources\ToDoResource;
use App\Models\Status;
use App\Models\ToDo;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ToDoResource::collection(
            ToDo::where('user_id', Auth::user()->id)->get(),
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreToDoRequest $request)
    {
        $request->validated($request->all());

        $todo = ToDo::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 2,
        ]);

        return new ToDoResource($todo);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($input)
    {
        $todo = ToDo::where([
            'title' => $input,
        ])->first();

        return $this->isNotAuthorized($todo) ? $this->isNotAuthorized($todo) : new ToDoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ToDo $todo)
    {
        if (Auth::user()->id !== $todo->user_id) {
            return $this->error('', 'Unauthorized...', 403);
        };

        $todo->update($request->all());

        return new ToDoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ToDo $todo)
    {
        return $this->isNotAuthorized($todo) ? $this->isNotAuthorized($todo) :  $todo->delete();
    }

    //Check User Access
    private function isNotAuthorized($todo)
    {
        if (Auth::user()->id !== $todo->user_id) {
            return $this->error('', 'Unauthorized...', 403);
        };
    }
}
