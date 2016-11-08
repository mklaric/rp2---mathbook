@extends('layouts.gui', ['name' => $page->name])
@section('content')
<div class="markdown">
<h1>{{ $page->name }} - generate assignment type</h1>
<br>
<form method="POST" action="/pages/{{ $page->id }}/test/generate">
        {{ csrf_field() }}
<div class="col-md-6">
	<label for="NumOfTasks">Number of tasks: </label>
	<input type="text" name="NumOfTasks" required/>
</div>
	<div class="col-md-2">
        <input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
        <input name="test_id" type="hidden" class="form-control" value="{{ $module->id }}">
        <button class="btn btn-block btn-success btn-sm pull-right" type="submit" name="submit">Proceed</button>
    </div>
</form>

</div>
@endsection