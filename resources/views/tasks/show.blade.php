@extends('layouts.app')

@section('content')

    <h1>Task</h1>

    <table class="table table-bordered">
        <tr>
            <th>Task_id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>Task</th>
            <td>{{ $task->content }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $task->status }}</td>
        </tr>
    </table>
    </br>
    <div class = "row">
    {{-- メッセージ編集ページへのリンク --}}
    {!! link_to_route('tasks.edit', 'Update', ['task' => $task->id], ['class' => 'btn btn-light']) !!}

    {{-- メッセージ削除フォーム --}}
    {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
    </div>
@endsection