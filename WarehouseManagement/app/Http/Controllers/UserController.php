<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    public function index()
    {
        $Users = User::get();
        
        return view('taikhoan.index', compact('Users'));
    }

    public function show($id)
    {
        $User = User::findOrFail($id);
        return view('auth.profile', compact('User'));
    }

    public function changeRole($id)
    {
        $user = User::findOrFail($id);
        $user->Role = $user->Role === 'Admin' ? 'Nhan_Vien' : 'Admin';

        $user->save();

        Alert::success('Thành công', 'Thay đổi vai trò thành công!');
        return back();
    }

    public function showUser($id)
    {
        $User = User::findOrFail($id);
        
        return view('taikhoan.show', compact('User'));
    }



    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Mật khẩu cũ không được để trống!',
            'password.required' => 'Mật khẩu mới không được để trống!',
            'password.min' => 'Bạn phải nhập ít nhất 8 kí tự!'
        ]);

        $User = Auth::User();

        if (Hash::check($request->old_password, $User->password)) {
            $User->update([
                'password' => Hash::make($request->password)
            ]);

            Auth::logout();

            Alert::success('Thành công', 'Thay đổi mật khẩu thành công. Xin vui lòng đăng nhập lại!');
            return redirect()->route('login');
        }

        return back()->withErrors(['old_password' => 'Mật khẩu cũ bạn vừa nhập không chính xác!']);
    }

    public function updateProfile(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'dia_chi' => 'max:255',
        'sdt' => 'nullable|regex:/^(0)[0-9]{9}$/',
        'gioi_tinh' => 'required|in:Nam,Nữ,Khác|max:255',
        'change_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', 
    ], [
        'name.required' => 'Tên không được bỏ trống',
        'name.string' => 'Tên phải là chuỗi',
        'name.max' => 'Tên không được vượt quá :max ký tự',
        'dia_chi.max' => 'Địa chỉ không được vượt quá :max ký tự',
        'sdt.regex' => 'Số điện thoại không đúng định dạng',
        'gioi_tinh.required' => 'Giới tính không được bỏ trống',
        'gioi_tinh.in' => 'Giới tính phải là một trong các giá trị: Nam, Nữ, Khác',
        'gioi_tinh.max' => 'Giới tính không được vượt quá :max ký tự',
        'change_img.image' => 'Tệp tải lên phải là hình ảnh',
        'change_img.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, gif, hoặc svg',
    ]);
    
    $user = Auth::user();
    if ($request->hasFile('change_img')) {
        if ($user->image && $user->image != 'user.png' && file_exists(public_path('assets/images/' . $user->image))) {
            unlink(public_path('assets/images/' . $user->image));
        }

        // Lưu ảnh mới
        $imageName = time() . '.' . $request->file('change_img')->extension(); 
        $request->file('change_img')->move(public_path('assets/images'), $imageName);
    } else {
        $imageName = $user->image;
    }
    $status = $user->update([
        'Name' => $request->name,
        'Dia_Chi' => $request->dia_chi,
        'SDT' => $request->sdt,
        'Gioi_Tinh' => $request->gioi_tinh,
        'image' => $imageName,
    ]);

    // Thông báo kết quả
    if ($status) {
        Alert::success('Thành công', 'Thay đổi thông tin cá nhân thành công!');
        return back();
    } else {
        Alert::error('Thất bại', 'Thay đổi thông tin cá nhân thất bại. Vui lòng kiểm tra lại thông tin bạn vừa nhập!')->autoClose(5000);
        return back();
    }
}


    public function delete($id)
    {
        User::destroy($id);

        Alert::success('Thành công', 'Xóa tài khoản thành công!');
        return back();
    }
}
