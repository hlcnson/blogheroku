{{-- Đây là code của khu vực navigation.
    Các class sử dụng ở đây đều là Bulma class. Customize class sẽ được ghi chú. --}}

<nav class="navbar has-shadow" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            <img src="{{asset('images/devmarketer-logo.png')}}" alt="DevMarketer logo">
        </a>

        {{-- Nếu trong route có segment ở vị trí thứ nhất là manage --}}
        @if (Request::segment(1) == 'manage')
            {{-- Kết xuất code nút ẩn hiện menu trái trên màn hình mobile --}}
            <a class="navbar-item is-hidden-desktop" id="admin-slideout-button">
                <span class="icon">
                    <i class="fa fa-arrow-circle-o-right"></i>
                </span>
            </a>
        @endif
    
        <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>
    <div class="navbar-menu" id="navMenu">
        <div class="navbar-start">
            <a class="navbar-item is-uppercase">Learn</a>
            <a class="navbar-item is-uppercase">Discuss</a>
            <a class="navbar-item is-uppercase">Share</a>
        </div>
        
        <div class="navbar-end">
            <!-- navbar items -->
            <!-- Sử dụng cú pháp blade của Laravel -->
            @if (Auth::guest())
                {{-- user chưa đăng nhập --}}
                <a href="{{route('login')}}" class="navbar-item is-tab">Login</a>
                <a href="{{route('register')}}" class="navbar-item is-tab">Join the Community</a>
            @else
                {{-- User đã đăng nhập. Tạo dropdown.
						Customize class: is-aligned-right, dropdown-menu --}}
                
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Hey {{ Auth::user()->name }}
                    </a>
                
                    <div class="navbar-dropdown is-boxed">
                        <a href="#" class="navbar-item">
                            <span class="icon">
                            <i class="fa fa-fw fa-user-circle-o m-r-5"></i>
                            </span>Profile
                        </a>
                        <a class="navbar-item" href="{{route('manage.dashboard')}}">
                            <span class="icon">
                            <i class="fa fa-fw fa-cog m-r-5"></i>
                            </span>Manage
                        </a>
                        <a class="navbar-item" href="#">
                            <span class="icon">
                            <i class="fa fa-fw fa-bell m-r-5"></i>
                            </span>Notifications
                        </a>
                        <a class="navbar-item" href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <span class="icon">
                                <i class="fa fa-fw fa-sign-out m-r-5"></i>
                            </span>
                            Logout
                        </a>
                        {{-- Bao gồm mã nguồn form logout ở đây. Cú pháp Blade --}}
                        @include('_includes.forms.logout')
                    </div>
                </div>
            @endif
        </div>
    </div>
</nav>


