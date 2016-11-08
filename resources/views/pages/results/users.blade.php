@extends('layouts.gui', ['name' => $page->name])
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Results</div>
        <div class="panel-body">
            <ul class="list-group">


                @foreach ( $page->resultPages()->results as $res)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-10" style="line-height: 30px">

                                <a href = "/pages/{{ $page->id}}/results/{{ $res->id}}" >{{ $res->link}} </a>

                            </div>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

@endsection
