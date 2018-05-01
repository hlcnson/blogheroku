<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;
use Session;
use Hash;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sắp xếp các record user tăng dần theo cột id, phân 10 record/trang
        $users = User::orderBy('id', 'desc')->paginate(10);

        // Kết xuất view tên views/manage/users/index.blade.php và truyền 
        // các record user
        return view('manage.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Kết xuất view hiển thị form tạo user
        return view('manage.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Phương thức lưu model user vào DB, đối tượng $request được Laravel inject tự động
        
        // Kiểm tra dữ liệu
        $this->validate($request, [
            // Phải có giá trị name được truyền về, tối đa 255 ký tự
            'name' => 'required|max:255',
            // Email phải có, hợp lệ, và không trùng trong table users
            'email' => 'required|email|unique:users'
        ]);

        // Kiểm tra có password có được nhập vào form tạo user hay không.
        // Class Request ở đây thuộc namespace Illuminate\Support\Facades\Request
        if (\Request::has('password') && !empty($request->password)) {
            // Có password, lấy giá trị của nó
            $password = trim($request->password);
        } else {
            // Không có password truyền về, tạo password ngẫu nhiên
            $length = 10;   // Độ dài password
            // Chuỗi ký tự mẫu để tạo pass
            $keyspace = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            $str = '';      // Chuỗi chứa pass
            // Hàm mb_strlen() đếm số ký tự trong chuỗi được mã hóa chuẩn 8 bit
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i=0; $i < $length; $i++) { 
                // Mỗi loop lấy ngẫu nhiên một ký tự trong $keyspace
                $str .= $keyspace[random_int(0, $max)];
            }
            $password = $str;
        }
        // Tạo đối tượng model user mới
        $user = new User();
        // Gán giá trị
        $user->name = $request->name;
        $user->email = $request->email;
        // Mã hóa password
        $user->password = Hash::make($password);
        
        
        // Lưu vào DB
        if ($user->save()) {
            // Lưu thành công
            // Điều hướng sang route users.show kèm id của user mới tạo
            return redirect()->route('users.show', $user->id);
        } else {
            // Có lỗi xảy ra
            // Ghi thông báo lỗi vào session với khóa là danger
            Session::flash('danger', 'Có lỗi xảy ra khi lưu dữ liệu vào DB.');
            return redirect()->route('users.create');
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
        // Action để hiển thị thông tin user

        // Phương thức findOrFail này sẽ quẳng ngoại lệ kiểu Illuminate\Database\Eloquent\ModelNotFoundException nếu không tìm thấy record, nếu ngoại lệ không được catch, trang 404 sẽ được trả về.
        // Phương thức with để thực hiện chức năng Eager loading, nạp sẵn các mẩu tin role 
        // tương ứng với user.
        $user = User::with('roles')->findOrFail($id);
        // Kết xuất view hiển thị kèm model user
        return view('manage.users.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Action để hiển thị view edit user

        // Lấy danh sách role từ DB
        $roles = Role::all();
        // Sử dụng tính năng Eager Loading
        $user = User::with('roles')->findOrFail($id);
        // Kết xuất view hiển thị kèm model user
        return view('manage.users.edit')->withUser($user)->with('roles', $roles);
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
        // Action cập nhật dữ liệu user
        
        // Kiểm tra dữ liệu trước khi lưu
        $this->validate($request, [
            // Phải có giá trị name được truyền về, tối đa 255 ký tự
            'name' => 'required|max:255',
            // Email phải có, hợp lệ, và không trùng trong table users
            'email' => 'required|email|unique:users,email,' . $id
        ]);
        
        // Lấy record ứng với user
        $user = User::findOrFail($id);
        // Cập nhật dữ liệu
        $user->name = $request->name;
        $user->email = $request->email;
        // Kiểm tra tùy chọn password (ở dạng group các radio button) được chọn
        if ($request->password_options == 'auto') {  // User chọn tự động tạo password mới
            // Tạo password ngẫu nhiên
            $length = 10;   // Độ dài password
            // Chuỗi ký tự mẫu để tạo pass
            $keyspace = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
            $str = '';      // Chuỗi chứa pass
            // Hàm mb_strlen() đếm số ký tự trong chuỗi được mã hóa chuẩn 8 bit
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i=0; $i < $length; $i++) { 
                // Mỗi loop lấy ngẫu nhiên một ký tự trong $keyspace
                $str .= $keyspace[random_int(0, $max)];
            }
            $password = $str;
            // Cập nhật password
            $user->password = Hash::make($password);
           
        } elseif ($request->password_options == 'manual') { // User tự nhập password mới
            // Cần kiểm tra tính hợp lệ của password tại đây
            // ...
            
            // Lấy password được post về và cập nhật
            $user->password = Hash::make(trim($request->password));
            dd($user->password);
        }
        // Lưu DB
        $user->save();
        
        // Nếu có danh sách chứa id của các role được chọn.
        // $request->roles là một chuỗi các id của các role được gán cho user, ngăn cách bằng dấu phẩy
        if ($request->roles) {
            // Cập nhật các role của user. Phương thức này cập nhật pivot table cho
            // mối quan hệ giữa bảng users và roles dựa vào mảng id của role được
            // hàm explode tạo ra.
            // dd($request->roles);
            $user->syncRoles(explode(',', $request->roles));
        }
        // Ghi thông báo vào Session
        Session::flash('success', 'Successfully update the ' . $user->display_name . ' user in the DB.');
        return redirect()->route('users.show', $id);
        // Lưu dữ liệu vào DB
        // if ($user->save()) {
        //     // Lưu thành công
        //     // Điều hướng sang route users.show kèm id của user mới tạo
        //     return redirect()->route('users.show', $id);
        // } else {
        //     // Có lỗi xảy ra
        //     // Ghi thông báo lỗi vào session với khóa là danger
        //     Session::flash('danger', 'Có lỗi xảy ra khi lưu dữ liệu vào DB.');
        //     return redirect()->route('users.edit', $id);
        // }
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
