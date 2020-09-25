<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function index()
    {
        //タスク一覧表示
        $tasks = Task::all();
        
        //タスク一覧ビューでそれを表示
        return view('tasks.index',[
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    public function store(Request $request)
    {
        //タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->save();
        
        //トップページへリダイレクト
        return redirect('/');
    }

    public function show($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク詳細でそれを表示
        return view('tasks.show', [
            'task' => $task,    
        ]);
    }

    public function edit($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, $id)
    {
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        //メッセージを取得
        $task->content = $request->content;
        $task->save();
    }

    public function destroy($id)
    {
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        //メッセージを削除
        $task->delete();
        
        //トップページへリダイレクトさせる
        return redirect('/');
    }
}
