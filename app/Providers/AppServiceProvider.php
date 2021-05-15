<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
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
    }
}
