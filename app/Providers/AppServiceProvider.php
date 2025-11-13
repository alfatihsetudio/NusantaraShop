<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Jika kamu memiliki routes/admin.php, load file tersebut
        $adminRoutes = base_path('routes/admin.php');

        if (file_exists($adminRoutes)) {
            Route::middleware('web')
                ->group($adminRoutes);
        }

        // Di sini nanti bisa ditambahkan view composers (mis. share cartCount)
        // atau binding lain yang perlu di-boot pada tiap request.
    }
}
