{{-- Sử dụng giao diện backend trong file views/layouts/manage.blade.php--}}
@extends('layouts.manage')

{{-- Section thứ nhất, chứa HTML --}}
@section('content')
<div class="flex-container">
    <div class="columns m-t-10">
        <div class="column">
            <h1 class="title">Edit User</h1>
        </div>
        <hr class="m-t-10">
    </div>
    <form action="{{route('users.update', $user->id)}}" method="POST">
        <div class="columns">
            <div class="column">
                {{-- Phương thức này tạo mã HTML cho phần tử hidden input để chứa HTTP verb cho form --}}
                {{method_field('PUT')}}
                {{-- Phương thức này tạo mã HTML cho phần tử hidden input để chứa giá trị CSRF token --}}
                {{csrf_field()}}

                <div class="field">
                    <label for="name" class="label">Name</label>
                    <p class="control">
                    <input type="text" class="input" name="name" id="name" value="{{$user->name}}">
                    </p>
                </div>
                <div class="field">
                    <label for="email" class="label">Email</label>
                    <p class="control">
                        <input type="email" class="input" name="email" id="email" value="{{$user->email}}">
                    </p>
                </div>
                <div class="field">
                    {{-- Bind với thuộc tính password_options của Vue model --}}
                    <input type="hidden" name="password_options" :value="password_options">
                    <label for="password" class="label">Password</label>
                    {{-- <b-radio-group v-model="password_options"> --}}
                        <div class="field">
                            {{-- Sử dụng Buefy radio button component --}}
                            <b-radio native-value="keep" v-model="password_options">Do not change password</b-radio>
                        </div>
                        <div class="field">
                            <b-radio native-value="auto" v-model="password_options">Auto-generate new password</b-radio>
                        </div>
                        <div class="field">
                            <b-radio native-value="manual" v-model="password_options">Manually set new password</b-radio>
                            
                            <p class="control">
                                <input type="password" name="password" id="password" v-if="password_options == 'manual'" placeholder="Enter your password" class="input">
                            </p>
                        </div>
                    {{-- </b-radio-group> --}}
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label for="roles" class="label">Assigned Roles:</label>
                    {{-- Bind với thuộc tính rolesSelected của Vue model --}}
                    <input type="hidden" name="roles" :value="rolesSelected">
                    {{-- <b-checkbox-group v-model="rolesSelected" > --}}
                    @foreach ($roles as $role)
                        <div class="field">
                            {{-- Dùng dấu : ở đầu tên thuộc tính để Buefy làm việc với giá trị kiểu số nguyên, thay vì kiểu chuỗi --}}
                            <b-checkbox :native-value="{{$role->id}}" v-model="rolesSelected">{{$role->display_name}} <em class="m-l-15">({{$role->description}})</em></b-checkbox>
                        </div>
                    @endforeach
                    {{-- </b-checkbox-group> --}}
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <hr>
                <button class="button is-primary">Update User</button>
            </div>
        </div>
        
    </form>
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
                password_options: 'keep',   // Chứa tùy chọn password
                // Sử dụng cú pháp Laravel blade để hiển thị Unescaped Data. 
                // Cú pháp này khác với cú pháp hai dấu ngoặc móc thông thường.
                // Với cú pháp này, Laravel không sử dụng 
                // hàm htmlspecialchars để chống tấn công XSS.
                // Kết xuất mảng chứa id (kiểu int) của các role của user.
                rolesSelected: {!! $user->roles->pluck('id') !!}
            }
        });
    </script>
@endsection