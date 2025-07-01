<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DanhMucDienDan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Chia sẻ danh sách danh mục diễn đàn và thông tin user cho tất cả các view
        View::composer('*', function ($view) {
            $view->with([
                'danhMucDienDan' => DanhMucDienDan::orderBy('ten_danh_muc', 'asc')->get(),
                'user' => Auth::user()
            ]);
        });
    }
}
