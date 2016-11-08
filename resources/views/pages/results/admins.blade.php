@extends('layouts.gui', ['name' => $page->name])
@section('content')

<!--
<form action="/pages/{{ $page->id }}/results/add" method="post" enctype="multipart/form-data">
    	{{ csrf_field() }}
    	<input name="link" class="form-control" >
        <input type="file" name="filefield">
        <input type="submit">
</form> -->




    <div class="panel panel-default">
        <div class="panel-heading ">Results</div>
        <div class="panel-body">
            <ul class="list-group">

                	<li class="list-group-item ">
					    <form action="/pages/{{ $page->id }}/results/add" method="post" enctype="multipart/form-data">
					        {{ csrf_field() }}
					        <div class="row ">
					            <div class="col-md-6" style="line-height: 30px">
					                <input name="filefield" type="file" class="form-control" >
					            </div>

					            <div class="col-md-6">
					                <input name="link" type="text" class="form-control" placeholder="Link" required value="{{ old('link') }}">

					            </div>
					        </div>
                            <br>
                            <div class="row">

                                <div class="col-md-10">
                                    <input name="notif" type="text" class="form-control" placeholder="Notification" >

                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-block btn-success btn-sm pull-right" type="submit" name="submit">Dodaj</button>
                                </div>
                            </div>
					    </form>
					</li>
                    <br>

                @foreach ( $page->resultPages()->results as $res)
                        <li class="list-group-item">
                            <form method="POST" action="/pages/{{ $page->id }}/results/delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="row">
	                            <div class="col-md-10" style="line-height: 30px">
	                                <a href = "/pages/{{ $page->id}}/results/{{ $res->id}}" >{{ $res->link}} </a>
	                            </div>
                                <div class="col-md-2">
                                    <input name="res_id" type="hidden" class="form-control" value="{{ $res->id }}">
                                    <button style="float: right" class="btn btn-block btn-danger btn-sm" type="submit" name="button">Delete</button>
                                </div>
                            </div>
                            </form>
                        </li>

                @endforeach
            </ul>
        </div>
    </div>


@endsection
