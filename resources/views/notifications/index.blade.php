<div class="row">
    <div class="col-md-12">
        @foreach ($notifications as $n)
        <div class="panel panel-default">
            <div class="panel-body">
                @unless (isset($page))
                    <a href="/pages/{{ $n->page_id }}/notifications">{{ $n->page()->name }}</a>
                @endunless

                <div class="pull-right notification-date" datetime="{{ $n->updated_at }}" style="color: #aaa">{{ $n->updated_at }}</div><br><br>

                <div class="markdown">{{ $n->content }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
