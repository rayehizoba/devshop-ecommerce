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
            if ($string) {
                if (gettype($field) === "array") {
                    $first = array_shift($field);
                    $this->where($first, 'like', '%'.$string.'%');
                    foreach ($field as $each) {
                        $this->orWhere($each, 'like', '%'.$string.'%');
                    }
                } elseif (gettype($field) === "string") {
                    return $this->where($field, 'like', '%'.$string.'%');
                }
            }
            return $this;
        });

        Blade::directive('dateforhumans', function ($expression) {
            return "<?php echo ($expression)->format('M, d Y'); ?>";
        });

        Blade::directive('diffdateforhumans', function ($expression) {
            return "<?php echo \Carbon\Carbon::createFromTimeStamp(strtotime($expression))->diffForHumans(); ?>";
        });

        Blade::directive('admin', function () {
            return "<?php if (Auth::check() && Auth::user()->isAdmin()): ?>";
        });

        Blade::directive('public', function () {
            return "<?php if ((Auth::check() && !Auth::user()->isAdmin()) || !Auth::check()): ?>";
        });

        Blade::directive('priceforhumans', function ($expression) {
            return "<?php if($expression === 0) echo 'Free'; else echo '$'.$expression ?>";
        });
    }
}
