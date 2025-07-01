<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\HinhAnh; 
use App\Models\DanhMucDienDan;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function registerPost(Request $request)
    {
        Log::info('Post đăng ký tài khoản');
        try{
            $check = User::where('email',$request->email)->first();
            if($check){
                return redirect()->route('register')->with('error','Email đã tồn tại');
            }
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            User::create($request->all());
            return redirect()->route('login')->with('success','Đăng ký thành công. Vui lòng đăng nhập để tiếp tục.');
        }
        catch(\Exception $e){
            Log::error('Lỗi đăng ký tài khoản: '.$e->getMessage());
            return redirect()->route('register')->with('error','Đăng ký tài khoản thất bại');
        }
    }
    public function loginPost(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);
            if(Auth::attempt($request->only('email','password'))){
                return redirect()->route('user.dashboard');
            }
            return redirect()->route('login')->with('error','Tài khoản hoặc mật khẩu không chính xác');
        }
        catch(\Exception $e){
            Log::error('Lỗi đăng nhập: '.$e->getMessage());
            return redirect()->route('login')->with('error','Đăng nhập thất bại');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
    public function dashboard()
    {
        $danhMucs = DanhMucDienDan::orderBy('ten_danh_muc', 'asc')->get();
        return view('user.dashboard', compact('danhMucs'));
    }
    public function profile()
    {
        return view('user.profile');
    }
    public function uploadFile()
    {
        $images = HinhAnh::where('user_id', Auth::user()->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        return view('user.upload-file', compact('images'));
    }
    public function uploadFilePost(Request $request)
    {
        try {
            $request->validate([
                'images' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3072', // 3MB mỗi ảnh
            ]);
            
            $files = $request->file('images');
            if (count($files) > 12) {
                $message = 'Chỉ được upload tối đa 12 hình ảnh!';
                if ($request->ajax()) {
                    return response()->json([
                        'message' => $message,
                        'urls' => []
                    ], 422);
                }
                return back()->with('error', $message);
            }
            
            $urls = [];
            $destinationPath = public_path('uploads/images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            foreach ($files as $file) {
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $urls[] = asset('uploads/images/' . $filename);
                HinhAnh::create([
                    'user_id' => Auth::user()->id,
                    'path' => $filename
                ]);
            }
            
            $message = 'Upload thành công ' . count($urls) . ' hình ảnh!';
            
            if ($request->ajax()) {
                return response()->json([
                    'message' => $message,
                    'urls' => $urls
                ]);
            }
            
            return back()->with('success', $message)->with('urls', $urls);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Dữ liệu không hợp lệ',
                    'urls' => [],
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            Log::error('Lỗi upload file: ' . $e->getMessage());
            $message = 'Có lỗi xảy ra khi upload file!';
            
            if ($request->ajax()) {
                return response()->json([
                    'message' => $message,
                    'urls' => []
                ], 500);
            }
            
            return back()->with('error', $message);
        }
    }
    
    public function deleteImage($id)
    {
        try {
            $image = HinhAnh::where('id', $id)
                            ->where('user_id', Auth::user()->id)
                            ->first();
            
            if (!$image) {
                return response()->json(['message' => 'Không tìm thấy hình ảnh'], 404);
            }
            
            // Xóa file từ server
            $filePath = public_path('uploads/images/' . $image->path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Xóa record từ database
            $image->delete();
            
            return response()->json(['message' => 'Xóa hình ảnh thành công']);
            
        } catch (\Exception $e) {
            Log::error('Lỗi xóa hình ảnh: ' . $e->getMessage());
            return response()->json(['message' => 'Có lỗi xảy ra khi xóa hình ảnh'], 500);
        }
    }
    public function taiKhoan()
    {
        return view('user.tai-khoan');
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'name' => 'required|string|max:255',
                'so_dien_thoai' => 'nullable|string|max:20',
                'dia_chi' => 'nullable|string|max:500',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
            ]);

            $data = [
                'name' => $request->name,
                'so_dien_thoai' => $request->so_dien_thoai,
                'dia_chi' => $request->dia_chi,
            ];

            // Xử lý upload avatar
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = uniqid() . '_' . time() . '.' . $avatar->getClientOriginalExtension();
                
                // Tạo thư mục nếu chưa tồn tại
                $destinationPath = public_path('uploads/avatars');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                // Xóa avatar cũ nếu có
                if ($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar))) {
                    unlink(public_path('uploads/avatars/' . $user->avatar));
                }
                
                // Upload avatar mới
                $avatar->move($destinationPath, $filename);
                $data['avatar'] = $filename;
            }

            $user->update($data);

            return redirect()->route('user.tai-khoan')->with('success', 'Cập nhật thông tin thành công!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật thông tin người dùng: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật thông tin!')->withInput();
        }
    }
}
