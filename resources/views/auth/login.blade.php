@extends('layouts.app')

@section('content')


<div class="columns">
    {{-- Sử dụng Bulma grid. Độ rộng cột 1/3, dịch trái 1/3 --}}
    <div class="column is-one-third is-offset-one-third m-t-100">
        <div class="card">
            <div class="card-content">
                <h1 class="title">Log In</h1>
                {{-- Cú pháp blade. Form sẽ submit về route /login --}}
                <form action="{{route('login')}}" method="POST" role="form">
                    {{csrf_field()}}
                    <div class="field">
                        <label for="email" class="label">Email Address</label>
                        <p class="control">
                            {{-- Hàm old là hàm global, dùng để lấy lại dữ liệu được
                            submit ở request trước. 
                            $error là biến toàn cục của Laravel, phương thức has kiểm tra
                            xem field email có lỗi không, nếu có, thêm class is-danger. --}}
                            <input class="input {{$errors->has('email') ? 'is-danger' : ''}}"  type="text" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus>
                        </p>
                        {{-- Hiển thị thông điệp báo có lỗi --}}
                        @if ($errors->has('email'))
                            <p class="help is-danger">{{$errors->first('email')}}</p>
                        @endif
                    </div>
                    <div class="field">
                        <label for="password" class="label">Password</label>
                        <p class="control">
                            <input class="input {{$errors->has('password') ? 'is-danger' : ''}}" type="password" name="password" id="password">
                        </p>
                        {{-- Hiển thị thông điệp báo có lỗi --}}
                        @if ($errors->has('password'))
                            <p class="help is-danger">{{$errors->first('password')}}</p>
                        @endif
                    </div>
                    {{-- Sử dụng điều khiển checkbox của thư viện Buefy component.
                    Cần có thuộc tính name để Laravel lấy dữ liệu khi form được submit --}}
                    <b-checkbox name="remember" class="m-t-20">Remember Me</b-checkbox>
                    
                    <button class="button is-success is-outlined is-fullwidth m-t-30">Log In</button> 
                </form> 
            </div> 
        </div>   {{-- end card --}}
        <h5 class="has-text-centered m-t-20">
            {{-- is-muted là custom class, để tạo văn bản xám nhạt --}}
            <a href="{{route('password.request')}}" class="is-muted">Forget Your Password?</a>
        </h5>
    </div>
</div>
@endsection
