@extends('layouts.gui', ['name' => $page->name])
@section('content')
<h1>{{ $page->name }}</h1>
<div class="row">
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-heading"><p>You have successfully generated assignment. Please, click on "End" button to finish assignment and view uploaded files of subscribers.</p></div>
            <div class="panel-body">
				
					<div class="col-md-2">
						<form method="POST" action="/pages/{{ $page->id }}/test/endtest">
        					{{ csrf_field() }}
     					<input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
     					<input name="test_id" type="hidden" class="form-control" value="{{ $test->id }}">
     					<button style="float: right" type="submit" name="button" value="End" class="btn btn-danger">End</button>
						</form>
					</div>
			</div>
		</div>
	</div>
</div>


</div>
@endsection