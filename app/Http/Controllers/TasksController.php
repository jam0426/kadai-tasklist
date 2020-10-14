<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
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
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);

        //タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = $request->user()->id;
        $task->save();
        
        //前のURLへリダイレクト
        return redirect('/');
    }

    public function show($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 関係するモデルの件数をロード
        $user->loadRelationshipCounts();

        // ユーザの投稿一覧を作成日時の降順で取得
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

        // ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user' => $user,
            'tasks' => $tasks,
        ]);
    }

    public function edit($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        $data = [];
        if (\Auth::check()) {  //認証済みの場合
            // 認証済みのユーザを取得
            $user = \Auth::user();
            
            $task = Task::findOrFail($id);
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
            
            
            return redirect('/');
        }
        //Welcomビューでそれらを表示
        return view('welcome', $data);
    }

    public function destroy($id)
    {
        //idの値でメッセージを検索して取得
        $task = \App\Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        //前のURLへリダイレクト
        return back();
    }
}
