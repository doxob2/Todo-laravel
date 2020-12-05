<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(){
        return view('main');
    }

    public function addTodo(Request $request){
        $todo = new Todo();
        $todo->Task = $request->title;
        $todo->Description = $request->description;
        $todo->Priority = $request->priority;
        $todo->save();
        return 'OK!';
    }

    public function getTodo(){
        $data = [];
        $todos = Todo::all();
        foreach ($todos as $value) {
            $temp=[];
            $temp[]=$value->id;
            $temp[]=$value->Task;
            $temp[]=$value->Description;
            $temp[]=$value->Priority;
            $temp[]=$value->updated_at->format('m-d H:i');
            $temp[]=$value->Status;
            

            $data[]=$temp;
        }
        return array_reverse($data);
    }

    public function deleteTodo(Request $request){
        $todo = Todo::find($request->id);
        $todo->delete();

        return 'Record Deleted';
    }

    public function completeTodo(Request $request){
        $todo = Todo::find($request->id);
        $todo->Status = 1;
        $todo->save();
        return $todo;

    }
}
