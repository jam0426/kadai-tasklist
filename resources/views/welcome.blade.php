@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <h3>{{ Auth::user()->name }}-Task</h3>
            @if (count($tasks) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Task_id</th>
                            <th>Task</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                        {{-- メッセージ詳細ページへのリンク --}}
                            <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                            <td>{{ $task->content }}</td>
                            <td>{{ $task->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {!! link_to_route('tasks.create', 'New Task', [], ['class' => 'btn btn-primary']) !!}
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Task Manager</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection