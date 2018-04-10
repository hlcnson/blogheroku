<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Phần tử div này xác định phạm vi của đối tượng Vue (/resources/assets/js/app.js).
    Có thể sử dụng Vue component trong đây -->
    <div id="app">
		{{-- Các class sử dụng ở đây đều là Bulma class. Customize class sẽ được ghi chú. --}}
		<nav class="nav has-shadow">
			<!-- Tạo container để canh lề trung tâm cho các phần tử bên trong -->
			<div class="container">
				<div class="nav-left">
					<!-- Hàm route kết xuất route đến trang home.
				 	Hàm asset tham chiếu đến url của thư mục /public-->
					<!-- Logo -->
					<a class="nav-item" href="{{route('home')}}">
						<img src="{{asset('images/devmarketer-logo.png')}}" alt="Logo here">
					</a>
					<!-- Menu trái -->
					<!-- is-tab: gạch chân
				 	is-hidden-mobile: menu ẩn đi trên màn hình mobile
					m-l-10: margin left 10px-->
					<a class="nav-item is-tab is-hidden-mobile m-l-10" href="#">
						Learn
					</a>
					<a class="nav-item is-tab is-hidden-mobile" href="#">
						Discuss
					</a>
					<a class="nav-item is-tab is-hidden-mobile" href="#">
						Share
					</a>
				</div>
				<div class="nav-right" style="overflow:visible;">
					<!-- Sử dụng cú pháp blade của Laravel -->
					@if (!Auth::guest())
						{{-- user chưa đăng nhập --}}
						<a href="#" class="nav-item is-tab">Login</a>
						<a href="#" class="nav-item is-tab">Join the Community</a>
					@else
						{{-- User đã đăng nhập. Tạo dropdown.
						Customize class: is-aligned-right, dropdown-menu --}}
						<button class="dropdown nav-item is-open is-tab is-aligned-right">
							Hey Alex <span class="icon"><i class="fa fa-caret-down"></i></span>
							{{-- Dropdown menu ở đây --}}
							<ul class="dropdown-menu">
								<li><a href="#">Profile</a></li>
								<li><a href="#">Notifications</a></li>
								<li><a href="#">Settings</a></li>
								<li class="seperator"></li>
								<li><a href="#">Log out</a></li>
							</ul>
						</button>
					@endif
				</div>
			</div>
		</nav>
		<!-- Vue object hoạt động cả trong content được nhúng ở đây -->
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
