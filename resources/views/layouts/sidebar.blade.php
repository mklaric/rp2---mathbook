@if (isset($page))
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class='blue'>
        @if (isset($name))
            <div class="sidebar-top">
                <ul class="sidebar-nav" >
                    <li class="sidebar-brand">
                        <a href="#">
                            {{ $name }}
                        </a>
                    </li>
                    <hr style="border: 0">
                    <ul class="sortable" id='publicSidebarLinks'>
                    {{ csrf_field() }}
                    @foreach($page->sidebarPublic as $link)
                        <li id="publicSidebarLink_{{ $link->order }}">
                            <a href="/pages/{{ $page->id . "/" . $link->link }}">
                                <i class="fa fa-btn {{ $link->icon }} icon"></i>
                                <span>{{ $link->name }}</span>
                            </a>
                        </li>
                    @endforeach
                    </ul>
                    @hasanyrole([$page->id . '.subscriber', 'admin', $page->id . '.admin'])
                        @if ($page->sidebarSubscriber->count())
                            <hr>
                        @endif
                        <ul class="sortable" id='subscriberSidebarLinks'>
                        {{ csrf_field() }}
                        @foreach($page->sidebarSubscriber as $link)
                            <li id="subscriberSidebarLink_{{ $link->order }}">
                                <a href="/pages/{{ $page->id . "/" . $link->link }}">
                                    <i class="fa fa-btn {{ $link->icon }} icon"></i>
                                    <span>{{ $link->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endhasanyrole

                    @hasanyrole(['admin', $page->id . '.admin'])
                        <hr>
                        <ul class="sortable" id='publicSidebarLinks'>
                        {{ csrf_field() }}
                        @foreach($page->sidebarAdmin as $link)
                            <li id="adminSidebarLink_{{ $link->order }}">
                                <a href="/pages/{{ $page->id . "/" . $link->link }}">
                                    <i class="fa fa-btn {{ $link->icon }} icon"></i>
                                    <span>{{ $link->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endhasanyrole
                </ul>
            </div>
            <div class='sidebar-bottom'>
                <ul class='sidebar-nav'>
                    @hasanyrole(['admin', $page->id . '.admin'])
                        <ul>
                        <li>
                            <a href="#" id='editSidebarLinks'>
                                <i class="fa fa-btn fa-edit icon"></i>
                                <span>Edit Sidebar</span>
                            </a>
                        </li>
                        </ul>
                    @endhasanyrole
                </ul>
            </div>
        @else
            <ul class="sidebar-nav" ><li class="sidebar-brand"><a href="#"></a></li></ul>
        @endif
    </div>
@elseif (Auth::check())
    <div id="sidebar-wrapper" class='blue'>
        @if (isset($name))
            <div class="sidebar-top">
                <ul class="sidebar-nav" >
                    <li class="sidebar-brand">
                        <a href="#">
                            {{ $name }}
                        </a>
                    </li>
                    <hr style="border: 0">
                    <ul>
                    @foreach(Auth::user()->administrated() as $link)
                        <li>
                            <a href="/pages/{{ $link->id . "/" . $link->link }}">
                                <i class="fa fa-btn fa-bookmark-o icon"></i>
                                {{ $link->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>

                    @if (count(Auth::user()->administrated()) > 0 && count(Auth::user()->subscribed()) > 0)
                        <hr>
                    @endif
                    <ul>
                    @foreach(Auth::user()->subscribed() as $link)
                        <li>
                            <a href="/pages/{{ $link->id . "/" . $link->link }}">
                                <i class="fa fa-btn fa-bookmark icon"></i>
                                {{ $link->name }}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </ul>
            </div>
        @else
            <ul class="sidebar-nav" ><li class="sidebar-brand"><a href="#"></a></li></ul>
        @endif
    </div>
@endif
