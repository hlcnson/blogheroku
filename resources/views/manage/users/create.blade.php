{{-- Sử dụng giao diện backend trong file views/layouts/manage.blade.php--}}
@extends('layouts.manage')

{{-- Section thứ nhất, chứa HTML --}}
@section('content')
<div class="flex-container">
    <div class="columns m-t-10">
        <div class="column">
            <h1 class="title">Create New User</h1>
        </div>
        <hr class="m-t-10">
    </div>
    <div class="columuns">
        <div class="column">
            <form action="{{route('users.store')}}" method="POST">
                {{-- Phương thức này tạo mã HTML cho phần tử hidden input để chứa giá trị CSRF token --}}
                {{csrf_field()}}
                <div class="field">
                    <label for="name" class="label">Name</label>
                    <p class="control">
                        <input type="text" class="input" name="name" id="name">
                    </p>
                </div>
                <div class="field">
                    <label for="email" class="label">Email</label>
                    <p class="control">
                        <input type="email" class="input" name="email" id="email">
                    </p>
                </div>
                <div class="field">
                    <label for="password" class="label">Password</label>
                    <p class="control">
                        {{-- Sử dụng Vue directive v-if ràng buộc với thuộc tính model tên auto_password, xóa khỏi DOM khi điều kiện false --}}
                        <input type="password" class="input" name="password" id="password" v-if="!auto_password" placeholder="Enter password manually">
                        {{-- Sử dụng checkbox component của thư viện Buefy.
                        Directive v-model của Vue.js và ràng buộc với thuộc tính model tên auto_password. --}}
                        <b-checkbox name="auto_generate" class="m-t-15" v-model="auto_password">Auto Generate Password</b-checkbox>
                    </p>
                </div>
                <button class="button is-success">Create User</button>
            </form>
        </div>
    </div>
    
    
</div>

@endsection

{{-- Section thứ hai, chứa mã script --}}
@section('scripts')
    <script>
        // Tạo đối tượng Vuejs. Đối tượng tạo ở đây chỉ có tác dụng trong view này.
        // Đối tượng Vue có giá trị ở mọi trang phải được tạo ở file app.js
        var app = new Vue({
            el: '#app',
            data: {
                auto_password: true
            }
        });
    </script>
@endsection