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
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            $task = new Task;
    
            // タスク作成ビューを表示
            return view('tasks.create', [
                'task' => $task,
            ]);
        }
        
        return view('welcome', $data);
    }

    public function store(Request $request)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();

            // バリデーション
            $request->validate([
                'content' => 'required|max:255',
                'status' => 'required|max:10',
            ]);
            
            $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
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
        return view('welcome', $data);
    }

    public function show($id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
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
        
        return view('welcome', $data);
    }

    public function edit($id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            
            //idの値でタスクを検索して取得
            $task = Task::findOrFail($id);
            
            //タスク編集ビューでそれを表示
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return view('welcome', $data);
        
    }

    public function update(Request $request, $id)
    {
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            //バリデーション
            $request->validate([
                'content' => 'required|max:255',
                'status' => 'required|max:10',
            ]);
            
            $data = [];
                
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
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            //idの値でメッセージを検索して取得
            $task = \App\Task::findOrFail($id);
            // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
            if (\Auth::id() === $task->user_id) {
                $task->delete();
            }
            //前のURLへリダイレクト
            return back();
        }
        return view('welcome', $data);
    }
}
