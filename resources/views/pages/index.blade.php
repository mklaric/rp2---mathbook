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
                            <div class="col-md-5">
                                <strong>Page</strong>
                            </div>
                            <div class="col-md-7">
                                <strong>Link</strong>
                            </div>
                        </div>
                    </li>
                    @foreach ($pages as $instance)
                        <li class="list-group-item">
                            <form method="POST" action="/pages/delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="row">
                                <div class="col-md-5" style="line-height: 30px">
                                    <a href="/pages/{{ $instance->id }}">{{ $instance->name }}</a>
                                </div>
                                <div class="col-md-5" style="line-height: 30px">
                                    <span style="color: #999">pages/</span><a href="/pages/{{ $instance->id }}">{{ $instance->id }}</a>
                                </div>
                                <div class="col-md-2">
                                    <input name="id" type="hidden" class="form-control" value="{{ $instance->id }}">
                                    <button class="btn btn-block btn-danger btn-sm" type="submit" name="button">Remove</button>
                                </div>
                            </div>
                            </form>
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        <form method="POST" action="/pages/create">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-5" style="line-height: 30px">
                               <input name="name" type="text" class="form-control" placeholder="Page" required value="{{ old('name') }}">
                            </div>
                            <div class="col-md-5" style="line-height: 30px">
                                <input name="id" type="text" class="form-control" placeholder="Link" required value="{{ old('id') }}">
                            </div>
                            <div class="col-md-2">
                                    <button class="btn btn-block btn-success btn-sm pull-right" type="submit" name="submit">Create</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
