@extends('layouts.gui', ['name' => 'Pages'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Pages</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Page</strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Link</strong>
                            </div>
                        </div>
                    </li>
                    @foreach ($pages as $instance)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6" style="line-height: 30px">
                                    <a href="/pages/{{ $instance->id }}">{{ $instance->name }}</a>
                                </div>
                                <div class="col-md-6" style="line-height: 30px">
                                    <a href="/pages/{{ $instance->id }}">{{ $instance->id }}</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
