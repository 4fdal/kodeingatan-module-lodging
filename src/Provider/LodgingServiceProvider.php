<?php

namespace Kodeingatan\Lodging\Provider;

use Illuminate\Routing\Router;
use Kodeingatan\Lodging\Lodging;
use Illuminate\Support\ServiceProvider;
use Kodeingatan\Lodging\Console\Commands\AboutCommand;
use Kodeingatan\Lodging\Facades\Lodging as FacadesLodging;
use Kodeingatan\Lodging\Console\Commands\InstallationCommand;
use Kodeingatan\Lodging\Console\Commands\KiAdminLodgingPermissionCommand;

class LodgingServiceProvider extends ServiceProvider
{
    public function register()
    {
        require __DIR__ . "/../helpers.php";

        $this->app->bind('kodeingatan/lodging', function ($app) {
            return new FacadesLodging();
        });

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Lodging', Lodging::class);

        $this->mergeConfigFrom(module_lodging_path("/config/lodging.php"), 'lodging');
    }

    public function boot()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth', \App\Http\Middleware\Authenticate::class);
        $router->aliasMiddleware('permission', \App\Http\Middleware\ValidateRolePermission::class);

        $this->loadCommands();
        $this->loadRoutesFrom(module_lodging_path("/routes/web.php"));
        $this->loadRoutesFrom(module_lodging_path("/routes/admin.php"));
        $this->loadRoutesFrom(module_lodging_path("/routes/api.php"));
        $this->loadTranslationsFrom(module_lodging_path("/resources/lang"), 'lodging');
        $this->loadViewsFrom(module_lodging_path("/resources/views"), 'lodging');
        $this->loadMigrationsFrom(module_lodging_path("/database/migrations"));

        $this->publishConfigs();
    }

    public function publishConfigs()
    {
        $this->publishes([
            module_lodging_path("/config/lodging.php") => config_path('lodging.php'),
        ], 'lodging-configs');
    }

    public function loadCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AboutCommand::class,
                InstallationCommand::class,
                KiAdminLodgingPermissionCommand::class,
            ]);
        }
    }
}
