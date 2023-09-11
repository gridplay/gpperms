<?php
namespace GPPerms;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
class GPPermsServiceProvider extends ServiceProvider {
	protected $defer = false;
    public function register() {
        //
    }
    public function provides() {
        return ['gpperms'];
    }
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../database/migrations/create_gpperms.php' => database_path('migrations/create_gpperms.php'),
        ], 'gpperms-migrations');
    }
}