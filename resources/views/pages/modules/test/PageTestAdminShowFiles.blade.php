@extends('layouts.gui', ['name' => $page->name])
@section('content')
<div class="container">
	<h1>{{ $page->name }}</h1>
	<div class="row">
    	<div class="col-md-10">
        	<div class="panel panel-default">
            	<div class="panel-heading"><p>You have finished assignment. Here are uploaded files.</p></div>
            		<div class="panel-body">
						<table class="table table-bordered">
							<tr>
								<td><strong>Subscriber</strong></td>
								@for($i=0; $i < $count; $i++)
									<td><strong>Task {{ $i+1 }}</strong></td>
								@endfor
							</tr>
							@foreach( $subscribers as $user )
							<tr>
								<td>{{ $user -> name }}</td>
								@foreach($tasks as $task)
									<td><a href="{{ URL::route('show', array($page->id, $user->id, $task->id) ) }}"><i class="fa fa-file-archive-o fa-2x"></i></a></td>
								@endforeach
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
