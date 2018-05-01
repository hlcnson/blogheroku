<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Session;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Action kết xuất view hiển thị danh mục permission

        // Lấy các record từ DB
        $permissions = Permission::all();
        // Kết xuất view views/manage/permissions/index.blade.php
        return view('manage.permissions.index')->withPermissions($permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ACTION KẾT XUẤT VIEW TẠO PERMISSION
        // Kết xuất view
        return view('manage.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ACTION LƯU MỘT PERMISSION MỚI VÀO DB
        // Có 2 dạng permission:
        //     - Basic: Permission để thực hiện một tác vụ
        //     - CRUD: Permission để thực hiện các tác vụ CRUD trên một table

        // Kiểm tra dạng permission
        if ($request->permission_type == 'basic') {     // Dạng basic, chỉ tạo một permission
            // Kiểm tra dữ liệu được post về
            $this->validate($request, [
                'display_name' => 'required|max:255',
                // name bắt buộc có, tối đa 255 ký tự, là ký tự, ký sô, dấu - hoặc _
                // và duy nhất trong bảng permissions tại cột name
                'name' => 'required|max:25|alphadash|unique:permissions,name',
                // Dữ liệu decscription nếu có được post về thì tối đa là 255 ký tự
                'description' => 'sometimes|max:255'
            ]);
            // Tạo model
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            // Lưu vào DB
            $permission->save();
            // Ghi thông báo vào Session, khóa là success
            Session::flash('success', 'Permission has been successfully added');
            // Điều hướng sang route tên permissions.index
            return redirect()->route('permissions.index');
        } elseif ($request->permission_type == 'crud') {    // Dạng CRUD, tạo nhiều permission cùng lúc
            // Kiểm tra dữ liệu
            $this->validate($request, [
                // resource bắt buộc có, từ 3-100 ký tự (không phải ký số)
                'resource' => 'required|min:3|max:100|alpha'
            ]);
            // Tách các phần ngăn cách bằng ký tự dấu , trong chuỗi permission của
            // dữ liệu input (dạng các checkbox C R U D) được post về tên crud_selected thành một mảng
            $crud = explode(',', $request->crud_selected);
            // Kiểm tra xem có permission nào được chọn hay không
            if (count($crud) > 0) {     // Có permission được chọn
                foreach ($crud as $x) {     // Duyệt từng permisson
                    // Tạo slug cho permission, resource là tên table được cấp quyền crud
                    $slug = strtolower($x) . '-' . strtolower($request->resource);
                    // Hàm ucwords chuyển ký tự đầu của các tư từ trong chuỗi thành in hoa
                    $display_name = ucwords($x . " " . $request->resource);
                    $description = "Allows a user to " . strtoupper($x) . ' a ' . ucwords($request->resource);
                    // Tạo model
                    $permission = new Permission();
                    $permission->name = $slug;
                    $permission->display_name = $display_name;
                    $permission->description = $description;
                    // Lưu vào DB
                    $permission->save();
                }
                // Ghi thông báo vào Session, khóa là success
                Session::flash('success', 'Permissions were all successfully added');
                // Điều hướng sang route tên permissions.index
                return redirect()->route('permissions.index');
            } else {    // Không có permission CRUD nào được chọn
                // Điều hướng trở lại route tạo permission. Phương thức withInput
                // ghi dữ liệu đã được post về trong HTTP Request hiện tại
                // vào Session đêr trang được điều hướng đến có thể truy cập vào
                // bằng phương thức old.
                return redirect()->route('permissions.create')->withInput();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ACTION HIỂN THỊ CHI TIẾT MỘT PERMISSION

        $permission = Permission::findOrFail($id);
        // Kết xuất và truyền cho view biến tên $permission
        return view('manage.permissions.show')->withPermission($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ACTION KẾT XUẤT VIEW EDIT PERMISSION

        $permission = Permission::findOrFail($id);
        // Kết xuất và truyền cho view biến tên $permission
        return view('manage.permissions.edit')->withPermission($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ACTION CẬP NHẬT DỮ LIỆU CỦA MỘT PERMISSION

        // Kiểm tra dữ liệu
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'
        ]);
        // Lấy record tương ứng
        $permission = Permission::findOrFail($id);
        // Cập nhật dữ liệu, không cập nhật name, slug
        $permission->display_name = $request->name;
        $permission->description = $request->description;
        $permission->save();
        // Ghi thông báo vào session, khóa success
        Session::flash('success', 'Updated the '. $permission->display_name . ' permission.');
        // Điều hướng sang route
        return redirect()->route('permisions.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
