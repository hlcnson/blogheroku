@extends('layouts.app')

@section('content')

@if (session('status'))
    <div class="notification is-success">
        {{ session('status') }}
    </div>
@endif

<div class="columns">
    {{-- Sử dụng Bulma grid. Độ rộng cột 1/3, dịch trái 1/3 --}}
    <div class="column is-one-third is-offset-one-third m-t-100">
        <div class="card">
            <div class="card-content">
                <h1 class="title">Forgot Password?</h1>
                {{-- Cú pháp blade. Form sẽ submit về route /login --}}
                <form action="{{route('password.email')}}" method="POST" role="form">
                    {{csrf_field()}}
                    {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
                    <div class="field">
                        <label for="email" class="label">Email Address</label>
                        <p class="control">
                            {{-- Hàm old là hàm global, dùng để lấy lại dữ liệu được
                            submit ở request trước. 
                            $error là biến toàn cục của Laravel, phương thức has kiểm tra
                            xem field email có lỗi không, nếu có, thêm class is-danger. --}}
                            <input class="input {{$errors->has('email') ? 'is-danger' : ''}}"  type="text" name="email" id="email" placeholder="Enter email for password recovery" value="{{ old('email') }}" autofocus>
                        </p>
                        {{-- Hiển thị thông điệp báo có lỗi --}}
                        @if ($errors->has('email'))
                            <p class="help is-danger">{{$errors->first('email')}}</p>
                        @endif
                    </div>
                    
                    
                    <button class="button is-success is-outlined is-fullwidth m-t-30">Get Reset Link</button> 
                </form> 
            </div> 
        </div>   {{-- end card --}}
        <h5 class="has-text-centered m-t-20">
            {{-- is-muted là custom class, để tạo văn bản xám nhạt --}}
            <a href="{{route('login')}}" class="is-muted">Back to Login page</a>
        </h5>
    </div>
</div>

{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection
