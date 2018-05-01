{{-- Đây là code của menu trái cho giao diện backend --}}

<div class="side-menu" id="admin-side-menu">
    <aside class="menu m-t-30 m-l-10 m-r-10">
        <p class="menu-label">
            General
        </p>
        <ul class="menu-list">
            {{-- Sử dụng LaravelEasyNav để kết xuất class is-active khi route được kích hoạt --}}
            <li><a href="{{route('manage.dashboard')}}" class="{{Nav::isRoute('manage.dashboard')}}">Dashboard</a></li>
        </ul>

        <p class="menu-label">
            Content
        </p>
        <ul class="menu-list">
            {{-- Phương thức Nav::isResource kết xuất class tên is-active cho tất cả các resource route liên quan đến route users trong web.php --}}
            <li><a href="{{route('posts.index')}}" class="{{Nav::isResource('posts')}}">Blog Posts</a></li>
            
            {{-- <li>
                <a class="has-submenu" href="#">Example Acordion</a>
                <ul class="submenu">
                    <li><a href="{{route('roles.index')}}">Roles</a></li>
                    <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                </ul>
            </li>
            <li>
                <a class="has-submenu" href="#">Another Example</a>
                <ul class="submenu">
                    <li><a href="{{route('roles.index')}}">Roles</a></li>
                    <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                </ul>
            </li> --}}
        </ul>
        
        <p class="menu-label">
            Administration
        </p>
        <ul class="menu-list">
            {{-- Phương thức Nav::isResource kết xuất class tên is-active cho tất cả các resource route liên quan đến route users trong web.php --}}
            <li><a href="{{route('users.index')}}" class="{{Nav::isResource('users')}}">Manage Users</a></li>
            <li>
                {{-- Phương thức Nav:hasSegment kết xuất chuỗi is-active khi trong route có segment tên roles hoặc permissions tại vị trí thứ 2 --}}
                <a class="has-submenu {{Nav::hasSegment(['roles', 'permissions'], 2)}}" href="#">Roles &amp; Permissions</a>
                <ul class="submenu">
                    <li><a href="{{route('roles.index')}}" class="{{Nav::isRoute('roles.index')}}">Roles</a></li>
                    <li><a href="{{route('permissions.index')}}" class="{{Nav::isRoute('permissions.index')}}">Permissions</a></li>
                </ul>
            </li>
            <li>
                <a class="has-submenu" href="#">Example Acordion</a>
                <ul class="submenu">
                    <li><a href="{{route('roles.index')}}">Roles</a></li>
                    <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                </ul>
            </li>
            <li>
                <a class="has-submenu" href="#">Another Example</a>
                <ul class="submenu">
                    <li><a href="{{route('roles.index')}}">Roles</a></li>
                    <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>