<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Administrators</div>
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
                    @foreach ($page->admins() as $admin)
                        <li class="list-group-item">
                            <form method="POST" action="/pages/{{ $page->id }}/settings/admin/delete">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <div class="row">
                                <div class="col-md-4" style="line-height: 30px">
                                    <a href="#">{{ $admin->name }}</a>
                                </div>
                                <div class="col-md-6" style="line-height: 30px">
                                    <a href="mailto:{{ $admin->email }}?subject=feedback">{{ $admin->email }}</a>
                                </div>
                                <div class="col-md-2">
                                    <input name="name" type="hidden" class="form-control" value="{{ $admin->name }}">
                                    <button style="float: right" class="btn btn-block btn-danger btn-sm" type="submit" name="button">Revoke</button>
                                </div>
                            </div>
                            </form>
                        </li>
                    @endforeach
                    <li class="list-group-item">
                        <form method="POST" action="/pages/{{ $page->id }}/settings/admin/add">
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
