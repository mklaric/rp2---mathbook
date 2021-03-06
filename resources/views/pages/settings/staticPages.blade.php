<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Static Pages</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name</strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Link</strong>
                            </div>
                        </div>
                    </li>
                    @foreach ($page->staticPages() as $static)
                        <li class="list-group-item">
                            @if (!$static->pageModule()->immutable)
                                <form method="POST" action="/pages/{{ $page->id }}/{{ $static->link }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            @endif
                            <div class="row">
                                <div class="col-md-6" style="line-height: 30px">
                                    <a href="/pages/{{ $page->id }}/{{ $static->link }}">{{ $static->name }}</a>
                                </div>
                                <div class="col-md-4" style="line-height: 30px">
                                    <span style="color: #999">pages/{{ $page->id }}/</span><a href="/pages/{{ $page->id }}/{{ $static->link }}">{{ $static->link }}</a>
                                </div>
                                <div class="col-md-2">
                                    @if (!$static->pageModule()->immutable)
                                        <input name="id" type="hidden" class="form-control" value="{{ $static->id }}">
                                        <input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
                                        <button style="float: right" class="btn btn-block btn-danger btn-sm" type="submit" name="button">Remove</button>
                                    @else
                                        <button style="float: right" class="btn btn-block btn-danger btn-sm disabled" type="button" name="button">Remove</button>
                                    @endif
                                </div>
                            </div>
                            @if (!$static->pageModule()->immutable)
                                </form>
                            @endif
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        <form method="POST" action="/pages/{{ $page->id }}/settings/modules/StaticPage/create">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6" style="line-height: 30px">
                               <input name="name" type="text" class="form-control" placeholder="Name" required value="{{ old('name') }}">
                            </div>
                            <div class="col-md-4" style="line-height: 30px">
                               <input name="link" type="text" class="form-control" placeholder="Link" required value="{{ old('link') }}">
                            </div>
                            <div class="col-md-2">
                                    <input name="page_id" type="hidden" class="form-control" value="{{ $page->id }}">
                                    <button class="btn btn-block btn-success btn-sm pull-right" type="submit" name="submit">Create</button>
                            </div>
                        </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
