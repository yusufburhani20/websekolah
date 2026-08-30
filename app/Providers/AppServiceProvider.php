<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\NavigationMenu;

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
        View::composer('*', function ($view) {
            if (!request()->is('admin*') && !request()->is('livewire*')) {
                static $settings = null;
                static $menus = null;
                if (!$settings) {
                    $settings = SiteSetting::first() ?? new SiteSetting();
                    $menus = NavigationMenu::with('children')->where('status', 'aktif')->where('parent_id', 0)->orderBy('urutan')->get();
                }
                $view->with(compact('settings', 'menus'));
            }
        });
    }
}