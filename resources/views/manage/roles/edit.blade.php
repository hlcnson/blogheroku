@extends('layouts.manage')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10">
            <div class="column">
            <h1 class="title">Edit {{$role->display_name}}</h1>
            </div> <!-- end of column -->
        </div>
        <hr class="m-t-0">

        <form action="{{route('roles.update', $role->id)}}" method="POST">
            {{csrf_field()}}
            {{-- Phương thức này tạo mã HTML cho phần tử hidden input để chứa HTTP verb cho form --}}
            {{method_field('PUT')}}
            <div class="columns">
                <div class="column">
                    <div class="box">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <h2 class="title">Role Detail:</h2>
                                    <div class="field">
                                        <label for="display_name" class="label">Name (Human readable)</label>
                                        <p class="control">
                                            <input type="text" class="input" value="{{$role->display_name}}" id="display_name" name="display_name">
                                        </p>
                                    </div>
                                    <div class="field">
                                        <label for="name" class="label">Slug (Can not be edited)</label>
                                        <p class="control">
                                            <input type="text" class="input" value="{{$role->name}}" id="name" name="name" disabled>
                                        </p>
                                    </div>
                                    <div class="field">
                                        <label for="description" class="label">Description</label>
                                        <p class="control">
                                            <input type="text" class="input" value="{{$role->description}}" id="description" name="description">
                                        </p>
                                    </div>
                                    {{-- Tạo một field ẩn để chứa danh sách các permission được chọn gán cho role.
                                    Dùng directive v-bind để bind thuộc tính value với thuộc tính permissionsSelected của Vue model --}}
                                    <input type="hidden" name="permissions" :value="permissionsSelected">
                                </div>
                            </div>
                        </article>
                    </div> {{--  End box --}}
                </div>
            </div>
        

            <div class="columns">
                <div class="column">
                    <div class="box">
                        <article class="media">
                            <div class="media-content">
                                <div class="content">
                                    <h2 class="title">Permissions:</h2>
                                    {{-- Nhóm checkbox này bind với thuộc tính mảng permissionsSelected của Vue model --}}
                                    <b-checkbox-group v-model="permissionsSelected">
                                        {{-- Hiển thị tất cả các permission để user chọn và gán cho role --}}
                                        @foreach($permissions as $permission)
                                            <div class="field">
                                                {{-- Dùng dấu : ở đầu tên thuộc tính để Buefy làm việc với giá trị kiểu số nguyên, thay vì kiểu chuỗi --}}
                                                <b-checkbox :custom-value="{{$permission->id}}">{{$permission->display_name}} <em class="m-l-15">({{$permission->description}})</em>
                                                </b-checkbox>
                                            </div>
                                        @endforeach
                                    </b-checkbox-group>
                                </div>
                            </div>
                        </article>
                    </div>
                    <button class="button is-primary m-b-30">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                // Sử dụng cú pháp Laravel blade để hiển thị Unescaped Data. Cú pháp này khác với
                // cú pháp hai dấu ngoặc móc thông thường. Với cú pháp này, Laravel không sử dụng 
                // hàm htmlspecialchars để chống tấn công XSS.
                // Kết xuất mảng chứa id (kiểu int) của các permission của role.
                permissionsSelected: {!! $role->permissions->pluck('id') !!}
            }
        });
    </script>
@endsection