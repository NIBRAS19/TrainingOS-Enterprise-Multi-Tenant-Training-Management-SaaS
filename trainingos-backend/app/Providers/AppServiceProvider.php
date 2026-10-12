<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Support\TenantContext;
class AppServiceProvider extends ServiceProvider
{
 public function register(): void { $this->app->singleton(TenantContext::class,fn()=>new TenantContext()); }
 public function boot(): void {}
}
