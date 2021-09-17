<?php

namespace App\Providers;

use App\Repositories\BaseRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Implementation\BaseRepository;
use App\Repositories\Implementation\CategoryRepository;
use App\Repositories\Implementation\OptionValueRepository;
use App\Repositories\Implementation\ProductRepository;
use App\Repositories\Implementation\UserOrderRepository;
use App\Repositories\Implementation\UserRepository;
use App\Repositories\OptionValueRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\UserOrderRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        BaseRepositoryInterface::class => BaseRepository::class,
        CategoryRepositoryInterface::class => CategoryRepository::class,
        ProductRepositoryInterface::class => ProductRepository::class,
        OptionValueRepositoryInterface::class => OptionValueRepository::class,
        UserOrderRepositoryInterface::class => UserOrderRepository::class,
        UserRepositoryInterface::class => UserRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
