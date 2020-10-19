{!! Form::open(['route' => 'tasks.store']) !!}
    <div class = "form-group">
        Task:{!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '1']) !!}
        Status:{!! Form::textarea('status',old('status'),['class' => 'form-control', 'rows' => '1']) !!}</br>
        {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
    </div>
{!! Form::close() !!}