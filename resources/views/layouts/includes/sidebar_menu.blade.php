<a href="{{ $link['url'] }}"><i class="{{ $link['icon'] }}"></i>
    <span>{{ $link['name'] }}</span>
    @if (count($link) != count($link, COUNT_RECURSIVE))
        <i class="fa fa-angle-left pull-right"></i>
    @endif
</a>
@if (count($link) != count($link, COUNT_RECURSIVE))
    <ul class="treeview-menu">
        @foreach($link as $dropdown_link)
            @if (is_array($dropdown_link))
                @foreach ($dropdown_link as $drop_link)
                    <li {{ setActive($drop_link['url']) }}>@include('layouts.includes.sidebar_menu', ['link' => $drop_link])</li>
                @endforeach
            @endif
        @endforeach
    </ul>
@endif