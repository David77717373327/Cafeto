<?php

namespace Modules\CAFETO\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;

class CAFETOServiceProvider extends ServiceProvider
{
    /**
     * The module name in uppercase.
     *
     * @var string
     */
    protected $moduleName = 'CAFETO';

    /**
     * The module name in lowercase.
     *
     * @var string
     */
    protected $moduleNameLower = 'cafeto';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        // Register middleware
        $router->aliasMiddleware('skip.csrf.formulations', \Modules\CAFETO\Http\Middleware\SkipCsrfForFormulations::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register the module's configuration.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configPath = module_path($this->moduleName, 'Config/config.php');

        $this->publishes([
            $configPath => config_path("{$this->moduleNameLower}.php"),
        ], 'config');

        $this->mergeConfigFrom($configPath, $this->moduleNameLower);
    }

    /**
     * Register the module's views.
     *
     * @return void
     */
    protected function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', "{$this->moduleNameLower}-module-views"]);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register the module's translations.
     *
     * @return void
     */
    protected function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        $this->loadTranslationsFrom(
            is_dir($langPath) ? $langPath : module_path($this->moduleName, 'Resources/lang'),
            $this->moduleNameLower
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the paths for publishable views.
     *
     * @return array
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths', []) as $path) {
            $moduleViewPath = "{$path}/modules/{$this->moduleNameLower}";
            if (is_dir($moduleViewPath)) {
                $paths[] = $moduleViewPath;
            }
        }

        return $paths;
    }
}