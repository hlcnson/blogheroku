{{-- Sử dụng giao diện backend /resources/views/layouts/manage.blade.php --}}
@extends('layouts.manage')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10">
            <div class="column">
                <h1 class="title">Create New Permission</h1>
            </div>
        </div>
        <hr class="m-t-0">

        <div class="columns">
            <div class="column">
                <form action="{{route('permissions.store')}}" method="POST">
                    {{csrf_field()}}

                    <div class="block">
                        {{-- Sử dụng Buefy component --}}
                        <b-radio-group v-model="permissionType" name="permission_type">
                            <b-radio name="permission_type" value="basic">Basic Permission</b-radio>
                            <b-radio name="permission_type" value="crud">CRUD Permission</b-radio>
                        </b-radio-group>
                    </div>
                    {{-- Sử dụng Vuejs directive: Chỉ kết xuất mã HTML của phần tử này khi
                        điều kiện thỏa mãn (tức radio Basic Permission được chọn) --}}
                    <div class="field" v-if="permissionType == 'basic'">
                        <label for="display_name" class="label">Name (Display Name)</label>
                        <p class="control">
                            <input type="text" class="input" name="display_name" id="display_name">
                        </p>
                    </div>

                    <div class="field" v-if="permissionType == 'basic'">
                        <label for="name" class="label">Slug</label>
                        <p class="control">
                            <input type="text" class="input" name="name" id="name">
                        </p>
                    </div>

                    <div class="field" v-if="permissionType == 'basic'">
                        <label for="description" class="label">Description</label>
                        <p class="control">
                            <input type="text" class="input" name="description" id="description" placeholder="Describe what this permission does">
                        </p>
                    </div>

                    <div class="field" v-if="permissionType == 'crud'">
                        <label for="resource" class="label">Resource</label>
                        <p class="control">
                            {{-- Bind với thuộc tính resource của Vue model --}}
                            <input type="text" class="input" name="resource" id="resource" v-model="resource" placeholder="The name of the resource">
                        </p>
                    </div>

                    <div class="columns m-t-20" v-if="permissionType == 'crud'">
                        <div class="column is-one-quarter">
                            {{-- Bind với thuộc tính mảng crudSelected của model,
                                mặc định 4 checkbox trong nhóm được chọn do giá trị
                                của thuộc tính mảng crudSelected --}}
                            <b-checkbox-group v-model="crudSelected">
                                <div class="field">
                                    <b-checkbox custom-value="create">Create</b-checkbox>
                                </div>
                                <div class="field">
                                    <b-checkbox custom-value="read">Read</b-checkbox>
                                </div>
                                <div class="field">
                                    <b-checkbox custom-value="update">Update</b-checkbox>
                                </div>
                                <div class="field">
                                    <b-checkbox custom-value="delete">Delete</b-checkbox>
                                </div>
                            </b-checkbox-group>
                        </div> <!-- end of .column -->

                        {{-- Sử dụng Vue directive v-bind để bind thuộc tính value của phần tử với thuộc tính mảng crudSelected của Vue data model --}}
                        <input type="hidden" name="crud_selected" :value="crudSelected">

                        <div class="column">
                            {{-- Chỉ kết xuất phần tử table khi tên table được nhập đủ 3 ký tự trở lên vao textbox có id là resource --}}
                            <table class="table" v-if="resource.length >= 3">
                                <thead>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Description</th>
                                </thead>
                                <tbody>
                                    {{-- Loop qua mảng chứa các permission được chọn --}}
                                    <tr v-for="item in crudSelected">
                                        {{-- Bind với phương thức tạo Display name cho permission --}}
                                        <td v-text="crudName(item)"></td>
                                        {{-- Bind với phương thức tạo slug cho permission --}}
                                        <td v-text="crudSlug(item)"></td>
                                        {{-- Bind với phương thức tạo description cho permission --}}
                                        <td v-text="crudDescription(item)"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button class="button is-success">Create Permission</button>
                </form>
            </div>   {{--  End coloumn  --}}
        </div>  {{--  End coloumns  --}}

    </div> <!-- end of .flex-container -->
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                permissionType: 'basic',   // Dạng permission, mặc định là basic
                resource: '',       // Tên table được cấp permission CRUD
                crudSelected: ['create', 'read', 'update', 'delete']   // Mảng chứa tên các permission, mặc định có đủ permission CRUD
            },
            methods: {
                crudName: function(item) {      // Phương thức tạo display name cho permission
                    return item.substr(0,1).toUpperCase() + item.substr(1) + " " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
                },
                crudSlug: function(item) {      // Phương thức tạo slug cho permission
                    return item.toLowerCase() + "-" + app.resource.toLowerCase();
                },
                crudDescription: function(item) { // Phương thức tạo description cho permission
                    return "Allow a User to " + item.toUpperCase() + " a " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
                }
            }
        });
    </script>
@endsection