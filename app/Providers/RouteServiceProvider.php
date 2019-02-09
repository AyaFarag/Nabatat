<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    protected $webNamespace   = "App\Http\Controllers";
    protected $apiNamespace   = "App\Http\Controllers\Api";
    protected $adminNamespace = "App\Http\Controllers\Admin";

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this -> mapApiRoutes();

        $this -> mapWebRoutes();

        $this -> mapAdminRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware("web")
            -> namespace($this -> webNamespace)
            -> group(base_path("routes/web.php"));
    }

    protected function mapApiRoutes()
    {
        Route::prefix("api")
            -> middleware("api", "apikey")
            -> namespace($this -> apiNamespace)
            -> group(base_path("routes/api.php"));
    }

    protected function mapAdminRoutes() {
        Route::prefix("admin")
            -> middleware("web")
            -> namespace($this -> adminNamespace)
            -> group(base_path("routes/admin.php"));
    }
}
