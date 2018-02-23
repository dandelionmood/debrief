<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * Taken from https://github.com/parsedown/laravel project to allow for Parsedown extension.
 *
 * Class ParsedownServiceProvider
 * @package App\Providers
 */
class ParsedownServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->compiler()->directive('parsedown', function ($expression) {
            return "<?php echo parsedown($expression); ?>";
        });

        $this->compiler()->directive('parsedown_line', function ($expression) {
            return "<?php echo parsedown_line($expression); ?>";
        });
    }

    /**
     * @return BladeCompiler
     */
    protected function compiler()
    {
        return app('view')->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('parsedown', function () {
            return \App\Services\Parsedown::instance();
        });
    }
}
