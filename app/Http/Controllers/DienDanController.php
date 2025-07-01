<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucDienDan;
use App\Models\DienDan;
use App\Models\BinhLuan;
use Illuminate\Support\Facades\Auth;

class DienDanController extends Controller
{
    public function dienDanTheoDanhMuc($slug)
    {
        $danhMuc = DanhMucDienDan::where('slug', $slug)->first();
        
        if (!$danhMuc) {
            abort(404, 'Danh mục không tồn tại');
        }
        
        $dienDan = DienDan::where('danh_muc_id', $danhMuc->id)
                          ->where('trang_thai', 1) // Chỉ hiển thị diễn đàn hoạt động
                          ->withCount('binhLuans as total_comment')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);
// lấy ra 10 diễn đàn mới nhất
                          $dienDanMoi  = DienDan::where('trang_thai', 1)
                          ->orderBy('created_at', 'desc')
                          ->limit(10)
                          ->get();
                        // lấy ra 10 diễn đàn có lượt bình luận mới nhất
                        $dienDanBinhLuanMoi = DienDan::where('trang_thai', 1)
                        ->orderBy('last_comment', 'desc')
                        ->limit(10)
                        ->get();
        return view('user.dien-dan.dien-dan-theo-danh-muc', compact('danhMuc', 'dienDan', 'dienDanMoi', 'dienDanBinhLuanMoi'));
    }
    public function chiTietDienDan($slug)
    {
        $dienDan = DienDan::where('slug', $slug)
                          ->withCount('binhLuans as total_comment')
                          ->first();
        if($dienDan){
            $dienDan->total_view += 1;
            $dienDan->save();
        }
        
        if (!$dienDan) {
            abort(404, 'Diễn đàn không tồn tại');
        }
        
        // Lấy danh mục thông qua relationship
        $danhMuc = $dienDan->danhMucDienDan;
        
        if (!$danhMuc) {
            abort(404, 'Danh mục không tồn tại');
        }
        
        // Lấy danh sách bình luận
        $binhLuans = BinhLuan::where('post_id', $dienDan->id)
                             ->with('user')
                             ->orderBy('created_at', 'desc')
                             ->get();
        return view('user.dien-dan.chi-tiet-dien-dan', compact('dienDan', 'danhMuc', 'binhLuans'));
    }

    /**
     * Lưu bình luận mới
     */
    public function storeComment(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:dien_dan,id',
            'content' => 'required|string|max:1000',
        ]);

        // Kiểm tra người dùng đã đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để bình luận'
            ], 401);
        }

        try {
            $binhLuan = BinhLuan::create([
                'post_id' => $request->post_id,
                'user_id' => Auth::id(),
                'content' => $request->content,
            ]);

            // Load thông tin user để trả về
            $binhLuan->load('user');
            //cập nhật lại last_comment với thời gian hiện tại
            $dienDan = DienDan::find($request->post_id);
            $dienDan->last_comment = now();
            $dienDan->save();
            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được gửi thành công!',
                'comment' => [
                    'id' => $binhLuan->id,
                    'content' => $binhLuan->content,
                    'created_at' => $binhLuan->created_at->format('d/m/Y H:i'),
                    'user' => [
                        'id' => $binhLuan->user->id,
                        'name' => $binhLuan->user->name,
                        'avatar' => $binhLuan->user->avatar ?? null,
                    ]
                ],
                'total_comment' => $dienDan->binhLuans()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi bình luận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách bình luận của một diễn đàn
     */
    public function getComments(Request $request, $postId)
    {
        $request->validate([
            'post_id' => 'required|exists:dien_dan,id',
        ]);

        try {
            $binhLuans = BinhLuan::where('post_id', $postId)
                                 ->with('user')
                                 ->orderBy('created_at', 'desc')
                                 ->get();

            $comments = $binhLuans->map(function ($binhLuan) {
                return [
                    'id' => $binhLuan->id,
                    'content' => $binhLuan->content,
                    'created_at' => $binhLuan->created_at->format('d/m/Y H:i'),
                    'user' => [
                        'id' => $binhLuan->user->id,
                        'name' => $binhLuan->user->name,
                        'avatar' => $binhLuan->user->avatar ?? null,
                    ]
                ];
            });

            return response()->json([
                'success' => true,
                'comments' => $comments,
                'total' => $comments->count(),
                'total_comment' => $comments->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải bình luận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa bình luận
     */
    public function deleteComment($commentId)
    {
        // Kiểm tra người dùng đã đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện hành động này'
            ], 401);
        }

        try {
            $binhLuan = BinhLuan::findOrFail($commentId);

            // Kiểm tra quyền xóa (chỉ người tạo bình luận hoặc admin mới được xóa)
            if ($binhLuan->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa bình luận này'
                ], 403);
            }

            $binhLuan->delete();

            // Cập nhật last_comment nếu còn bình luận khác
            $dienDan = DienDan::find($binhLuan->post_id);
            if ($dienDan && $dienDan->binhLuans()->count() > 0) {
                $lastComment = $dienDan->binhLuans()->orderBy('created_at', 'desc')->first();
                $dienDan->last_comment = $lastComment->created_at;
            } else {
                $dienDan->last_comment = null;
            }
            $dienDan->save();

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được xóa thành công!',
                'total_comment' => $dienDan->binhLuans()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa bình luận: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật bình luận
     */
    public function updateComment(Request $request, $commentId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Kiểm tra người dùng đã đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thực hiện hành động này'
            ], 401);
        }

        try {
            $binhLuan = BinhLuan::findOrFail($commentId);

            // Kiểm tra quyền cập nhật (chỉ người tạo bình luận mới được cập nhật)
            if ($binhLuan->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền cập nhật bình luận này'
                ], 403);
            }

            $binhLuan->update([
                'content' => $request->content,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bình luận đã được cập nhật thành công!',
                'comment' => [
                    'id' => $binhLuan->id,
                    'content' => $binhLuan->content,
                    'updated_at' => $binhLuan->updated_at->format('d/m/Y H:i'),
                ],
                'total_comment' => $binhLuan->dienDan->binhLuans()->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật bình luận: ' . $e->getMessage()
            ], 500);
        }
    }
    public function dienDanMoi()
    {
        $dienDanMoi = DienDan::where('trang_thai', 1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('user.dien-dan.dien-dan-moi', compact('dienDanMoi'));
    }
    public function dienDanQuanTam()
    {
        $dienDanQuanTam = DienDan::where('trang_thai', 1)
        ->orderBy('total_view', 'desc')
        ->paginate(10);
        return view('user.dien-dan.dien-dan-hot', compact('dienDanQuanTam'));
    }
    public function dienDanBinhLuanMoi()
    {
        $dienDanBinhLuanMoi = DienDan::where('trang_thai', 1)
        ->orderBy('last_comment', 'desc')
        ->paginate(10);
        return view('user.dien-dan.dien-dan-nhon-nhip', compact('dienDanBinhLuanMoi'));
    }
    public function dienDanCuaToi()
    {
        $dienDanCuaToi = DienDan::where('nguoi_tao', Auth::id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('user.dien-dan.dien-dan-cua-toi', compact('dienDanCuaToi'));
    }
}
