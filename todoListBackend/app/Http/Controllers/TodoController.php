<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Todo;
use App\Http\Resources\Todo as TodoResource;
use Auth;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($user_id)
    {
        
        //Get Articles
        $todos=Todo::orderBy('created_at','desc')->where('user_id',$user_id)->paginate(5);
        //Return collection of Articles in a resource
        return TodoResource::collection($todos);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo=$request->isMethod('put')?Todo::findOrFail($request->todo_id):new Todo;
        $todo->id=$request->input('todo_id');
        $todo->user_id=$request->input('user_id');
        $todo->state=$request->input('state');
        $todo->title=$request->input('title');
        $todo->body=$request->input('body');
        if($todo->save()){
            return new TodoResource($todo);
        }
    }
    public function UpdateState(Request $request)
    {
        $todo=Todo::findOrFail($request->todo_id);
        
        $todo->state=$request->input('state');
        if($todo->save()){
            return new TodoResource($todo);
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
        //Get Article
        $todo=Todo::findOrFail($id);
        //Return article as a resource
        return new TodoResource($todo);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo=Todo::findOrFail($id);
        //If we delete the info then return the article afterwards
        if($todo->delete()){
            return new TodoResource($todo);
        }
    }
    public function search($searchName)
    {
        $todos=Todo::orderBy('created_at','desc')->where('title',$searchName)->paginate(5);
        //Return collection of Articles in a resource
        return TodoResource::collection($todos);
    }
    public function searchAllDone($user_id)
    {
        $todos=Todo::orderBy('created_at','desc')->where('state',true)->where('user_id',$user_id)->paginate(5);
        //Return collection of Articles in a resource
        return TodoResource::collection($todos);
    }
    public function searchAllNotYet($user_id)
    {
        $todos=Todo::orderBy('created_at','desc')->where('state',false)->where('user_id',$user_id)->paginate(5);
        //Return collection of Articles in a resource
        return TodoResource::collection($todos);
    }
}
