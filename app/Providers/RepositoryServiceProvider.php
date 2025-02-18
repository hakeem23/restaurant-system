<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\IngredientRepositoryInterface;
use App\Repositories\IngredientRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind interfaces to implementations
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
    }

    public function boot()
    {
        //
    }
}
