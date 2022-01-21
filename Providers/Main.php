<?php

namespace Modules\TcbAmazonSync\Providers;

use App\Models\Common\Item;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as Provider;

class Main extends Provider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutes();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadViewComponents();
        $this->loadTranslations();
        $this->loadMigrations();
        //$this->loadConfig();
        Item::observe('Modules\TcbAmazonSync\Observers\Common\Item');
        View::composer(
            ['common.items.create', 'common.items.edit'], 'Modules\TcbAmazonSync\Http\ViewComposers\Items'
        );
        View::composer(
            ['tcb-amazon-sync::items.edit'], 'Modules\TcbAmazonSync\Http\ViewComposers\Categories'
        );
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'tcb-amazon-sync');
    }

    /**
     * Load view components.
     *
     * @return void
     */
    public function loadViewComponents()
    {
        Blade::componentNamespace('Modules\TcbAmazonSync\View\Components', 'tcb-amazon-sync');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'tcb-amazon-sync');
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    public function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'tcb-amazon-sync');
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (app()->routesAreCached()) {
            return;
        }

        $routes = [
            'admin.php',
            'portal.php',
        ];

        foreach ($routes as $route) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/' . $route);
        }
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
}
