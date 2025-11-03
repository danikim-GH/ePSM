<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
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
        //
        View::composer('partials.navbar', function ($view) {
        $mainMenu = DB::table('menu')
            ->where('menu_level', 1)
            ->orderBy('menu_sort', 'asc')
            ->get();

        $view->with('mainMenu', $mainMenu);
    });
    }
}
