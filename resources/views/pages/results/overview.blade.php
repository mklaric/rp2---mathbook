@extends('layouts.gui', ['name' => $page->name])
@section('content')

<div class="panel panel-default">
        <div class="panel-heading text-center "><strong>{{$ime}}</strong></div>
        <div class="panel-body">
            <ul class="list-group">
                <div class="csv">
                    {{$contents}}
                </div>
            </ul>
        </div>
    </div>
</div>

@endsection
