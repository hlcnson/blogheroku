<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ACTION KẾT XUẤT VIEW HIỂN THỊ DANH MỤC ROLE

        // Lấy các record từ DB
        $roles = Role::all();
        // Kết xuất và truyền dữ liệu cho view
        return view('manage.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // ACTION KẾT XUẤT VIEW THÊM ROLE MỚI

        // Lấy tất cả record permission để hiển thị ra view và cho phép user chọn để gán cho một role
        $permissions = Permission::all();
        return view('manage.roles.create')->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ACTION LƯU DỮ LIỆU ROLE MỚI

        // Kiểm tra dữ liệu
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'name' => 'required|max:255|alpha_dash|unique:roles,name',
            'description' => 'sometimes|max:255'     // sometimes: Nếu có mới kiểm tra
        ]);

        // dd($request->permissions);

        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        
        // Nếu có danh sách chứa id của các permission được chọn, lưu vào DB.
        // $request->permissions là một chuỗi các id của các permission được gán cho role, ngăn cách bằng dấy phẩy
        if ($request->permissions) {
            // Cập nhật các permission của role. Phương thức này cập nhật pivot table cho
            // mối quan hệ giữa bảng roles và permissions dựa vào mảng id của permission được
            // hàm explode tạo ra.
            $role->syncPermissions(explode(',', $request->permissions));
        }
        // Ghi thông báo vào Session
        Session::flash('success', 'Successfully create the new ' . $role->display_name . ' role in the DB.');
        return redirect()->route('roles.show', $role->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // ACTION KẾT XUẤT VIEW HIỂN THỊ CHI TIẾT ROLE

        // Sử dụng tính năng Eager Loading của Laravel để load trước
        // các record Permission của role (mặc định các record Permission chỉ được nạp khi 
        // relationship property của record role được truy cập)
        $role = Role::where('id', $id)->with('permissions')->first();
        // Có thể thay bằng cú pháp này
        // $role = Role::with('permissions')->findOrFail($id); 
        return view('manage.roles.show')->with('role', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // ACTION KẾT XUẤT VIEW EDIT ROLE

        // Lấy record role cần edit. Sử dụng tính năng Eager Loading của Laravel để load trước
        // các record Permission của role (mặc định các record Permission chỉ được nạp khi 
        // relationship property của record role được truy cập)
        $role = Role::where('id', $id)->with('permissions')->first();
        // Lấy tất cả record permission để hiển thị ra view và cho phép user chọn để gán cho một role
        $permissions = Permission::all();
        // dd([$role, $permissions]);
        return view('manage.roles.edit')->with('role', $role)->with('permissions', $permissions);
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
        // ACTION CẬP NHẬT DỮ LIỆU ROLE

        // Kiểm tra dữ liệu
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255'     // sometimes: Nếu có mới kiểm tra
        ]);

        // dd($request->permissions);

        $role = Role::findOrFail($id);
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        
        // Nếu có danh sách chứa id của các permission được chọn.
        // $request->permissions là một chuỗi các id của các permission được gán cho role, ngăn cách bằng dấy phẩy
        if ($request->permissions) {
            // Cập nhật các permission của role. Phương thức này cập nhật pivot table cho
            // mối quan hệ giữa bảng roles và permissions dựa vào mảng id của permission được
            // hàm explode tạo ra.
            $role->syncPermissions(explode(',', $request->permissions));
        }
        // Ghi thông báo vào Session
        Session::flash('success', 'Successfully update the ' . $role->display_name . ' role in the DB.');
        return redirect()->route('roles.show', $id);
        
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
