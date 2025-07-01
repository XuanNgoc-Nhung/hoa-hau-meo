<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucDienDan;
use App\Models\DienDan;
use App\Models\User;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function danhMucDienDan()
    {
        $danhMucDienDan = DanhMucDienDan::orderBy('created_at', 'desc')->get();
        return view('admin.danh-muc-dien-dan', compact('danhMucDienDan'));
    }

    public function danhSachDienDan()
    {
        $danhSachDienDan = DienDan::with(['danhMucDienDan', 'user'])->orderBy('created_at', 'desc')->get();
        $danhMucDienDan = DanhMucDienDan::all();
        return view('admin.danh-sach-dien-dan', compact('danhSachDienDan', 'danhMucDienDan'));
    }

    /**
     * Tạo slug duy nhất cho diễn đàn
     */
    private function generateUniqueSlug($tenDienDan, $excludeId = null)
    {
        $baseSlug = Str::slug($tenDienDan);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = DienDan::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Tạo slug duy nhất cho danh mục
     */
    private function generateUniqueCategorySlug($tenDanhMuc, $excludeId = null)
    {
        $baseSlug = Str::slug($tenDanhMuc);
        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = DanhMucDienDan::where('slug', $slug);
            
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function taoDienDan(Request $request)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc_dien_dan,id',
            'ten_dien_dan' => 'required|string|max:255',
            'vi_tri' => 'required|string|max:255',
            'the_tim_kiem' => 'nullable|string',
            'so_dien_thoai' => 'nullable|string|max:20',
            'chi_tiet' => 'nullable|string',
            'muc_gia' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1',
            'hinh_anh' => 'nullable|string',
        ]);

        $data = [
            'danh_muc_id' => $request->danh_muc_id,
            'ten_dien_dan' => $request->ten_dien_dan,
            'slug' => $this->generateUniqueSlug($request->ten_dien_dan),
            'vi_tri' => $request->vi_tri,
            'the_tim_kiem' => $request->the_tim_kiem,
            'so_dien_thoai' => $request->so_dien_thoai,
            'chi_tiet' => $request->chi_tiet,
            'muc_gia' => $request->muc_gia,
            'trang_thai' => $request->trang_thai,
            'nguoi_tao' => auth()->id(),
            'hinh_anh' => $request->hinh_anh ?: null,
        ];

        $dienDan = DienDan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm diễn đàn thành công!',
            'data' => $dienDan->load(['danhMucDienDan', 'user'])
        ]);
    }

    public function updateDienDan(Request $request, $id)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc_dien_dan,id',
            'ten_dien_dan' => 'required|string|max:255',
            'vi_tri' => 'required|string|max:255',
            'the_tim_kiem' => 'nullable|string',
            'so_dien_thoai' => 'nullable|string|max:20',
            'chi_tiet' => 'nullable|string',
            'muc_gia' => 'nullable|string|max:255',
            'trang_thai' => 'required|in:0,1',
            'hinh_anh' => 'nullable|string',
        ]);

        $dienDan = DienDan::findOrFail($id);
        
        $data = [
            'danh_muc_id' => $request->danh_muc_id,
            'ten_dien_dan' => $request->ten_dien_dan,
            'slug' => $this->generateUniqueSlug($request->ten_dien_dan, $id),
            'vi_tri' => $request->vi_tri,
            'the_tim_kiem' => $request->the_tim_kiem,
            'so_dien_thoai' => $request->so_dien_thoai,
            'chi_tiet' => $request->chi_tiet,
            'muc_gia' => $request->muc_gia,
            'trang_thai' => $request->trang_thai,
            'hinh_anh' => $request->hinh_anh ?: null,
        ];

        $dienDan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật diễn đàn thành công!',
            'data' => $dienDan->load(['danhMucDienDan', 'user'])
        ]);
    }

    public function deleteDienDan($id)
    {
        $dienDan = DienDan::findOrFail($id);
        
        // Xóa hình ảnh nếu có
        if ($dienDan->hinh_anh && file_exists(public_path($dienDan->hinh_anh))) {
            unlink(public_path($dienDan->hinh_anh));
        }
        
        $dienDan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa diễn đàn thành công!'
        ]);
    }

    public function getDienDan($id)
    {
        $dienDan = DienDan::with(['danhMucDienDan', 'user'])->findOrFail($id);
        return response()->json($dienDan);
    }

    public function storeDanhMuc(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255|unique:danh_muc_dien_dan,ten_danh_muc',
            'ghi_chu' => 'nullable|string'
        ]);

        $danhMuc = DanhMucDienDan::create([
            'ten_danh_muc' => $request->ten_danh_muc,
            'slug' => $this->generateUniqueCategorySlug($request->ten_danh_muc),
            'ghi_chu' => $request->ghi_chu
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm danh mục thành công!',
            'data' => $danhMuc
        ]);
    }

    public function updateDanhMuc(Request $request, $id)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255|unique:danh_muc_dien_dan,ten_danh_muc,' . $id,
            'ghi_chu' => 'nullable|string'
        ]);

        $danhMuc = DanhMucDienDan::findOrFail($id);
        $danhMuc->update([
            'ten_danh_muc' => $request->ten_danh_muc,
            'slug' => $this->generateUniqueCategorySlug($request->ten_danh_muc, $id),
            'ghi_chu' => $request->ghi_chu
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật danh mục thành công!',
            'data' => $danhMuc
        ]);
    }

    public function deleteDanhMuc($id)
    {
        $danhMuc = DanhMucDienDan::findOrFail($id);
        $danhMuc->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa danh mục thành công!'
        ]);
    }

    public function getDanhMuc($id)
    {
        $danhMuc = DanhMucDienDan::findOrFail($id);
        return response()->json($danhMuc);
    }
}
