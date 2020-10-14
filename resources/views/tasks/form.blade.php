{!! Form::open(['route' => 'tasks.store']) !!}
    <div class = "form-group">
    {{-- タスク作成ページへのリンク --}}
    {!! link_to_route('tasks.create', 'New Task', [], ['class' => 'btn btn-primary']) !!}
    </DIV>
{!! Form::close() !!}