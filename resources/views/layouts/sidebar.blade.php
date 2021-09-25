<?php

$url = url()->full();
$url_array = parse_url($url);
$path = isset($url_array['path']) ? $url_array['path'] : '';


class SideBar {
    public function checkActive($_submenu, $url_path) {
        $result = false;
        foreach($_submenu as $sm) {
            if($url_path == $sm['url']) {
                $result = true;
            }
        }
        if($result) {
            return 'active';
        } else {
            return '';
        }
    }
}

$sidebar = new SideBar();

?>

@foreach(config('adminlte.menu') as $menu)
    @isset($menu['can'])
        @if(Auth::user()->hasRole($menu['can']))
        <li @isset($menu['submenu']) class="treeview {{ $sidebar->checkActive($menu['submenu'], $path) }}" @else class="{{ ($path == $menu['url'] ? 'active' : '') }}" @endisset>
            <a href="{{ (isset($menu['url']) ? url($menu['url']) : '#') }}">
                <i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['title'] }}</span>
                @isset($menu['submenu'])
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                @endisset
            </a>
            @isset($menu['submenu'])
            <ul class="treeview-menu">
                @foreach($menu['submenu'] as $submenu)
                <li class="{{ ($path == $submenu['url'] ? 'active' : '') }}"><a href="{{ url($submenu['url']) }}"><i class="fa {{ $submenu['icon'] }}"></i> {{ $submenu['title'] }}</a></li>
                @endforeach
            </ul>
            @endisset
        </li>
        @endif
    @else
    <li @isset($menu['submenu']) class="treeview {{ $sidebar->checkActive($menu['submenu'], $path) }}" @else class="{{ ($path == $menu['url'] ? 'active' : '') }}" @endisset>
        <a href="{{ (isset($menu['url']) ? url($menu['url']) : '#') }}">
            <i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['title'] }}</span>
            @isset($menu['submenu'])
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
            @endisset
        </a>
        @isset($menu['submenu'])
        <ul class="treeview-menu">
            @foreach($menu['submenu'] as $submenu)
            <li class="{{ ($path == $submenu['url'] ? 'active' : '') }}"><a href="{{ url($submenu['url']) }}"><i class="fa {{ $submenu['icon'] }}"></i> {{ $submenu['title'] }}</a></li>
            @endforeach
        </ul>
        @endisset
    </li>
    @endisset
@endforeach