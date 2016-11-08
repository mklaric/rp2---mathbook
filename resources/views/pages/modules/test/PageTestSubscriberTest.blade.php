@extends('layouts.gui', ['name' => $page->name])
@section('content')
<div class="container">
<h1> {{ $page->name }} - assignment generated</h1>
<p>Uploaded files must be in .zip format, otherwise they will not be stored in database.</p>
<div class="row">
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading">Upload form</div>
            <div class="panel-body">
                <ul class="list-group">
                @foreach($tasks as $task)
                    <li class="list-group-item">
                        <div class="markdown">
<p>Task:</p>
{{ $task->content }}
                        </div>
                        <form action="/pages/{{ $page->id }}/test/addFile" method="post" enctype="multipart/form-data" class="form-inline" role="form">
                            {{ csrf_field() }}
                            
                            <input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
                            <input name="test_id" type="hidden" class="form-control" value="{{ $module->id }}">
                            <input name="task_id" type="hidden" class="form-control" value="{{ $task->id }}">
                            <input type="file" name="filefield">
                            <button type="submit" class="btn btn-primary">Upload File</button>
                        </form>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</div>


@endsection
