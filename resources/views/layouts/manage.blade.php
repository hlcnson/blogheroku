{{-- Đây là layout chính cho giao diện backend --}}

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>System Management</title>

    <!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	{{-- Kết xuất mã nguồn riêng của trang con, nếu không có thì bỏ qua --}}
	@yield('styles')
</head>
    <body>
        {{-- Nhúng mã của khu vực navigation (_includes/nav/main.blade.php) vào đây. --}}
        @include('_includes.nav.main')
        
        {{-- Nhúng mã nguồn của khu vực side navigation (menu trái), trong file
        (_includes/nav/manage.blade.php) --}}
        @include('_includes.nav.manage')

        <!-- Phần tử div này xác định phạm vi của đối tượng Vue (/resources/assets/js/app.js).
        Có thể sử dụng Vue component trong đây -->
        <div id="app" class="management-area">
            {{-- Kết xuất mã nguồn của trang con. Vue object hoạt động cả trong content được nhúng ở đây --}}
            @yield('content')
        </div>

        <!-- Scripts của toàn ứng dụng -->
        <script src="{{ asset('js/app.js') }}"></script>
        
        {{-- Kết xuất thêm script của trang con, nếu có. --}}
        @yield('scripts')
    </body>
</html>
