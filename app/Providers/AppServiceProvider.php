<?php

namespace App\Providers;

use App\View\Composers\PengaturanUmumComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        // Share pengaturan umum to all views
        View::composer('*', PengaturanUmumComposer::class);

        // Set session lifetime from database
        try {
            if (\Schema::hasTable('pengaturan_umum')) {
                $pengaturan = \App\Models\PengaturanUmum::first();
                if ($pengaturan && $pengaturan->session_lifetime) {
                    config(['session.lifetime' => $pengaturan->session_lifetime]);
                }
            }
        } catch (\Exception $e) {
            // Silence error if table doesn't exist yet or during migration
        }

        if (request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
