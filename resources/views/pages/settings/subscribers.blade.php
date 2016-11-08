<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Subscribers</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Username</strong>
                            </div>
                            <div class="col-md-8">
                                <strong>Email</strong>
                            </div>
                        </div>
                    </li>
                    @foreach ($page->subscribers() as $subscriber)
                        <li class="list-group-item">
                            <form method="POST" action="/pages/{{ $page->id }}/settings/subscriber/delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="row">
                                <div class="col-md-4" style="line-height: 30px">
                                    <a href="#">{{ $subscriber->name }}</a>
                                </div>
                                <div class="col-md-6" style="line-height: 30px">
                                    <a href="mailto:{{ $subscriber->email }}?subject=feedback">{{ $subscriber->email }}</a>
                                </div>
                                <div class="col-md-2">
                                    <input name="name" type="hidden" class="form-control" value="{{ $subscriber->name }}">
                                    <button style="float: right" class="btn btn-block btn-danger btn-sm" type="submit" name="button">Delete</button>
                                </div>
                            </div>
                            </form>
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        <form method="POST" action="/pages/{{ $page->id }}/settings/subscriber/add">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10" style="line-height: 30px">
                               <input name="name" type="text" class="form-control" placeholder="Name" required value="{{ old('name') }}">
                            </div>
                            <div class="col-md-2">
                                    <button class="btn btn-block btn-success btn-sm pull-right" type="submit" name="submit">Add</button>
                            </div>
                        </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
