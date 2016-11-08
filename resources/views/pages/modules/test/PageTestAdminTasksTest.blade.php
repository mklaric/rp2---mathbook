@extends('layouts.gui', ['name' => $page->name])
@section('content')
<div class="container">
	<h1>{{ $page->name }} - {{ $test->link }}</h1>
	<div class="row">
    	<div class="col-md-10">
        	<div class="panel panel-default">
            	<div class="panel-heading"><p>Now add text for each task in new assignment.</p></div>
            		<div class="panel-body">
		
						<form method="POST" action="/pages/{{ $page->id }}/test/finishGenerate">
							{{ csrf_field() }}
							@for($i = 0; $i < $test->numTasks; $i++)
							<div>
								<label for={{ 'tekst' . ($i+1) }}><strong>Task {{ $i+1 }}:</strong></label><br>
								<textarea name= {{ 'tekst' . ($i+1) }} rows="60" cols="60" required></textarea>
								<hr>
							</div>
							@endfor
							<div class="col-md-2">
								<input name="test_id" type="hidden" class="form-control" value="{{ $test->id }}">
								<input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
				     			<button style="float: right" type="submit" name="button" value="OK" class="btn btn-success">Generate test</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

</div>
@endsection