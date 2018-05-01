@extends('layouts.manage')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10">
            <div class="column">
            <h1 class="title">Create New Role</h1>
            </div> <!-- end of column -->
        </div>
        <hr class="m-t-0">

        <form action="{{route('roles.store')}}" method="POST">
            {{csrf_field()}}
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
                                            {{-- Hàm old() để lấy lại dữ liệu cũ trong Session của HTTP request --}}
                                            <input type="text" class="input" value="{{old('display_name')}}" id="display_name" name="display_name">
                                        </p>
                                    </div>
                                    <div class="field">
                                        <label for="name" class="label">Slug (Can not be edited)</label>
                                        <p class="control">
                                            <input type="text" class="input" value="{{old('name')}}" id="name" name="name">
                                        </p>
                                    </div>
                                    <div class="field">
                                        <label for="description" class="label">Description</label>
                                        <p class="control">
                                            <input type="text" class="input" value="{{old('description')}}" id="description" name="description">
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
                                        {{-- Hiển thị tất cả các permission để user chọn và gán cho role. Biến $permission do RoleController truyền sang --}}
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
                    <button class="button is-primary m-b-30">Create New Role</button>
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
                // Mặc định không có permission nào được chọn
                permissionsSelected: []
            }
        });
    </script>
@endsection