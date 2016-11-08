<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Add notification</div>
            <div class="panel-body">
                <form method="POST" action="/pages/{{ $page->id }}/notifications/add">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" rows="5" name="content" placeholder="Notification content" required value="{{ old('content') }}"></textarea>
                    </div>
                    <button class="btn btn-success btn-sm pull-right" style="min-width: 100px" type="submit">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
