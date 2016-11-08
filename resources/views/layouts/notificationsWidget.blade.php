<li id="notification_li">
    <a href="#" id="notificationsLink"><div class="notification-counter pull-right">{{ Auth::user()->unreadNotificationsNumber() }}</div></a>

    <div id="notificationContainer">
        <div id="notificationTitle">Notifications</div>
            <div id="notificationsBody">
                @foreach (Auth::user()->notifications as $n)
<div class='widget-link'>
    <a href="/pages/{{ $n->page()->id }}/notifications">{{ $n->page()->name }}</a><div class="notification-date pull-right" datetime="{{ $n->updated_at }}" style="color: #888">{{ $n->updated_at }}</div>
<div class="markdown widget-notification">{{ $n->content }}</div>
</div>
                @endforeach
            </div>
        <div id="notificationFooter"><a href="/notifications">See All</a></div>
    </div>
</li>
