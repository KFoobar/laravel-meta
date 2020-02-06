<?php

namespace KFoobar\LaravelMeta;

use KFoobar\LaravelMeta\Meta;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('meta', function () {
            return new Meta();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['meta'];
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('setMeta', function ($arguments) {
            return "<?php echo Meta::set($arguments); ?>";
        });

        Blade::directive('getMeta', function ($arguments) {
            return "<?php echo Meta::get($arguments); ?>";
        });

        Blade::directive('getTag', function ($arguments) {
            return "<?php echo Meta::tag($arguments); ?>";
        });

        Blade::directive('hasMeta', function ($arguments) {
            return "<?php if (Meta::has($arguments)) { ?>";
        });

        Blade::directive('endhasMeta', function () {
            return "<?php } ?>";
        });
    }
}
