<?php

namespace Modules\TcbAmazonSync\Providers;

use App\Models\Common\Item;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
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
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\TcbAmazonSync\Console\DownloadOrders::class,
                \Modules\TcbAmazonSync\Console\UpdateItemsOnAmazon::class,
                \Modules\TcbAmazonSync\Console\UpdateItemsInErp::class,
            ]);
        }
        Item::observe('Modules\TcbAmazonSync\Observers\Common\Item');
        View::composer(
            ['layouts.admin', 'partials.admin.footer'], 'Modules\TcbAmazonSync\Http\ViewComposers\Admin'
        );
        View::composer(
            ['partials.admin.navbar'], 'Modules\TcbAmazonSync\Http\ViewComposers\NavBar'
        );
        View::composer(
            ['common.items.create', 'common.items.edit'], 'Modules\TcbAmazonSync\Http\ViewComposers\Items'
        );
        View::composer(
            ['tcb-amazon-sync::items.edit'], 'Modules\TcbAmazonSync\Http\ViewComposers\Categories'
        );

        $this->registerStorage();
    
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/filesystems.php',
            'digitalocean'
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

    protected function registerStorage()
    {
        $module= 'tcb-amazon-sync';
        Config::set('filesystems.disks.do', [
            'driver' => 's3',
            'key' => 'Q3IGNROGHI2VGP26UG5U',
            'secret' => 'uorBsrtCWgVE+JaamtozLYY+Ad/zdKjh/Uz/o6KWJT4',
            'region' => 'fra1',
            'bucket' => 'zoomyoerp',
            'folder' => '/ERP/Amazon/',
            'url' => 'https://zoomyoerp.fra1.digitaloceanspaces.com/',
            'endpoint' => 'https://zoomyoerp.fra1.digitaloceanspaces.com',
            'bucket_endpoint' => true,
            'visibility' => 'public',
        ]);
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
