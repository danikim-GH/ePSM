<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
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
        View::composer('partials.navbar', function ($view) {

            $user = Auth::guard('lampirana')->user();
            if (!$user) {
                $view->with([
                    'mainMenu' => collect(),
                    'submenus' => collect()
                ]);
                return;
            }

            $userlevel = $user->userlevel;

            // Proper debug logging: record the resolved user level and a minimal user identifier
            // so developers can trace menu generation without echoing to output.
            Log::debug('Navbar composer: userlevel resolved', [
                'userlevel' => $userlevel,
                // include a minimal non-sensitive identifier (NoKP) if available for tracing
                'user_no_kp' => $user->NoKP ?? null,
            ]);

            // level 1
            $mainMenu = DB::table('menu')
                ->where('menu_level', 1)
                ->whereRaw('FIND_IN_SET(?, REPLACE(userlevel," ",""))', [$userlevel])
                ->orderBy('menu_sort')
                ->get();

            // level 2
            $submenus = DB::table('menu')
                ->where('menu_level', 2)
                ->whereRaw('FIND_IN_SET(?, REPLACE(userlevel," ",""))', [$userlevel])
                ->orderBy('menu_sort')
                ->get()
                ->groupBy('menu_idb'); // group by id parent

            $view->with(compact('mainMenu', 'submenus'));
        });

    }
}
