<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });

        Blade::directive('dateforhumans', function ($expression) {
            return "<?php echo ($expression)->format('M, d Y'); ?>";
        });

        Blade::directive('diffdateforhumans', function ($expression) {
            return "<?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($expression))->diffForHumans(); ?>";
        });

        Blade::directive('admin', function ($expression) {
            $conditon = false;

            if (Auth::check()) {
                $condition = Auth::user()->is_admin;
            }

            return "<?php if ($condition) { ?>";
        });

        Blade::directive('notadmin', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php } ?>";
        });

        Blade::directive('initials', function ($expression) {
            $words = explode(" ", $expression);
            $acronym = "";

//            for ($i=0; $i<count($words) && $i<2; $i++) {
//                $acronym .= $words[$i][0];
//            }
            return "<?php echo {$expression} {$acronym}; ?>";
        });
    }
}
